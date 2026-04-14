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
        // 1. Create Permissions (Platform Level)
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

        // 2. Create Super Admin (Platform Level)
        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gymsathi.com',
            'password' => bcrypt('password'),
            'platform_role' => 'super_admin',
            'tenant_id' => null,
        ]);

        // 3. Create a Sample Tenant
        $tenant = Tenant::create([
            'name' => 'Bharatpur Kinetic Gym',
            'slug' => 'bharatpur-kinetic',
            'status' => 'active',
            'plan' => 'premium',
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
