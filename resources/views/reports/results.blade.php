@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Report Results</h1>
            <p class="mt-2 text-sm text-gray-600">
                {{ \Carbon\Carbon::parse($validated['start_date'])->format('M d, Y') }} to 
                {{ \Carbon\Carbon::parse($validated['end_date'])->format('M d, Y') }}
            </p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('reports.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">New Query</a>
            <form method="GET" action="{{ route('reports.export') }}" class="inline">
                @foreach($validated as $key => $value)
                    @if($value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endif
                @endforeach
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm font-medium hover:bg-green-700">Export CSV</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                <div class="text-sm font-medium text-gray-500">Total Activities</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</div>
                <div class="text-sm font-medium text-gray-500">Completed</div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
                <div class="text-sm font-medium text-gray-500">Pending</div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created By</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updates</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Update</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($activities as $activity)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->date->format('M d, Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">{{ $activity->title }}</div>
                        @if($activity->description)
                        <div class="text-sm text-gray-500">{{ Str::limit($activity->description, 50) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $activity->status === 'done' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->creator->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $activity->updates->count() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if($activity->updates->first())
                        {{ $activity->updates->first()->created_at->format('M d, Y H:i') }}
                        @else
                        N/A
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No activities found for the selected date range</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
