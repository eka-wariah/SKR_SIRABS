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
        Schema::create('registration_waters', function (Blueprint $table) {
            $table->bigIncrements('rgw_id');

            // FK household_id (tabel households punya kolom id)
            $table->unsignedBigInteger('rgw_household_id')->nullable();
            $table->foreign('rgw_household_id')->references('id')->on('households')->onDelete('cascade');

            // FK applicant_id (tabel users pakai usr_id)
            $table->unsignedBigInteger('rgw_applicant_id')->nullable();
            $table->foreign('rgw_applicant_id')->references('usr_id')->on('users')->nullOnDelete();

            $table->date('rgw_registration_date');
            $table->enum('rgw_status', ['Menunggu Verifikasi', 'Sedang Proses Pemasangan', 'Aktif', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->text('rgw_notes')->nullable();
            $table->string('address')->nullable();
            $table->string('rgw_house_photo')->nullable();

            $table->unsignedBigInteger('rgw_verified_by')->nullable();
            $table->foreign('rgw_verified_by')->references('usr_id')->on('users')->nullOnDelete();

            $table->timestamp('rgw_verified_at')->nullable();
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_waters');
    }
};
