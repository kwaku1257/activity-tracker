<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function query(Request $request)
    {
        try {
            $validated = $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'status' => 'nullable|in:pending,done',
                'user_id' => 'nullable|exists:users,id',
            ]);

            // find activities where either the activity date or update date falls in range
            $query = Activity::with(['creator', 'updates.user'])
                ->where(function($q) use ($validated) {
                    $q->whereBetween('date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereHas('updates', function($subQ) use ($validated) {
                          // include activities that were updated in this period
                          $subQ->whereBetween('created_at', [
                              $validated['start_date'] . ' 00:00:00',
                              $validated['end_date'] . ' 23:59:59'
                          ]);
                      });
                });

            if ($request->filled('status')) {
                $query->where('status', $validated['status']);
            }

            if ($request->filled('user_id')) {
                $query->where('created_by', $validated['user_id']);
            }

            $activities = $query->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();

            // calculate summary statistics
            $stats = [
                'total' => $activities->count(),
                'completed' => $activities->where('status', 'done')->count(),
                'pending' => $activities->where('status', 'pending')->count(),
            ];

            return view('reports.results', compact('activities', 'stats', 'validated'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('reports.index')
                ->withErrors($e->errors())
                ->withInput();
        }
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'nullable|in:pending,done',
        ]);

        $query = Activity::with(['creator', 'updates.user'])
            ->where(function($q) use ($validated) {
                $q->whereBetween('date', [$validated['start_date'], $validated['end_date']])
                  ->orWhereHas('updates', function($subQ) use ($validated) {
                      $subQ->whereBetween('created_at', [
                          $validated['start_date'] . ' 00:00:00',
                          $validated['end_date'] . ' 23:59:59'
                      ]);
                  });
            });

        if ($request->filled('status')) {
            $query->where('status', $validated['status']);
        }

        $activities = $query->orderBy('date', 'desc')->get();

        // build CSV data array
        $csvData = [];
        $csvData[] = ['Date', 'Title', 'Status', 'Created By', 'Updates Count', 'Last Updated'];

        foreach ($activities as $activity) {
            $csvData[] = [
                $activity->date->format('Y-m-d'),
                $activity->title,
                $activity->status,
                $activity->creator->name,
                $activity->updates->count(),
                $activity->updates->first()?->created_at->format('Y-m-d H:i:s') ?? 'N/A',
            ];
        }

        $filename = 'activities_report_' . $validated['start_date'] . '_to_' . $validated['end_date'] . '.csv';

        // write CSV to memory stream
        $handle = fopen('php://temp', 'r+');
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return Response::streamDownload(function () use ($content) {
            echo $content;
        }, $filename, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
