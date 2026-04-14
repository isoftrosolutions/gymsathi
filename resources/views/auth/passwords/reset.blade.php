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
        <style>
            .password-toggle {
                background: none;
                border: none;
                color: var(--on-surface-variant);
                cursor: pointer;
                padding: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 4px;
                transition: var(--transition-smooth);
            }

            .password-toggle:hover {
                color: var(--primary-lime);
                background-color: rgba(218, 255, 1, 0.1);
            }

            .password-toggle:focus {
                outline: 2px solid var(--primary-lime);
                outline-offset: 2px;
            }

            .eye-icon {
                width: 20px;
                height: 20px;
            }

            .input-container {
                position: relative;
            }

            .input-container .password-toggle {
                position: absolute;
                right: 1rem;
                top: 50%;
                transform: translateY(-50%);
            }

            .input-container input {
                padding-right: 3rem; /* Make room for the toggle button */
            }
        </style>
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
                            <button type="button" class="password-toggle" data-target="password" aria-label="Toggle password visibility">
                                <svg class="eye-icon eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-icon eye-open" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                            </svg>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" required>
                            <button type="button" class="password-toggle" data-target="password_confirmation" aria-label="Toggle password visibility">
                                <svg class="eye-icon eye-closed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg class="eye-icon eye-open" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />
                                </svg>
                            </button>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Password toggle functionality
                document.querySelectorAll('.password-toggle').forEach(function(toggleBtn) {
                    toggleBtn.addEventListener('click', function() {
                        const targetId = this.getAttribute('data-target');
                        const passwordInput = document.getElementById(targetId);
                        const eyeClosed = this.querySelector('.eye-closed');
                        const eyeOpen = this.querySelector('.eye-open');

                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            eyeClosed.style.display = 'none';
                            eyeOpen.style.display = 'block';
                        } else {
                            passwordInput.type = 'password';
                            eyeClosed.style.display = 'block';
                            eyeOpen.style.display = 'none';
                        }
                    });
                });
            });
        </script>
    </body>
</html>
