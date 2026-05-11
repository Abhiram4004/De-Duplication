@extends('layouts.app')

@section('breadcrumbs')
    <i data-lucide="home" class="h-4 w-4 mr-2"></i> Dashboard
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Dashboard Overview</h1>
    <p class="mt-1 text-sm text-slate-500">A high-level view of your data deduplication system across MySQL and MongoDB.</p>
</div>

<!-- Metrics Grid -->
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-8">
    <!-- Total Uploads -->
    <div class="bg-white overflow-hidden rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-blue-400 to-brand-600 rounded-xl p-3 shadow-lg shadow-blue-500/30">
                    <i data-lucide="cloud-upload" class="h-6 w-6 text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 truncate">Total Files Uploaded</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-slate-900">{{ $stats['total_uploads'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Records -->
    <div class="bg-white overflow-hidden rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-xl p-3 shadow-lg shadow-emerald-500/30">
                    <i data-lucide="database" class="h-6 w-6 text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 truncate">Total Price Lists</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-slate-900">{{ $stats['total_records'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Review -->
    <div class="bg-white overflow-hidden rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300 relative">
        @if($stats['pending_review'] > 0)
            <div class="absolute top-0 right-0 w-2 h-full bg-gradient-to-b from-amber-300 to-amber-500"></div>
        @endif
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl p-3 shadow-lg shadow-amber-500/30">
                    <i data-lucide="alert-triangle" class="h-6 w-6 text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 truncate">Pending Reviews</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-slate-900">{{ $stats['pending_review'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Resolved -->
    <div class="bg-white overflow-hidden rounded-2xl border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:-translate-y-1 transition-transform duration-300">
        <div class="p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-gradient-to-br from-purple-400 to-indigo-600 rounded-xl p-3 shadow-lg shadow-indigo-500/30">
                    <i data-lucide="check-square" class="h-6 w-6 text-white"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="text-sm font-medium text-slate-500 truncate">Resolved Duplicates</dt>
                        <dd class="flex items-baseline">
                            <div class="text-2xl font-semibold text-slate-900">{{ $stats['resolved'] }}</div>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Architecture Info -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm">
        <div class="px-6 py-5 border-b border-slate-200">
            <h3 class="text-base leading-6 font-semibold text-slate-900">System Architecture</h3>
            <p class="mt-1 text-sm text-slate-500">Live Dual-Database Infrastructure</p>
        </div>
        <div class="p-6 space-y-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-blue-50 rounded-md p-2 mt-1 border border-blue-100">
                    <i data-lucide="database" class="h-5 w-5 text-blue-600"></i>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-bold text-slate-900">MySQL Database (Active)</h4>
                    <p class="text-sm text-slate-500 mt-1">Handling structured business records, users, and core settings. Ensures transactional integrity for merges.</p>
                </div>
            </div>
            <div class="flex items-start">
                <div class="flex-shrink-0 bg-emerald-50 rounded-md p-2 mt-1 border border-emerald-100">
                    <i data-lucide="leaf" class="h-5 w-5 text-emerald-600"></i>
                </div>
                <div class="ml-4">
                    <h4 class="text-sm font-bold text-slate-900">MongoDB Database (Active)</h4>
                    <p class="text-sm text-slate-500 mt-1">Handling massive unstructured log data: raw uploads, fuzzy matches, and detailed system audit logs.</p>
                </div>
            </div>
        </div>
        <div class="bg-slate-50 px-6 py-3 border-t border-slate-200 text-sm">
            <a href="{{ route('settings.index') }}" class="font-medium text-brand-600 hover:text-brand-500 flex items-center">
                Configure Deduplication Settings <i data-lucide="arrow-right" class="h-4 w-4 ml-1"></i>
            </a>
        </div>
    </div>
</div>
@endsection
