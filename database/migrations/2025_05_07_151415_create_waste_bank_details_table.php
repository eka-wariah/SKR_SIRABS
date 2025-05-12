<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('waste_bank_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('waste_bank_id');
            $table->unsignedBigInteger('trc_id'); // kategori sampah
            $table->decimal('berat', 8, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();

            $table->foreign('waste_bank_id')->references('id')->on('waste_banks')->onDelete('cascade');
            $table->foreign('trc_id')->references('trc_id')->on('trash_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_bank_details');
    }
};
