<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deduplication_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('ignore_hyphens')->default(true);
            $table->boolean('ignore_spaces')->default(true);
            $table->boolean('ignore_special_characters')->default(true);
            $table->boolean('ignore_leading_zeros')->default(false);
            $table->integer('fuzzy_match_threshold')->default(85);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deduplication_settings');
    }
};
