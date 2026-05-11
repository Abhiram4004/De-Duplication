<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('duplicate_groups', function (Blueprint $table) {
            $table->id();
            $table->string('group_code')->unique();
            $table->string('match_type'); // exact, formatting, typo, vendor, item
            $table->integer('confidence_score');
            $table->string('status')->default('pending'); // pending, resolved, ignored
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('duplicate_groups');
    }
};
