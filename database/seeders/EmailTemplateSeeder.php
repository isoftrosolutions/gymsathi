<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing templates since we are switching to gym-specific slugs
        EmailTemplate::truncate();

        $templates = require base_path('gym_templates.php');

        foreach ($templates as $slug => $data) {
            EmailTemplate::create([
                'slug' => $slug,
                'subject' => $data['subject'],
                'body' => $data['body'],
            ]);
        }
    }
}
