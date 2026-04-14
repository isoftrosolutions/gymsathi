<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Verify OTP | GymSathi</title>

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
                
                <h2>Verify Identity</h2>
                <p class="subtitle">A 6-digit code has been sent to <strong>{{ $email }}</strong>. Enter it below to proceed.</p>

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

                <form action="{{ route('password.otp.verify') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    
                    <div class="form-group">
                        <label for="otp">Security Code (OTP)</label>
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <input type="text" id="otp" name="otp" placeholder="123456" maxlength="6" pattern="\d{6}" required autofocus style="letter-spacing: 0.5rem; text-align: center; font-size: 1.5rem; font-weight: 800;">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login">
                        VERIFY CODE
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                    </button>
                    
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <p style="font-size: 0.8rem; color: var(--on-surface-variant);">Didn't receive the code?</p>
                        <button type="button" onclick="document.getElementById('resend-form').submit()"
                            class="forgot-password" style="background: none; border: none; cursor: pointer; padding: 0; font-size: 0.75rem;">
                            Resend Code
                        </button>
                    </div>
                </form>

                {{-- Resend form lives outside the verify form to avoid invalid nested-form HTML --}}
                <form action="{{ route('password.email') }}" method="POST" id="resend-form" style="display:none;">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
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
