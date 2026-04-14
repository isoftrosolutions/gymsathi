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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('subscription_id')->nullable()->constrained()->onDelete('set null');
            $table->string('reference_id')->nullable(); // eSewa/Khalti transaction ID
            $table->enum('method', ['esewa', 'khalti', 'bank_transfer', 'cash', 'manual']);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->decimal('amount', 10, 2);
            $table->decimal('fee', 8, 2)->default(0); // Payment gateway fee
            $table->string('currency', 3)->default('NPR');
            $table->date('payment_date');
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable(); // Additional payment data
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index(['payment_date']);
            $table->index(['method']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
