<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Plans
        $basicPlan = \App\Models\Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => 2000,
            'features' => ['Member Records', 'Attendance', '100 Members Max'],
            'trial_days' => 14,
        ]);

        $standardPlan = \App\Models\Plan::create([
            'name' => 'Standard',
            'slug' => 'standard',
            'price' => 5000,
            'features' => ['Member Records', 'Attendance', 'WhatsApp Reminders', '500 Members Max'],
            'trial_days' => 14,
        ]);

        $premiumPlan = \App\Models\Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price' => 10000,
            'features' => ['All Features', 'Priority Support', 'Custom Branding', 'Unlimited Members'],
            'trial_days' => 30,
        ]);

        // 2. Create Permissions (Platform Level)
        $permissions = [
            ['name' => 'Manage Members', 'slug' => 'manage-members'],
            ['name' => 'Track Attendance', 'slug' => 'track-attendance'],
            ['name' => 'View Reports', 'slug' => 'view-reports'],
            ['name' => 'Manage Staff', 'slug' => 'manage-staff'],
            ['name' => 'Configure System', 'slug' => 'configure-system'],
            ['name' => 'Access Member Dashboard', 'slug' => 'member-access'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // 3. Create Super Admin (Platform Level)
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gymsathi.com',
            'password' => bcrypt('password'),
            'platform_role' => 'super_admin',
            'tenant_id' => null,
        ]);

        // 4. Create Sample Tenants with Monitoring Data
        $tenant = Tenant::create([
            'name' => 'Bharatpur Kinetic Gym',
            'slug' => 'bharatpur-kinetic',
            'status' => 'active',
            'plan_id' => $premiumPlan->id,
            'last_sync_at' => now()->subMinutes(15),
            'pending_sync_count' => 2,
        ]);

        Tenant::create([
            'name' => 'Muscle Bank',
            'slug' => 'muscle-bank',
            'status' => 'active',
            'plan_id' => $standardPlan->id,
            'last_sync_at' => now()->subMinutes(2),
            'pending_sync_count' => 0,
        ]);

        Tenant::create([
            'name' => 'Jim Fitness',
            'slug' => 'jim-fitness',
            'status' => 'active',
            'plan_id' => $basicPlan->id,
            'last_sync_at' => now()->subHours(3),
            'pending_sync_count' => 12,
        ]);

        Tenant::create([
            'name' => 'Pro Build',
            'slug' => 'pro-build',
            'status' => 'trial',
            'plan_id' => $premiumPlan->id,
            'last_sync_at' => now()->subDays(2),
            'pending_sync_count' => 45,
        ]);

        // 4. Create Tenant Roles (Scoping manually for seeding)
        $adminRole = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Gym Admin',
            'slug' => 'admin',
        ]);

        $memberRole = Role::create([
            'tenant_id' => $tenant->id,
            'name' => 'Member',
            'slug' => 'member',
        ]);

        // 5. Assign Permissions to Roles
        $allPermissions = Permission::all();
        $adminRole->permissions()->attach($allPermissions->pluck('id'));
        $memberRole->permissions()->attach(
            Permission::whereIn('slug', ['member-access', 'track-attendance'])->pluck('id')
        );

        // 6. Create Tenant Owner (Admin Role)
        User::factory()->create([
            'name' => 'Gym Owner',
            'email' => 'owner@kinetic.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role_id' => $adminRole->id,
            'platform_role' => null,
        ]);

        // 7. Create a Sample Member (Member Role)
        User::factory()->create([
            'name' => 'Alex Runner',
            'email' => 'alex@member.com',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
            'role_id' => $memberRole->id,
            'platform_role' => null,
        ]);
    }
}
