<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('uploaded_file_id')->constrained()->onDelete('cascade');
            $table->string('pl_number_original')->index();
            $table->string('pl_number_normalized')->index();
            $table->string('item_name')->nullable();
            $table->string('vendor_name')->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->date('effective_date')->nullable();
            $table->string('status')->default('active'); // active, merged, rejected, duplicate
            $table->boolean('is_canonical')->default(true);
            $table->unsignedBigInteger('duplicate_of_id')->nullable();
            $table->foreign('duplicate_of_id')->references('id')->on('price_lists')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_lists');
    }
};
