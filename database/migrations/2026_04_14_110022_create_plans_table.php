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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Basic, Standard, Premium
            $table->string('slug')->unique(); // basic, standard, premium
            $table->decimal('price', 10, 2); // Monthly price in NPR
            $table->integer('max_members')->nullable(); // Max members allowed, null for unlimited
            $table->json('features'); // Array of features included
            $table->boolean('is_active')->default(true);
            $table->integer('trial_days')->default(14); // Free trial period
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
