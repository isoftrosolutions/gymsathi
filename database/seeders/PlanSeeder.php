<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'price' => 2500.00, // NPR 2,500
                'max_members' => 100,
                'features' => [
                    'Member management',
                    'Basic attendance tracking',
                    'Monthly reports',
                    'Email support',
                ],
                'trial_days' => 14,
                'is_active' => true,
            ],
            [
                'name' => 'Standard',
                'slug' => 'standard',
                'price' => 5000.00, // NPR 5,000
                'max_members' => 500,
                'features' => [
                    'All Basic features',
                    'Advanced attendance tracking',
                    'WhatsApp notifications',
                    'Payment integration (eSewa/Khalti)',
                    'Weekly reports',
                    'Priority support',
                ],
                'trial_days' => 14,
                'is_active' => true,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'price' => 10000.00, // NPR 10,000
                'max_members' => null, // Unlimited
                'features' => [
                    'All Standard features',
                    'Advanced analytics',
                    'Custom reports',
                    'API access',
                    'White-label option',
                    '24/7 phone support',
                    'Dedicated account manager',
                ],
                'trial_days' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
