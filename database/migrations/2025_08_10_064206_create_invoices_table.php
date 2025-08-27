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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('inv_id');
            $table->unsignedBigInteger('household_id');
            $table->unsignedBigInteger('payment_category_id');
    
            $table->string('invoice_number')->unique();
            $table->string('periode', 7);
            $table->date('due_date')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('status', ['pending', 'lunas', 'gagal'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
    
        
            $table->foreign('payment_category_id')->references('pym_id')->on('payment_categories')->onDelete('cascade');
            $table->foreign('household_id')->references('id')->on('households')->onDelete('cascade');
            $table->index(['household_id', 'periode', 'payment_category_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
