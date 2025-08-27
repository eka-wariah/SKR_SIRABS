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
        Schema::create('wastebank_cashes', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('type', ['Masuk', 'Keluar']);
            $table->unsignedBigInteger('usr_id')->nullable(); // petugas/warga
            $table->unsignedBigInteger('amount');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        
            $table->foreign('usr_id')->references('usr_id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_bank_cashes');
    }
};
