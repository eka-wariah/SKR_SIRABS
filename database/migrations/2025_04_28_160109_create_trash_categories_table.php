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
        Schema::create('trash_categories', function (Blueprint $table) {
            $table->bigIncrements('trc_id');
            $table->string('trc_name');
            $table->BigInteger('trc_price');
            $table->timestamps();
            $table->renameColumn('updated_at', 'trc_updated_at');
            $table->renameColumn('created_at', 'trc_created_at');
            $table->unsignedBigInteger('trc_created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('trc_deleted_by')->unsigned()->nullable();
            $table->unsignedBigInteger('trc_updated_by')->unsigned()->nullable();
      
            $table->softDeletes();
            $table->renameColumn('deleted_at', 'trc_deleted_at');
            $table->string('trc_sys_note')->nullable();


            $table->foreign('trc_created_by')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('trc_updated_by')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('trc_deleted_by')->references('usr_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trash_categories');
    }
};
