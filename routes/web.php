<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
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
    Route::get('/sectors', 'sectors')->name('sectors');
    Route::get('/privacy-policy', 'privacyPolicy')->name('privacy-policy');
    Route::get('/terms-of-service', 'termsOfService')->name('terms-of-service');
    Route::get('/contact-support', 'contactSupport')->name('contact-support');
});

// Authentication Routes
Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/login', 'store')->name('login.store');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});
