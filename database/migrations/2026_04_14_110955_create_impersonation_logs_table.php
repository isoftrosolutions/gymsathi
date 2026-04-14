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
        Schema::create('impersonation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('impersonated_tenant_id')->constrained()->onDelete('cascade');
            $table->foreignId('impersonated_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('reason');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->json('session_data')->nullable(); // Store session info for audit
            $table->string('ip_address');
            $table->text('user_agent');
            $table->timestamps();

            $table->index(['admin_user_id', 'started_at']);
            $table->index(['impersonated_tenant_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impersonation_logs');
    }
};
