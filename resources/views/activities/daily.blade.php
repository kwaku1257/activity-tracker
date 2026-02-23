@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Daily Activities</h1>
            <p class="mt-2 text-sm text-gray-600">View all activities and updates for a specific day</p>
        </div>
        <form method="GET" action="{{ route('activities.daily') }}" class="flex items-center space-x-2">
            <input type="date" name="date" value="{{ $date }}" required class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">View</button>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Activities for {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</h2>
        
        @forelse($activities as $activity)
        <div class="mb-6 pb-6 border-b border-gray-200 last:border-0">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $activity->title }}</h3>
                    @if($activity->description)
                    <p class="text-sm text-gray-600 mt-1">{{ $activity->description }}</p>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">Created by {{ $activity->creator->name }} at {{ $activity->created_at->format('H:i') }}</p>
                </div>
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $activity->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ ucfirst($activity->status) }}
                </span>
            </div>

            @if($activity->updates->where('created_at', '>=', \Carbon\Carbon::parse($date)->startOfDay())->where('created_at', '<=', \Carbon\Carbon::parse($date)->endOfDay())->count() > 0)
            <div class="mt-4 space-y-3">
                <h4 class="text-sm font-medium text-gray-700">Updates on this day:</h4>
                @foreach($activity->updates->where('created_at', '>=', \Carbon\Carbon::parse($date)->startOfDay())->where('created_at', '<=', \Carbon\Carbon::parse($date)->endOfDay()) as $update)
                <div class="bg-gray-50 rounded-md p-3">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm text-gray-900">
                                <span class="font-medium">{{ $update->user->name }}</span>
                                @if($update->user->employee_id)
                                <span class="text-gray-500">({{ $update->user->employee_id }})</span>
                                @endif
                                @if($update->user->department)
                                <span class="text-gray-500">- {{ $update->user->department }}</span>
                                @endif
                                @if($update->old_status)
                                <span class="text-gray-600">changed from</span>
                                <span class="font-semibold">{{ ucfirst($update->old_status) }}</span>
                                <span class="text-gray-600">to</span>
                                <span class="font-semibold">{{ ucfirst($update->new_status) }}</span>
                                @else
                                <span class="text-gray-600">set status to</span>
                                <span class="font-semibold">{{ ucfirst($update->new_status) }}</span>
                                @endif
                            </p>
                            @if($update->remarks)
                            <p class="text-sm text-gray-600 mt-1">{{ $update->remarks }}</p>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 ml-4">{{ $update->created_at->format('H:i:s') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500 mt-3">No updates made on this day</p>
            @endif
        </div>
        @empty
        <p class="text-gray-500">No activities found for this date</p>
        @endforelse
    </div>
</div>
@endsection
