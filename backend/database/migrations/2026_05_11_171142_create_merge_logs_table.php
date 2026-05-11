<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merge_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('duplicate_group_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('canonical_price_list_id')->constrained('price_lists')->onDelete('cascade');
            $table->json('merged_price_list_ids'); // array of IDs that were merged
            $table->foreignId('merged_by')->constrained('users')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merge_logs');
    }
};
