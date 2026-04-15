<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 20)->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->string('address')->nullable()->after('phone');
            }
            if (! Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('address');
            }
            if (! Schema::hasColumn('users', 'gender')) {
                $table->string('gender', 10)->nullable()->after('date_of_birth');
            }
            if (! Schema::hasColumn('users', 'emergency_contact')) {
                $table->string('emergency_contact')->nullable()->after('gender');
            }
            if (! Schema::hasColumn('users', 'specialization')) {
                $table->string('specialization')->nullable()->after('emergency_contact');
            }
            if (! Schema::hasColumn('users', 'salary')) {
                $table->decimal('salary', 10, 2)->nullable()->after('specialization');
            }
            if (! Schema::hasColumn('users', 'join_date')) {
                $table->date('join_date')->nullable()->after('salary');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['phone', 'address', 'date_of_birth', 'gender', 'emergency_contact', 'specialization', 'salary', 'join_date'];
            $existing = array_filter($columns, fn ($col) => Schema::hasColumn('users', $col));
            if (! empty($existing)) {
                $table->dropColumn($existing);
            }
        });
    }
};
