<?php

namespace App\Http\Controllers;

use App\Models\MergeLog;

class MergeLogController extends Controller
{
    public function index()
    {
        $logs = MergeLog::with('mergedBy', 'group')->latest()->paginate(50);
        return view('merge_logs.index', compact('logs'));
    }
}
