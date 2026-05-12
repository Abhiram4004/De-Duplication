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
            'ignore_special_characters' => true,
            'ignore_leading_zeros' => false,
            'fuzzy_match_threshold' => 85,
        ]);
        
        return view('settings.index', compact('settings'));
    }

    public function store(Request $request)
    {
        $settings = DeduplicationSetting::first();
        
        $settings->update([
            'ignore_spaces' => $request->has('ignore_spaces'),
            'ignore_hyphens' => $request->has('ignore_hyphens'),
            'ignore_special_characters' => $request->has('ignore_special_characters'),
            'ignore_leading_zeros' => $request->has('ignore_leading_zeros'),
            'fuzzy_match_threshold' => $request->input('fuzzy_match_threshold', 85),
        ]);

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully.');
    }
}
