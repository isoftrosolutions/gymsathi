<?php

namespace App\Console\Commands;

use App\Mail\TemplateMail;
use App\Models\MemberPackage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendRenewalReminders extends Command
{
    protected $signature = 'gym:send-renewal-reminders';

    protected $description = 'Send renewal reminder emails to members whose packages are expiring or overdue';

    public function handle(): int
    {
        $today = now()->toDateString();

        $groups = [
            [
                'slug' => 'fee_reminder_7days',
                'date' => now()->addDays(7)->toDateString(),
                'label' => '7-day reminder',
            ],
            [
                'slug' => 'fee_reminder_3days',
                'date' => now()->addDays(3)->toDateString(),
                'label' => '3-day reminder',
            ],
            [
                'slug' => 'fee_overdue_notice',
                'date' => $today,
                'label' => 'overdue notice',
            ],
        ];

        $sent = 0;
        $failed = 0;

        foreach ($groups as $group) {
            $packages = MemberPackage::whereDate('end_date', $group['date'])
                ->where('status', 'active')
                ->with(['user', 'gymPackage', 'user.tenant'])
                ->get();

            foreach ($packages as $pkg) {
                $user = $pkg->user;
                $tenant = $user?->tenant;

                // Skip if no email or no tenant
                if (! $user || ! $tenant || ! $user->email || str_ends_with($user->email, '@gymsathi.com')) {
                    continue;
                }

                $data = [
                    'member_name' => $user->name,
                    'gym_name' => $tenant->name,
                    'gym_phone' => $tenant->owner_phone ?? '',
                    'plan_name' => $pkg->gymPackage?->name ?? 'Membership',
                    'due_date' => $pkg->end_date,
                    'balance' => 'Rs '.number_format($pkg->gymPackage?->price ?? $pkg->amount_paid),
                    // fee_reminder_7days extra
                    'installment_no' => '1',
                    // fee_overdue_notice extras
                    'fine_applied' => 'Rs 0',
                    'total_payable' => 'Rs '.number_format($pkg->gymPackage?->price ?? $pkg->amount_paid),
                ];

                try {
                    Mail::to($user->email)->send(new TemplateMail($group['slug'], $data));
                    $sent++;
                    Log::info("Renewal {$group['label']} sent to {$user->email} (Package #{$pkg->id})");
                } catch (\Exception $e) {
                    $failed++;
                    Log::warning("Renewal {$group['label']} failed for {$user->email}: {$e->getMessage()}");
                }
            }

            $this->line("  [{$group['label']}] Processed {$packages->count()} packages.");
        }

        $this->info("Done. Sent: {$sent}, Failed: {$failed}");

        return self::SUCCESS;
    }
}
