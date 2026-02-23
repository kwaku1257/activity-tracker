@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $activity->title }}</h1>
            <p class="mt-2 text-sm text-gray-600">Activity details and update history</p>
        </div>
        <a href="{{ route('activities.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Activities</a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <p class="mt-1 text-sm text-gray-900">{{ $activity->description ?: 'No description' }}</p>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Date</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $activity->date->format('F d, Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <span class="mt-1 inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $activity->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($activity->status) }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created By</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $activity->creator->name }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $activity->created_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Update Status</h2>
        <form method="POST" action="{{ route('activities.update-status', $activity) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        <option value="pending" {{ $activity->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="done" {{ $activity->status === 'done' ? 'selected' : '' }}>Done</option>
                    </select>
                </div>
                <div>
                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                    <textarea name="remarks" id="remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Add any remarks about this update..."></textarea>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">Update Status</button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Update History</h2>
        <div class="space-y-4">
            @forelse($activity->updates as $update)
            <div class="border-l-4 border-indigo-500 pl-4 py-2">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">
                            {{ $update->user->name }}
                            @if($update->user->employee_id)
                            <span class="text-gray-500">({{ $update->user->employee_id }})</span>
                            @endif
                            @if($update->user->department)
                            <span class="text-gray-500">- {{ $update->user->department }}</span>
                            @endif
                            @if($update->old_status)
                            <span class="text-gray-500">changed status from</span>
                            <span class="font-semibold">{{ ucfirst($update->old_status) }}</span>
                            <span class="text-gray-500">to</span>
                            <span class="font-semibold">{{ ucfirst($update->new_status) }}</span>
                            @else
                            <span class="text-gray-500">set status to</span>
                            <span class="font-semibold">{{ ucfirst($update->new_status) }}</span>
                            @endif
                        </p>
                        @if($update->remarks)
                        <p class="text-sm text-gray-600 mt-1">{{ $update->remarks }}</p>
                        @endif
                    </div>
                    <span class="text-xs text-gray-500">{{ $update->created_at->format('M d, Y H:i') }}</span>
                </div>
            </div>
            @empty
            <p class="text-gray-500 text-sm">No updates yet</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
