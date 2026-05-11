@extends('layouts.app')

@section('breadcrumbs')
    <i data-lucide="shield-alert" class="h-4 w-4 mr-2"></i> Audit Logs
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Audit Logs (MongoDB)</h1>
    <p class="mt-1 text-sm text-slate-500">High-volume system event logs sourced directly from the MongoDB analytics cluster.</p>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Timestamp</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Action</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">User ID</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Raw Metadata</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($logs as $log)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm text-slate-500">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm font-medium">
                            @if($log->action === 'merge')
                                <span class="inline-flex items-center rounded bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/20 uppercase tracking-wider">Merge</span>
                            @elseif($log->action === 'reject')
                                <span class="inline-flex items-center rounded bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20 uppercase tracking-wider">Reject</span>
                            @else
                                <span class="inline-flex items-center rounded bg-slate-100 px-2 py-1 text-xs font-medium text-slate-700 ring-1 ring-inset ring-slate-600/20 uppercase tracking-wider">{{ $log->action }}</span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-700">{{ $log->description }}</td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500 font-mono">{{ $log->user_id }}</td>
                        <td class="px-3 py-4 text-xs text-slate-400 font-mono max-w-xs truncate">
                            {{ is_array($log->metadata) ? json_encode($log->metadata) : $log->metadata }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <i data-lucide="database" class="mx-auto h-12 w-12 text-slate-300 mb-3"></i>
                            <p class="text-sm text-slate-500">No MongoDB audit logs found.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection
