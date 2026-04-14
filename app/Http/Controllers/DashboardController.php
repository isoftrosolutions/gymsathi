<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the authenticated user dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        // If user is a member (no platform_role and no specific staff role yet)
        // In a real app, you'd check $user->role->slug
        if ($user->role?->slug === 'member') {
            return view('dashboard.member');
        }

        return view('dashboard.gym');
    }
}
