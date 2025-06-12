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
            $table->unsignedBigInteger('pyn_user_id');
            $table->unsignedBigInteger('pyn_treasurer_id')->nullable();
            $table->unsignedBigInteger('pyn_payment_category_id')->nullable();
            $table->decimal('jumlah_bayar', 15, 2); 
            $table->enum('metode_bayar', ['bank_sampah', 'digital']);
            $table->enum('status', ['lunas', 'pending', 'gagal'])->default('lunas');
            $table->enum('pyn_status_submission', ['Belum Diserahkan', 'Menunggu Konfirmasi', 'Sudah Dikonfirmasi'])->default('Belum Diserahkan');
        
            $table->timestamps();
            $table->renameColumn('updated_at', 'pyn_updated_at');
            $table->renameColumn('created_at', 'pyn_created_at');
            $table->unsignedBigInteger('pyn_created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('pyn_deleted_by')->unsigned()->nullable();
            $table->unsignedBigInteger('pyn_updated_by')->unsigned()->nullable();
      
            $table->softDeletes();
            $table->renameColumn('deleted_at', 'pyn_deleted_at');
            $table->string('pyn_sys_note')->nullable();
        
            
            $table->foreign('pyn_user_id')->references('usr_id')->on('users')->onDelete('cascade');
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
