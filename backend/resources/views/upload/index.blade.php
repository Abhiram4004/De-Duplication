@extends('layouts.app')

@section('breadcrumbs')
    <i data-lucide="upload-cloud" class="h-4 w-4 mr-2"></i> Import Data
@endsection

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Upload Price List</h1>
    <p class="mt-1 text-sm text-slate-500">Upload CSV or Excel files. Raw rows will be logged to MongoDB, structured records to MySQL.</p>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm mb-8 overflow-hidden">
    <div class="p-8 border-b border-slate-100">
        <form action="{{ route('upload.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl mx-auto">
            @csrf
            <div class="mt-2 flex justify-center rounded-lg border border-dashed border-slate-300 px-6 py-10 hover:bg-slate-50 transition-colors bg-white">
                <div class="text-center">
                    <i data-lucide="file-spreadsheet" class="mx-auto h-12 w-12 text-slate-300"></i>
                    <div class="mt-4 flex text-sm leading-6 text-slate-600 justify-center">
                        <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-brand-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-brand-600 focus-within:ring-offset-2 hover:text-brand-500">
                            <span>Upload a file</span>
                            <input id="file-upload" name="file" type="file" class="sr-only" accept=".csv,.xlsx,.xls" required>
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs leading-5 text-slate-500">CSV, XLS up to 10MB</p>
                </div>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center rounded-md bg-brand-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-brand-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 transition-all">
                    <i data-lucide="play" class="h-4 w-4 mr-2"></i> Process Import
                </button>
            </div>
        </form>
    </div>
</div>

<div class="mb-4 flex items-center justify-between">
    <h2 class="text-lg font-semibold text-slate-900">Upload History</h2>
</div>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-50">
            <tr>
                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">File Name</th>
                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Date</th>
                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-slate-900 uppercase tracking-wider">Uploaded By</th>
                <th scope="col" class="px-3 py-3.5 text-right text-xs font-semibold text-slate-900 uppercase tracking-wider">Records</th>
                <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-slate-900 uppercase tracking-wider">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-200 bg-white">
            @forelse($uploads as $upload)
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-slate-900">
                        <div class="flex items-center">
                            <i data-lucide="file-text" class="h-4 w-4 text-slate-400 mr-2"></i>
                            {{ $upload->original_filename }}
                        </div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $upload->created_at->format('M d, Y H:i') }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-500">{{ $upload->user->name }}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-slate-900 text-right font-medium">{{ number_format($upload->total_records) }}</td>
                    <td class="whitespace-nowrap px-6 py-4 text-sm text-center">
                        @if($upload->status === 'completed')
                            <span class="inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Completed</span>
                        @elseif($upload->status === 'processing')
                            <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20">Processing</span>
                        @else
                            <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Failed</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-sm text-slate-500">No uploads found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
