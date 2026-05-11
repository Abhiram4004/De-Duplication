<?php

namespace App\Http\Controllers;

use App\Models\UploadedFile;
use App\Models\PriceList;
use App\Models\DuplicateGroup;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_uploads' => UploadedFile::count(),
            'total_records' => PriceList::count(),
            'total_duplicates' => DuplicateGroup::count(),
            'pending_review' => DuplicateGroup::where('status', 'pending')->count(),
            'resolved' => DuplicateGroup::where('status', 'resolved')->count(),
        ];

        return view('dashboard', compact('stats'));
    }
}
