<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
