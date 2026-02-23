<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    public function index()
    {
        // eager load relationships to avoid N+1 queries
        $activities = Activity::with(['creator', 'latestUpdate.user'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('activities.index', compact('activities'));
    }

    public function create()
    {
        return view('activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $activity = Activity::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'status' => 'pending', // new activities start as pending
            'created_by' => auth()->id(),
        ]);

        // create initial update record to track creation
        ActivityUpdate::create([
            'activity_id' => $activity->id,
            'user_id' => auth()->id(),
            'old_status' => null,
            'new_status' => 'pending',
            'remarks' => 'Activity created',
        ]);

        return redirect()->route('activities.index')->with('success', 'Activity created successfully.');
    }

    public function show(Activity $activity)
    {
        $activity->load(['creator', 'updates.user']);
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $activity->update($validated);

        return redirect()->route('activities.show', $activity)->with('success', 'Activity updated successfully.');
    }

    public function daily(Request $request)
    {
        // default to today if no date provided
        $date = $request->get('date', now()->toDateString());
        
        // get all activities for the selected date
        $activities = Activity::with(['creator', 'updates.user'])
            ->whereDate('date', $date)
            ->orderBy('created_at', 'asc')
            ->get();

        // get all updates made on this date, grouped by activity
        $updates = ActivityUpdate::with(['activity', 'user'])
            ->whereDate('created_at', $date)
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy('activity_id');

        return view('activities.daily', compact('activities', 'updates', 'date'));
    }

    public function updateStatus(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,done',
            'remarks' => 'nullable|string|max:1000',
        ]);

        // save old status before updating
        $oldStatus = $activity->status;
        
        $activity->update(['status' => $validated['status']]);

        // record who updated and when for audit trail
        ActivityUpdate::create([
            'activity_id' => $activity->id,
            'user_id' => auth()->id(),
            'old_status' => $oldStatus,
            'new_status' => $validated['status'],
            'remarks' => $validated['remarks'],
        ]);

        return redirect()->back()->with('success', 'Activity status updated successfully.');
    }
}
