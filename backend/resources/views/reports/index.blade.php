@extends('layouts.app')

@section('breadcrumbs')
    <i data-lucide="bar-chart-2" class="h-4 w-4 mr-2"></i> Reports
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Reports & Exports</h1>
    <p class="mt-1 text-sm text-slate-500">View overall data health and export the fully cleaned, deduplicated canonical dataset.</p>
</div>

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <div class="bg-white overflow-hidden rounded-xl border border-slate-200 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-2 h-full bg-emerald-500"></div>
        <div class="p-5">
            <dt class="text-sm font-medium text-slate-500 truncate">Active Clean Records</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">{{ $stats['active_records'] }}</dd>
        </div>
    </div>
    <div class="bg-white overflow-hidden rounded-xl border border-slate-200 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-2 h-full bg-blue-500"></div>
        <div class="p-5">
            <dt class="text-sm font-medium text-slate-500 truncate">Merged Records</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">{{ $stats['merged_records'] }}</dd>
        </div>
    </div>
    <div class="bg-white overflow-hidden rounded-xl border border-slate-200 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-2 h-full bg-indigo-500"></div>
        <div class="p-5">
            <dt class="text-sm font-medium text-slate-500 truncate">Total Groups Detected</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">{{ $stats['total_groups'] }}</dd>
        </div>
    </div>
    <div class="bg-white overflow-hidden rounded-xl border border-slate-200 shadow-sm relative overflow-hidden">
        <div class="absolute top-0 right-0 w-2 h-full bg-slate-400"></div>
        <div class="p-5">
            <dt class="text-sm font-medium text-slate-500 truncate">Resolved Groups</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-slate-900">{{ $stats['resolved_groups'] }}</dd>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden flex flex-col h-full">
        <div class="p-6 flex-1">
            <div class="flex items-center mb-4">
                <div class="bg-brand-50 rounded-lg p-3 mr-4">
                    <i data-lucide="download-cloud" class="h-6 w-6 text-brand-600"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Cleaned Master Price List</h3>
                    <p class="text-sm text-slate-500">The final, deduplicated dataset containing only canonical and unique records.</p>
                </div>
            </div>
            <ul class="mt-4 space-y-2 text-sm text-slate-600 list-disc list-inside">
                <li>Excludes all merged duplicates</li>
                <li>Includes normalized vendor names</li>
                <li>CSV format ready for ERP import</li>
            </ul>
        </div>
        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
            <a href="{{ route('reports.download', 'cleaned') }}" class="w-full flex justify-center items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-colors">
                <i data-lucide="file-spreadsheet" class="h-4 w-4 mr-2 text-slate-400"></i> Download CSV Export
            </a>
        </div>
    </div>
</div>
@endsection
