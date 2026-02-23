@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
        <p class="mt-2 text-sm text-gray-600">Today's activity overview</p>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['total_today'] }}</div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Activities Today</dt>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="text-2xl font-bold text-green-600">{{ $stats['completed_today'] }}</div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Completed</dt>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_today'] }}</div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Pending</dt>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activities</h3>
            <div class="space-y-4">
                @forelse($recentActivities as $activity)
                <div class="border-l-4 {{ $activity->status === 'done' ? 'border-green-500' : 'border-yellow-500' }} pl-4 py-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900">{{ $activity->title }}</h4>
                            <p class="text-xs text-gray-500 mt-1">Created by {{ $activity->creator->name }}</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $activity->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <p class="text-gray-500 text-sm">No activities for today</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
