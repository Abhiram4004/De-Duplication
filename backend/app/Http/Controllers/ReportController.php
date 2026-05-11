<?php

namespace App\Http\Controllers;

use App\Models\PriceList;
use App\Models\DuplicateGroup;
use App\Models\MergeLog;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'active_records' => PriceList::where('status', 'active')->count(),
            'merged_records' => PriceList::where('status', 'merged')->count(),
            'total_groups' => DuplicateGroup::count(),
            'resolved_groups' => DuplicateGroup::where('status', 'resolved')->count(),
        ];
        
        return view('reports.index', compact('stats'));
    }

    public function download($type)
    {
        if ($type === 'cleaned') {
            $records = PriceList::where('status', 'active')->get();
            $filename = 'cleaned_price_list_' . date('Ymd_His') . '.csv';
        } else {
            abort(404);
        }

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($records) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'PL Number', 'Item Name', 'Vendor Name', 'Price', 'Currency', 'Effective Date']);
            foreach ($records as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->pl_number_original,
                    $row->item_name,
                    $row->vendor_name,
                    $row->price,
                    $row->currency,
                    $row->effective_date
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
