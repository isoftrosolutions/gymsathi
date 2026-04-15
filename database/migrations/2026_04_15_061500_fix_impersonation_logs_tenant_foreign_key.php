<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('impersonation_logs')) {
            return;
        }

        $foreignKeys = DB::select('PRAGMA foreign_key_list(impersonation_logs)');

        $tenantForeignKey = collect($foreignKeys)->firstWhere('from', 'impersonated_tenant_id');
        if (! $tenantForeignKey) {
            return;
        }

        if (($tenantForeignKey->table ?? null) === 'tenants') {
            return;
        }

        Schema::disableForeignKeyConstraints();

        // Drop existing indexes before renaming
        $indexes = DB::select('PRAGMA index_list(impersonation_logs)');
        foreach ($indexes as $index) {
            if (str_starts_with($index->name, 'impersonation_logs_')) {
                DB::statement("DROP INDEX IF EXISTS {$index->name}");
            }
        }

        Schema::rename('impersonation_logs', 'impersonation_logs_old');

        Schema::create('impersonation_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('impersonated_tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('impersonated_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('reason');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->json('session_data')->nullable();
            $table->string('ip_address');
            $table->text('user_agent');
            $table->timestamps();

            $table->index(['admin_user_id', 'started_at']);
            $table->index(['impersonated_tenant_id']);
        });

        $columns = [
            'id',
            'admin_user_id',
            'impersonated_tenant_id',
            'impersonated_user_id',
            'reason',
            'started_at',
            'ended_at',
            'session_data',
            'ip_address',
            'user_agent',
            'created_at',
            'updated_at',
        ];

        $rows = DB::table('impersonation_logs_old')->get($columns);
        if ($rows->isNotEmpty()) {
            $payload = $rows->map(function (object $row) use ($columns): array {
                $data = [];
                foreach ($columns as $column) {
                    $data[$column] = $row->{$column};
                }

                return $data;
            });

            $payload->chunk(50)->each(function ($chunk): void {
                DB::table('impersonation_logs')->insert($chunk->all());
            });
        }

        Schema::drop('impersonation_logs_old');

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op: reverting would reintroduce an invalid foreign key in SQLite.
    }
};
