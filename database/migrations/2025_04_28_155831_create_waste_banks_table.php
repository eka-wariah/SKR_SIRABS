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
        Schema::create('waste_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wtb_name_id'); // ID user
            $table->decimal('wtb_total_money', 15, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->renameColumn('deleted_at', 'deleted_at');

            $table->foreign('wtb_name_id')->references('usr_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_banks');
    }
};
