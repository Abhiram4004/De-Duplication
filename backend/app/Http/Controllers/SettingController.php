<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeduplicationSetting;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DeduplicationSetting::firstOrCreate([
            'id' => 1
        ], [
            'ignore_spaces' => true,
            'ignore_hyphens' => true,
            'ignore_special_chars' => true,
            'fuzzy_match_threshold' => 85,
            'auto_merge_exact_matches' => false,
        ]);
        
        return view('settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $settings = DeduplicationSetting::first();
        
        $settings->update([
            'ignore_spaces' => $request->has('ignore_spaces'),
            'ignore_hyphens' => $request->has('ignore_hyphens'),
            'ignore_special_chars' => $request->has('ignore_special_chars'),
            'auto_merge_exact_matches' => $request->has('auto_merge_exact_matches'),
            'fuzzy_match_threshold' => $request->input('fuzzy_match_threshold', 85),
        ]);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
