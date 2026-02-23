<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        
        // calculate today's activity statistics
        $stats = [
            'total_today' => Activity::whereDate('date', $today)->count(),
            'completed_today' => Activity::whereDate('date', $today)->where('status', 'done')->count(),
            'pending_today' => Activity::whereDate('date', $today)->where('status', 'pending')->count(),
        ];

        // get recent activities for today with relationships loaded
        $recentActivities = Activity::with(['creator', 'latestUpdate.user'])
            ->whereDate('date', $today)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard', compact('stats', 'recentActivities'));
    }
}
