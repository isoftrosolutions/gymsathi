<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Disable foreign keys
        DB::statement('PRAGMA foreign_keys = OFF');

        // Check and fix impersonation_logs foreign keys
        $foreignKeys = DB::select('PRAGMA foreign_key_list(impersonation_logs)');

        foreach ($foreignKeys as $fk) {
            if ($fk->table === 'impersonated_tenants') {
                // Drop the incorrect foreign key
                DB::statement("ALTER TABLE impersonation_logs DROP CONSTRAINT IF EXISTS {$fk->name}");
            }
        }

        // Re-enable foreign keys
        DB::statement('PRAGMA foreign_keys = ON');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
