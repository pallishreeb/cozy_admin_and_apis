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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('address')->nullable();
            $table->integer('experience')->nullable();
            $table->decimal('rate', 8, 2)->nullable();
            $table->string('category')->nullable();
            $table->text('specialization')->nullable();
            $table->string('portfolio')->nullable();
            $table->string('profile_pic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
    }
};
