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
        $headers = [
            "Content-type"        => "text/csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        if ($type === 'cleaned') {
            $records = PriceList::where('status', 'active')->get();
            $filename = 'cleaned_price_list_' . date('Ymd_His') . '.csv';
            $headers["Content-Disposition"] = "attachment; filename=$filename";
            
            $callback = function() use($records) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'PL Number', 'Item Name', 'Vendor Name', 'Price', 'Currency', 'Effective Date']);
                foreach ($records as $row) {
                    fputcsv($file, [$row->id, $row->pl_number_original, $row->item_name, $row->vendor_name, $row->price, $row->currency, $row->effective_date]);
                }
                fclose($file);
            };
        } elseif ($type === 'duplicates') {
            $records = PriceList::where('status', 'duplicate')->get();
            $filename = 'duplicates_report_' . date('Ymd_His') . '.csv';
            $headers["Content-Disposition"] = "attachment; filename=$filename";
            
            $callback = function() use($records) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'PL Number', 'Item Name', 'Vendor Name', 'Price', 'Currency', 'Status']);
                foreach ($records as $row) {
                    fputcsv($file, [$row->id, $row->pl_number_original, $row->item_name, $row->vendor_name, $row->price, $row->currency, $row->status]);
                }
                fclose($file);
            };
        } elseif ($type === 'rejected') {
            $records = PriceList::where('status', 'rejected')->get();
            $filename = 'rejected_duplicates_report_' . date('Ymd_His') . '.csv';
            $headers["Content-Disposition"] = "attachment; filename=$filename";
            
            $callback = function() use($records) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'PL Number', 'Item Name', 'Vendor Name', 'Price', 'Currency', 'Status']);
                foreach ($records as $row) {
                    fputcsv($file, [$row->id, $row->pl_number_original, $row->item_name, $row->vendor_name, $row->price, $row->currency, $row->status]);
                }
                fclose($file);
            };
        } elseif ($type === 'merges') {
            $records = MergeLog::with('mergedBy')->get();
            $filename = 'merge_history_report_' . date('Ymd_His') . '.csv';
            $headers["Content-Disposition"] = "attachment; filename=$filename";
            
            $callback = function() use($records) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Log ID', 'Group ID', 'Canonical PL ID', 'Merged PL IDs', 'Merged By', 'Date']);
                foreach ($records as $row) {
                    fputcsv($file, [
                        $row->id, 
                        $row->duplicate_group_id, 
                        $row->canonical_price_list_id, 
                        is_array($row->merged_price_list_ids) ? implode(',', $row->merged_price_list_ids) : $row->merged_price_list_ids,
                        $row->mergedBy ? $row->mergedBy->name : 'System',
                        $row->created_at
                    ]);
                }
                fclose($file);
            };
        } else {
            abort(404);
        }

        return response()->stream($callback, 200, $headers);
    }
}
