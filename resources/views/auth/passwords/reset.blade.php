<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>New Password | GymSathi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    <body class="login-body">
        <div class="login-container" style="justify-content: center;">
            <div class="login-card" style="width: 100%; max-width: 480px; margin: 0 auto;">
                <a href="{{ route('welcome') }}" class="logo" style="text-decoration: none; color: inherit; display: flex; align-items: center; margin-bottom: 2rem;">
                    <div class="logo-icon">H</div>
                    GYM<span>SATHI</span>
                </a>
                
                <h2>Secure Your Account</h2>
                <p class="subtitle">Verification successful. Please enter your new high-security password below.</p>

                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li style="color: #ef4444; font-size: 0.875rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" id="password" name="password" placeholder="••••••••" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            </svg>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        UPDATE PASSWORD
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </form>

                <div class="login-footer">
                    <p>Secured by GymSathi Kinetic Ecosystem</p>
                </div>
            </div>
        </div>

        <div style="position: fixed; bottom: var(--space-md); width: 100%; display: flex; justify-content: center; padding: 0 var(--space-xl); font-size: 0.65rem; color: var(--on-surface-variant); text-transform: uppercase; letter-spacing: 0.1rem;">
            <div>&copy; 2026 GymSathi Kinetic Systems.</div>
        </div>
    </body>
</html>
