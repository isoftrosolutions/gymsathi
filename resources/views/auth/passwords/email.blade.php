<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Forgot Password | GymSathi</title>

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
            <!-- Center Panel / Reset Card -->
            <div class="login-card" style="width: 100%; max-width: 480px; margin: 0 auto;">
                <a href="{{ route('welcome') }}" class="logo" style="text-decoration: none; color: inherit; display: flex; align-items: center; margin-bottom: 2rem;">
                    <div class="logo-icon">H</div>
                    GYM<span>SATHI</span>
                </a>
                
                <h2>Reset Password</h2>
                <p class="subtitle">Enter your email and we'll send you a One-Time Password (OTP) to reset your access.</p>

                @if (session('status'))
                    <div style="background: rgba(200, 241, 53, 0.1); border: 1px solid rgba(200, 241, 53, 0.2); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <p style="color: var(--primary-lime); font-size: 0.875rem; margin: 0;">{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li style="color: #ef4444; font-size: 0.875rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.email') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="email">Registered Email Address</label>
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@gymsathi.com" required autofocus>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        SEND OTP CODE
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                    
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <a href="{{ route('login') }}" class="forgot-password" style="font-size: 0.75rem;">Back to Login</a>
                    </div>
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
