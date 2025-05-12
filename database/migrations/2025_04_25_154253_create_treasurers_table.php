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
        Schema::create('treasurers', function (Blueprint $table) {
            $table->bigIncrements('trs_id');
            $table->unsignedBigInteger('trs_name_id');
            $table->unsignedBigInteger('trs_area_id');
            $table->timestamps();
            $table->renameColumn('updated_at', 'updated_at');
            $table->renameColumn('created_at', 'created_at');
            $table->unsignedBigInteger('trs_created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('trs_deleted_by')->unsigned()->nullable();
            $table->unsignedBigInteger('trs_updated_by')->unsigned()->nullable();
      
            $table->softDeletes();
            $table->renameColumn('deleted_at', 'deleted_at');
            $table->string('trs_sys_note')->nullable();


            $table->foreign('trs_name_id')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('trs_area_id')->references('asc_id')->on('area_scopes')->onDelete('cascade');
            $table->foreign('trs_created_by')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('trs_updated_by')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('trs_deleted_by')->references('usr_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasurers');
    }
};
