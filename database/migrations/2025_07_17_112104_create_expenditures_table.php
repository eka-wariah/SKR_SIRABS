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
        Schema::create('expenditures', function (Blueprint $table) {
            $table->bigIncrements('exp_id');
            $table->unsignedBigInteger('exp_payment_category_id'); // air/sampah
            $table->unsignedBigInteger('exp_by_user_id'); // bendahara
            $table->string('keterangan');
            $table->decimal('jumlah_pengeluaran', 15, 2);
            $table->date('tanggal');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('exp_payment_category_id')->references('pym_id')->on('payment_categories');
            $table->foreign('exp_by_user_id')->references('usr_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenditures');
    }
};
