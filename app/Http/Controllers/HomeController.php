<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the welcome/landing page.
     */
    public function index(): View
    {
        return view('welcome');
    }

    /**
     * Display the sector solutions page.
     */
    public function sectors(): View
    {
        return view('sectors');
    }

    /**
     * Display the about page.
     */
    public function about(): View
    {
        return view('about');
    }

    /**
     * Display the privacy policy page.
     */
    public function privacyPolicy(): View
    {
        return view('privacy-policy');
    }

    /**
     * Display the terms of service page.
     */
    public function termsOfService(): View
    {
        return view('terms-of-service');
    }

    /**
     * Display the contact support page.
     */
    public function contactSupport(): View
    {
        return view('contact-support');
    }

    /**
     * Display the security page.
     */
    public function security(): View
    {
        return view('security');
    }
}
