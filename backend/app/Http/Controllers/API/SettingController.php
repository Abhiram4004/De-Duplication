<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeduplicationSetting;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = DeduplicationSetting::first();
        if (!$settings) {
            $settings = DeduplicationSetting::create([
                'ignore_hyphens' => true,
                'ignore_spaces' => true,
                'ignore_special_characters' => true,
                'ignore_leading_zeros' => false,
                'fuzzy_match_threshold' => 85,
            ]);
        }
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $request->validate([
            'ignore_hyphens' => 'boolean',
            'ignore_spaces' => 'boolean',
            'ignore_special_characters' => 'boolean',
            'ignore_leading_zeros' => 'boolean',
            'fuzzy_match_threshold' => 'integer|min:50|max:100',
        ]);

        $settings = DeduplicationSetting::first();
        $settings->update($request->all());

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'update_settings',
            'description' => 'Updated deduplication settings',
            'metadata' => $request->all()
        ]);

        return response()->json(['message' => 'Settings updated successfully', 'settings' => $settings]);
    }
}
