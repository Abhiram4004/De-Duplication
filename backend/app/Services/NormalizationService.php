<?php

namespace App\Services;

use App\Models\DeduplicationSetting;

class NormalizationService
{
    public function normalize(string $plNumber, DeduplicationSetting $settings): string
    {
        $normalized = trim($plNumber);
        $normalized = strtoupper($normalized);

        if ($settings->ignore_special_characters) {
            $normalized = preg_replace('/[^A-Z0-9\s]/', '', $normalized);
        }

        if ($settings->ignore_hyphens && !$settings->ignore_special_characters) {
            $normalized = str_replace('-', '', $normalized);
        }

        if ($settings->ignore_spaces) {
            $normalized = preg_replace('/\s+/', '', $normalized);
        }

        if ($settings->ignore_leading_zeros) {
            $normalized = preg_replace('/(?<=[A-Z])0+(?=\d)/', '', $normalized); 
            $normalized = ltrim($normalized, '0');
        }

        return $normalized;
    }
}
