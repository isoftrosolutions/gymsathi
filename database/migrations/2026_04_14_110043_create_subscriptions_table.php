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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('plan_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['trial', 'active', 'past_due', 'cancelled', 'expired'])->default('trial');
            $table->decimal('price', 10, 2); // Price at time of subscription
            $table->date('starts_at');
            $table->date('ends_at');
            $table->date('trial_ends_at')->nullable();
            $table->boolean('auto_renew')->default(true);
            $table->json('metadata')->nullable(); // Additional subscription data
            $table->timestamps();

            $table->index(['tenant_id', 'status']);
            $table->index(['ends_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
