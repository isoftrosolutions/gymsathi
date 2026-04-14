<?php

namespace Tests\Feature\Admin;

use App\Models\Plan;
use App\Models\Role;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default plan for testing
        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => 2000,
            'features' => ['Feature 1'],
            'trial_days' => 14,
        ]);
    }

    public function test_super_admin_can_add_a_new_gym()
    {
        $admin = User::factory()->create([
            'platform_role' => 'super_admin',
        ]);

        $this->actingAs($admin);

        $response = $this->post(route('admin.tenants.store'), [
            'name' => 'Test Gym',
            'owner_name' => 'John Doe',
            'owner_phone' => '9800000000',
            'city' => 'Kathmandu',
            'address' => 'New Road',
            'plan' => 'basic',
        ]);

        $response->assertRedirect(route('admin.tenants.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('tenants', [
            'name' => 'Test Gym',
            'owner_name' => 'John Doe',
            'owner_phone' => '9800000000',
            'city' => 'Kathmandu',
            'status' => 'pending',
        ]);

        $tenant = Tenant::where('name', 'Test Gym')->first();
        
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => '9800000000@gymsathi.com',
            'tenant_id' => $tenant->id,
        ]);
    }

    public function test_non_admin_cannot_add_a_new_gym()
    {
        $user = User::factory()->create([
            'platform_role' => null,
        ]);

        $this->actingAs($user);

        $response = $this->post(route('admin.tenants.store'), [
            'name' => 'Test Gym',
            'owner_name' => 'John Doe',
            'owner_phone' => '9800000000',
            'city' => 'Kathmandu',
            'plan' => 'basic',
        ]);

        $response->assertStatus(403);
    }
}
