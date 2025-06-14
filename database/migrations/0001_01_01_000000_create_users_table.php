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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('usr_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('phone')->nullable();
            $table->unsignedBigInteger('usr_scope_id')->nullable(); 
            $table->foreign('usr_scope_id')->references('asc_id')->on('area_scopes')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->string('village')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('regency')->nullable();
            $table->date('birth_date')->nullable();
         
            $table->text('bio')->nullable();
            //$table->foreign('area_scope_id')->references('asc_id')->on('area_scopes');
            $table->unsignedBigInteger('total_money')->default(0); 
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
