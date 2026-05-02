# GymSathi Implementation Plan — April 29, 2026

## Context
GymSathi is ~70% complete. Goal: finish core features excluding WhatsApp integration.

---

## Phase 1: Fix Critical Issues

### 1. Fix Failing Test
**File:** `tests/Feature/Admin/TenantTest.php:61-64`

**Problem:** Test asserts `'email' => '9800000000@gymsathi.com'` but controller uses `owner_email` = `john@gymsathi.com`

**Fix:**
```php
// Line 61-64, change:
'email' => '9800000000@gymsathi.com',
// to:
'email' => 'john@gymsathi.com',
```

### 2. Commit Uncommitted Changes
27 modified files + 3 untracked dirs. Create atomic commits per feature.

---

## Phase 2: Payment Gateway Integration (eSewa + Khalti)

### Files to Create
- `app/Services/PaymentGateway.php` — interface
- `app/Services/EsewaGateway.php`
- `app/Services/KhaltiGateway.php`

### eSewa Flow
1. `POST /payment/esewa/initiate` → redirect to eSewa with amount, productId, etc.
2. eSewa redirects to `GET /payment/esewa/callback?data=...`
3. Verify signature, check transaction status via eSewa API
4. Create `Payment` record, update `MemberPackage`

### Khalti Flow
1. `POST /payment/khalti/initiate` → get `pidx` from Khalti API
2. Frontend redirects to Khalti checkout
3. `GET /payment/khalti/callback?pidx=...` → lookup transaction, verify
4. Create `Payment` record

### Routes
```php
Route::prefix('payment')->name('payment.')->group(function () {
    Route::post('/{gateway}/initiate', [PaymentController::class, 'initiate']);
    Route::get('/{gateway}/callback', [PaymentController::class, 'callback']);
});
```

### Testing
- Mock gateway responses with `Http::fake()`
- Test success + failure flows

---

## Phase 3: Member Portal Enhancements

### 3.1 Package Renewal Flow
**Controller:** `MemberPortalController::renewPackage(Request $request)`
- Select package → choose payment gateway → redirect to gateway → callback → activate

**View:** `resources/views/member/renew.blade.php`

### 3.2 Attendance Check-in/out UI
**Route:** `POST /member/attendance/checkin`, `POST /member/attendance/checkout`
**UI:** Button in `resources/views/member/attendance.blade.php` with AJAX

### 3.3 Payment History + PDF Receipts
- Install `barryvdh/laravel-dompdf`
- `MemberPortalController::receipt($paymentId)` → return PDF
- Link in payment history view

### 3.4 Profile Picture Upload
- Use migration `add_profile_picture_and_blood_group_to_users_table`
- Store in `storage/app/public/profiles`
- Add `<input type="file" name="profile_picture">` to profile form

---

## Phase 4: Expand Test Coverage (Target 80%+)

### Feature Tests to Add
- `tests/Feature/Gym/MemberTest.php` — CRUD
- `tests/Feature/Gym/PackageTest.php` — CRUD
- `tests/Feature/Gym/AttendanceTest.php` — check-in/out
- `tests/Feature/Gym/PaymentTest.php` — record + receipt
- `tests/Feature/Member/PortalTest.php` — profile, membership, attendance
- `tests/Feature/Admin/SubscriptionTest.php` — change plan, extend trial
- `tests/Feature/Admin/SupportTest.php` — ticket lifecycle

### Unit Tests to Add
- `tests/Unit/TenantTest.php` — approve(), reject(), suspend(), etc.
- `tests/Unit/UserTest.php` — hasPermission(), role checks
- `tests/Unit/PaymentTest.php` — calculations

---

## Phase 5: Dashboard & Performance

### 5.1 Fix Hardcoded `active_members = 0`
**File:** `app/Http/Controllers/PlatformController::dashboard()`
```php
$activeMembers = Tenant::where('status', 'active')
    ->withCount(['users as member_count' => function ($q) {
        $q->whereHas('role', fn($q) => $q->where('slug', 'member'));
    }])
    ->get()
    ->sum('member_count');
```

### 5.2 Add Charts to Tenant Dashboard
- Use Chart.js via CDN in `resources/views/gym/dashboard.blade.php`
- Members over time, revenue, attendance

### 5.3 Add Caching
```php
$stats = Cache::remember('platform.stats', 300, function () {
    // compute stats
});
```

### 5.4 Eager Loading Audit
- Check `PlatformController`, `DashboardController` for N+1 queries
- Add `with('users', 'subscriptions')` etc.

---

## Phase 6: Console Commands + Security

### 6.1 Console Commands
**File:** `app/Console/Commands/GymSathiSendRenewalReminders.php`
```bash
php artisan gymsathi:send-renewal-reminders
```
- Find expiring packages → send email/WhatsApp (skip for now)

**File:** `app/Console/Commands/GymSathiCleanupExpired.php`
- Mark expired subscriptions, deactivate tenants

### 6.2 Schedule in `app/Console/Kernel.php`
```php
$schedule->command('gymsathi:send-renewal-reminders')->daily();
$schedule->command('gymsathi:cleanup-expired')->daily();
```

### 6.3 Security
- Rate limiting in `app/Http/Middleware/ThrottleRequests.php` or `Route::middleware('throttle:60,1')`
- Audit all forms for CSRF (already handled by Laravel)
- Check SQL queries with `DB::getQueryLog()` during testing

---

## Execution Order
1. Fix test → commit
2. Payment gateways (eSewa, Khalti)
3. Member portal enhancements
4. Test coverage expansion
5. Dashboard fixes + caching
6. Console commands + security audit

---

## Verification Commands
```bash
php artisan test              # All tests pass
./vendor/bin/pint              # Code style OK
php artisan config:clear       # No config errors
php artisan route:clear        # No route errors
```