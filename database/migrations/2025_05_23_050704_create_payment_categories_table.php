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
        Schema::create('payment_categories', function (Blueprint $table) {
            $table->bigIncrements('pym_id');
            $table->string('pym_name');
            $table->decimal('pym_total', 15, 2)->default(0);
            $table->timestamps();
            $table->renameColumn('updated_at', 'pym_updated_at');
            $table->renameColumn('created_at', 'pym_created_at');
            $table->unsignedBigInteger('pym_created_by')->unsigned()->nullable();
            $table->unsignedBigInteger('pym_deleted_by')->unsigned()->nullable();
            $table->unsignedBigInteger('pym_updated_by')->unsigned()->nullable();
      
            $table->softDeletes();
            $table->renameColumn('deleted_at', 'pym_deleted_at');
            $table->string('pym_sys_note')->nullable();


            $table->foreign('pym_created_by')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('pym_updated_by')->references('usr_id')->on('users')->onDelete('cascade');
            $table->foreign('pym_deleted_by')->references('usr_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_categories');
    }
};
