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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('pyn_id');

            $table->unsignedBigInteger('pyn_household_id');
            $table->unsignedBigInteger('pyn_paid_by')->nullable();
            $table->unsignedBigInteger('pyn_treasurer_id')->nullable();
            $table->unsignedBigInteger('pyn_payment_category_id')->nullable();

            $table->decimal('jumlah_bayar', 15, 2); 
            $table->enum('metode_bayar', ['bank_sampah', 'digital', 'internal']);
            $table->enum('status', ['lunas', 'pending', 'gagal'])->default('lunas');
            $table->enum('pyn_status_submission', ['Belum Diserahkan', 'Menunggu Konfirmasi', 'Sudah Dikonfirmasi'])->default('Belum Diserahkan');
            $table->string('pyn_periode');

        
            $table->timestamps(); // tetap gunakan created_at, updated_at
            $table->softDeletes(); // gunakan deleted_at

            // Kolom audit
            $table->unsignedBigInteger('pyn_created_by')->nullable();
            $table->unsignedBigInteger('pyn_deleted_by')->nullable();
            $table->unsignedBigInteger('pyn_updated_by')->nullable();
            $table->string('pyn_sys_note')->nullable();

            // Foreign Keys
            $table->foreign('pyn_household_id')->references('id')->on('households')->onDelete('cascade');
            $table->foreign('pyn_paid_by')->references('usr_id')->on('users')->onDelete('set null');
            $table->foreign('pyn_treasurer_id')->references('usr_id')->on('users')->onDelete('set null');
            $table->foreign('pyn_payment_category_id')->references('pym_id')->on('payment_categories')->onDelete('set null');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
