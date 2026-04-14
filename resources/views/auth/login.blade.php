<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login | GymSathi Admin Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&family=Space+Grotesk:wght@700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    <body class="login-body">
        <div class="login-container">
            <!-- Left Panel -->
            <div class="login-info">
                <a href="{{ route('welcome') }}" class="logo" style="text-decoration: none; color: inherit; display: flex; align-items: center;">
                    <div class="logo-icon">H</div>
                    GYM<span>SATHI</span>
                </a>
                <h1>Powering the<br><span>Kinetic Pulse.</span></h1>
                <p>Access the world's most advanced athletic management ecosystem. Precision data, member engagement, and performance scaling at your fingertips.</p>
                
                <div class="login-stats">
                    <div class="stat-item">
                        <h3 class="display-text">12.4k</h3>
                        <p>Active Members</p>
                    </div>
                    <div class="stat-item">
                        <h3 class="display-text">98%</h3>
                        <p>Retention Rate</p>
                    </div>
                    <div class="stat-item">
                        <h3 class="display-text">24/7</h3>
                        <p>System Uptime</p>
                    </div>
                </div>
            </div>

            <!-- Right Panel / Login Card -->
            <div class="login-card">
                <h2> Portal Login</h2>
                <p class="subtitle">Enter your credentials to access your dashboard</p>

                @if ($errors->any())
                    <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.2); padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
                        <ul style="list-style: none; margin: 0; padding: 0;">
                            @foreach ($errors->all() as $error)
                                <li style="color: #ef4444; font-size: 0.875rem;">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Email / Username</label>
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.206" />
                            </svg>
                            <input type="text" id="username" name="email" placeholder="admin@gymsathi.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.8rem;">
                            <label style="margin-bottom: 0;">Password</label>
                            <a href="{{ route('password.request') }}" class="forgot-password" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.05rem;">Forgot Password?</a>
                        </div>
                        <div class="input-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                            <div id="togglePassword" style="cursor: pointer; display: flex; align-items: center;">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg id="eyeOffIcon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width: 20px; display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L5.122 5.122m7.756 7.756l4.756 4.756" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="remember-me">
                            <input type="checkbox" name="remember" style="accent-color: var(--primary-lime);">
                            Remember this device for 30 days
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login">
                        SIGN IN TO DASHBOARD
                        <svg xmlns="http://www.w3.org/2000/svg" style="width: 20px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>

                <div class="login-footer">
                    <p>Authorized Personnel Only</p>
                    <div class="footer-links">
                        <a href="{{ route('support') }}">Support</a>
                        <a href="{{ route('privacy') }}">Privacy</a>
                        <a href="{{ route('security') }}">Security</a>
                    </div>
                </div>
            </div>
        </div>

        <div style="position: fixed; bottom: var(--space-md); width: 100%; display: flex; justify-content: space-between; padding: 0 var(--space-xl); font-size: 0.65rem; color: var(--on-surface-variant); text-transform: uppercase; letter-spacing: 0.1rem;">
            <div>&copy; 2026 GymSathi Kinetic Systems. All Rights Reserved.</div>
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" style="width: 12px; color: var(--primary-lime);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                End-to-End Encryption Active
            </div>
        </div>

        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');
            const eyeIcon = document.querySelector('#eyeIcon');
            const eyeOffIcon = document.querySelector('#eyeOffIcon');

            togglePassword.addEventListener('click', function (e) {
                // toggle the type attribute
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                // toggle the eye slash icon
                if (type === 'password') {
                    eyeIcon.style.display = 'block';
                    eyeOffIcon.style.display = 'none';
                } else {
                    eyeIcon.style.display = 'none';
                    eyeOffIcon.style.display = 'block';
                }
            });
        </script>
    </body>
</html>
