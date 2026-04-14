<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpersonationController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Public Routes
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('welcome');
    Route::get('/about', 'about')->name('about');
    Route::get('/sectors', 'sectors')->name('sectors');
    Route::get('/support', 'contactSupport')->name('support');
    Route::get('/privacy', 'privacyPolicy')->name('privacy');
    Route::get('/security', 'security')->name('security');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
    Route::get('/terms-of-service', 'termsOfService')->name('terms-of-service');
    Route::get('/contact-support', 'contactSupport')->name('contact-support');
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'store')->name('login.store')->middleware('throttle:10,1');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

// Password Reset Routes (OTP Based)
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('/forgot-password', 'showLinkRequestForm')->name('password.request');
    Route::post('/forgot-password', 'sendOtp')->name('password.email');
    Route::get('/verify-otp', 'showVerifyOtpForm')->name('password.otp');
    Route::post('/verify-otp', 'verifyOtp')->name('password.otp.verify');
    Route::get('/reset-password', 'showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// Authenticated Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Platform administration Routes (Super Admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [PlatformController::class, 'dashboard'])->name('admin.dashboard');

    // Gym Management Module
    Route::prefix('tenants')->name('admin.tenants.')->group(function () {
        Route::get('/', [PlatformController::class, 'index'])->name('index');
        Route::get('/create', [PlatformController::class, 'create'])->name('create');
        Route::post('/', [PlatformController::class, 'store'])->name('store');
        Route::get('/{tenant}', [PlatformController::class, 'show'])->name('show');

        // Status Management
        Route::patch('/{tenant}/approve', [PlatformController::class, 'approve'])->name('approve');
        Route::patch('/{tenant}/reject', [PlatformController::class, 'reject'])->name('reject');
        Route::patch('/{tenant}/suspend', [PlatformController::class, 'suspend'])->name('suspend');
        Route::patch('/{tenant}/reactivate', [PlatformController::class, 'reactivate'])->name('reactivate');

        // Other Actions
        Route::patch('/{tenant}/transfer-ownership', [PlatformController::class, 'transferOwnership'])->name('transfer-ownership');
        Route::post('/{tenant}/reset-password', [PlatformController::class, 'resetPassword'])->name('reset-password');
        Route::delete('/{tenant}', [PlatformController::class, 'destroy'])->name('destroy');
    });

    // Subscription & Billing Management Module
    Route::prefix('subscriptions')->name('admin.subscriptions.')->group(function () {
        Route::get('/dashboard', [ReportsController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports/monthly-revenue', [ReportsController::class, 'monthlyRevenue'])->name('reports.monthly-revenue');
        Route::get('/reports/revenue-by-city', [ReportsController::class, 'revenueByCity'])->name('reports.revenue-by-city');
        Route::get('/reports/revenue-by-plan', [ReportsController::class, 'revenueByPlan'])->name('reports.revenue-by-plan');
        Route::get('/reports/conversion-rates', [ReportsController::class, 'conversionRates'])->name('reports.conversion-rates');

        Route::get('/{tenant}', [SubscriptionController::class, 'show'])->name('show');
        Route::patch('/{tenant}/change-plan', [SubscriptionController::class, 'changePlan'])->name('change-plan');
        Route::patch('/{tenant}/extend-trial', [SubscriptionController::class, 'extendTrial'])->name('extend-trial');
        Route::patch('/{tenant}/cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
        Route::patch('/{tenant}/reactivate', [SubscriptionController::class, 'reactivate'])->name('reactivate');
        Route::patch('/{tenant}/toggle-auto-renew', [SubscriptionController::class, 'toggleAutoRenew'])->name('toggle-auto-renew');
    });

    Route::prefix('billing')->name('admin.billing.')->group(function () {
        Route::get('/{tenant}/payments', [BillingController::class, 'payments'])->name('payments');
        Route::get('/{tenant}/payments/create', [BillingController::class, 'createPayment'])->name('create-payment');
        Route::post('/{tenant}/payments', [BillingController::class, 'recordPayment'])->name('record-payment');
        Route::get('/{tenant}/invoice', [BillingController::class, 'generateInvoice'])->name('invoice');
        Route::post('/{tenant}/invoice/send', [BillingController::class, 'sendInvoice'])->name('send-invoice');
    });

    // Support & Communication Module
    Route::prefix('support')->name('admin.support.')->group(function () {
        Route::get('/', [SupportController::class, 'index'])->name('index');
        Route::get('/{ticket}', [SupportController::class, 'show'])->name('show');
        Route::patch('/{ticket}/assign', [SupportController::class, 'assign'])->name('assign');
        Route::patch('/{ticket}/priority', [SupportController::class, 'updatePriority'])->name('update-priority');
        Route::post('/{ticket}/reply', [SupportController::class, 'reply'])->name('reply');
        Route::patch('/{ticket}/resolve', [SupportController::class, 'resolve'])->name('resolve');
        Route::patch('/{ticket}/reopen', [SupportController::class, 'reopen'])->name('reopen');
        Route::patch('/{ticket}/close', [SupportController::class, 'close'])->name('close');
        Route::post('/{ticket}/note', [SupportController::class, 'addNote'])->name('add-note');
    });

    Route::prefix('announcements')->name('admin.announcements.')->group(function () {
        Route::get('/', [AnnouncementController::class, 'index'])->name('index');
        Route::get('/create', [AnnouncementController::class, 'create'])->name('create');
        Route::post('/', [AnnouncementController::class, 'store'])->name('store');
        Route::get('/{announcement}', [AnnouncementController::class, 'show'])->name('show');
        Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');
        Route::patch('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
        Route::post('/{announcement}/send', [AnnouncementController::class, 'send'])->name('send');
        Route::post('/{announcement}/schedule', [AnnouncementController::class, 'schedule'])->name('schedule');
        Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('activity')->name('admin.activity.')->group(function () {
        Route::get('/', [ActivityController::class, 'index'])->name('index');
        Route::get('/log/{log}', [ActivityController::class, 'showLog'])->name('log');
        Route::get('/{tenant}', [ActivityController::class, 'show'])->name('show');
        Route::get('/{tenant}/export', [ActivityController::class, 'export'])->name('export');
    });

    Route::prefix('impersonation')->name('admin.impersonation.')->group(function () {
        Route::get('/logs', [ImpersonationController::class, 'logs'])->name('logs');
        Route::get('/{tenant}/create', [ImpersonationController::class, 'create'])->name('create');
        Route::post('/{tenant}', [ImpersonationController::class, 'start'])->name('start');
        Route::post('/stop', [ImpersonationController::class, 'stop'])->name('stop');
    });
});
