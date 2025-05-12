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
        Schema::create('area_scopes', function (Blueprint $table) {
            $table->bigIncrements('asc_id');
            $table->string('asc_level');
            $table->BigInteger('asc_number');
            $table->timestamps();
            $table->renameColumn('updated_at', 'asc_updated_at');
            $table->renameColumn('created_at', 'asc_created_at');
            // $table->unsignedBigInteger('asc_created_by')->unsigned()->nullable();
            // $table->unsignedBigInteger('asc_deleted_by')->unsigned()->nullable();
            // $table->unsignedBigInteger('asc_updated_by')->unsigned()->nullable();
      
            $table->softDeletes();
            $table->renameColumn('deleted_at', 'asc_deleted_at');
            $table->string('asc_sys_note')->nullable();


            // $table->foreign('asc_created_by')->references('usr_id')->on('users')->onDelete('cascade');
            // $table->foreign('asc_updated_by')->references('usr_id')->on('users')->onDelete('cascade');
            // $table->foreign('asc_deleted_by')->references('usr_id')->on('users')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_scopes');
    }
};
