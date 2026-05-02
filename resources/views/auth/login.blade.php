@extends('layouts.public')

@section('title', 'Login | GymSathi')

@section('styles')
<style>
.login-body {
    background: linear-gradient(rgba(17, 19, 24, 0.85), rgba(17, 19, 24, 0.85)), 
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
    min-height: 100vh;
}

.login-container {
    display: grid;
    grid-template-columns: 1fr 1fr;
    max-width: 1200px;
    width: 90%;
    gap: 3rem;
    align-items: center;
    margin: 0 auto;
    padding: 6rem 0;
}

.login-info {
    color: var(--primary);
}

.login-info .logo-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.8rem;
    font-weight: 800;
    text-decoration: none;
    color: var(--primary);
    margin-bottom: 3rem;
    letter-spacing: -0.02em;
}

.logo-icon {
    background-color: var(--primary-container);
    color: var(--on-primary-container);
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    font-weight: 900;
}

.login-info h1 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 5.5rem;
    line-height: 0.9;
    margin-bottom: 1.5rem;
    text-transform: uppercase;
    letter-spacing: -0.02em;
}

.login-info h1 span {
    color: var(--primary-container);
    font-style: italic;
}

.login-info p {
    color: var(--on-surface-variant);
    font-size: 1.1rem;
    max-width: 480px;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.login-stats {
    display: flex;
    gap: 3rem;
}

.stat-item h3 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 2.5rem;
    margin-bottom: 0.2rem;
    color: var(--primary-container);
}

.stat-item p {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.1rem;
    margin-bottom: 0;
    color: var(--on-surface-variant);
}

.login-card {
    background-color: rgba(30, 31, 37, 0.6);
    padding: 3rem;
    border-radius: 40px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(20px);
}

.login-card h2 {
    font-family: 'Space Grotesk', sans-serif;
    font-size: 2.2rem;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: -0.02em;
}

.login-card .subtitle {
    color: var(--on-surface-variant);
    margin-bottom: 3rem;
    font-size: 0.9rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.1rem;
    margin-bottom: 0.8rem;
    color: var(--on-surface-variant);
    font-weight: 600;
}

.input-container {
    position: relative;
    background-color: rgba(255, 255, 255, 0.03);
    border-radius: 12px;
    padding: 1rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

.input-container:focus-within {
    border-color: rgba(200, 241, 53, 0.4);
    background-color: rgba(255, 255, 255, 0.06);
    box-shadow: 0 0 0 3px rgba(200, 241, 53, 0.1);
}

.input-container input {
    background: transparent;
    border: none;
    color: var(--on-surface);
    width: 100%;
    outline: none;
    font-size: 1rem;
    font-family: 'Manrope', sans-serif;
}

.input-container input::placeholder {
    color: var(--on-surface-variant);
    opacity: 0.6;
}

.input-container svg {
    color: var(--on-surface-variant);
    width: 20px;
    flex-shrink: 0;
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    font-size: 0.85rem;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--on-surface-variant);
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
}

.remember-me input[type="checkbox"] {
    accent-color: var(--primary-container);
    width: 16px;
    height: 16px;
}

.forgot-password {
    color: var(--primary-container);
    text-decoration: none;
    font-weight: 700;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05rem;
    transition: opacity 0.2s;
}

.forgot-password:hover {
    opacity: 0.8;
}

.btn-login {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    padding: 1.25rem 2rem;
    font-size: 0.9rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.1rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-container) 100%);
    color: var(--on-primary-container);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    font-family: 'Manrope', sans-serif;
    transition: all 0.3s ease;
    box-shadow: 0 8px 32px rgba(200, 241, 53, 0.25);
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(200, 241, 53, 0.35);
}

.btn-login svg {
    width: 20px;
    height: 20px;
}

.login-footer {
    text-align: center;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
}

.login-footer p {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 0.1rem;
    color: var(--on-surface-variant);
    margin-bottom: 1rem;
}

.footer-links {
    display: flex;
    justify-content: center;
    gap: 1.5rem;
}

.footer-links a {
    color: var(--on-surface-variant);
    text-decoration: none;
    font-size: 0.8rem;
    transition: color 0.2s;
}

.footer-links a:hover {
    color: var(--primary);
}

.login-footer-fixed {
    position: fixed;
    bottom: 1.5rem;
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 3rem;
    font-size: 0.65rem;
    color: var(--on-surface-variant);
    text-transform: uppercase;
    letter-spacing: 0.1rem;
}

.security-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.security-badge svg {
    width: 12px;
    color: var(--primary-container);
}

.error-alert {
    background: rgba(255, 180, 171, 0.1);
    border: 1px solid rgba(255, 180, 171, 0.2);
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
}

.error-alert ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.error-alert li {
    color: var(--error);
    font-size: 0.875rem;
}

@media (max-width: 992px) {
    .login-container {
        grid-template-columns: 1fr;
        padding: 4rem 0;
    }
    .login-info {
        text-align: center;
    }
    .login-info p {
        margin-inline: auto;
    }
    .login-stats {
        justify-content: center;
    }
    .login-info h1 {
        font-size: 3.5rem;
    }
    .login-footer-fixed {
        display: none;
    }
}
</style>
@endsection

@section('content')
<div class="login-body">
    <div class="login-container">
        <div class="login-info">
            <a href="{{ route('welcome') }}" class="logo-link">
                <div class="logo-icon">H</div>
                GYM<span style="color: var(--primary-container);">SATHI</span>
            </a>
            <h1>Powering the<br><span>Kinetic Pulse.</span></h1>
            <p>Access the world's most advanced athletic management ecosystem. Precision data, member engagement, and performance scaling at your fingertips.</p>
            
            <div class="login-stats">
                <div class="stat-item">
                    <h3>12.4k</h3>
                    <p>Active Members</p>
                </div>
                <div class="stat-item">
                    <h3>98%</h3>
                    <p>Retention Rate</p>
                </div>
                <div class="stat-item">
                    <h3>24/7</h3>
                    <p>System Uptime</p>
                </div>
            </div>
        </div>

        <div class="login-card">
            <h2>Portal Login</h2>
            <p class="subtitle">Enter your credentials to access your dashboard</p>

            @if ($errors->any())
                <div class="error-alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
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
                        <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                    </div>
                    <div class="input-container">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                        <div id="togglePassword" style="cursor: pointer; display: flex; align-items: center; padding: 4px;">
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
                        <input type="checkbox" name="remember">
                        Remember this device for 30 days
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    Sign In to Dashboard
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

    <div class="login-footer-fixed">
        <div>&copy; 2026 GymSathi Kinetic Systems. All Rights Reserved.</div>
        <div class="security-badge">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            End-to-End Encryption Active
        </div>
    </div>
</div>

<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');
    const eyeIcon = document.querySelector('#eyeIcon');
    const eyeOffIcon = document.querySelector('#eyeOffIcon');

    togglePassword.addEventListener('click', function (e) {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIcon.style.display = 'block';
            eyeOffIcon.style.display = 'none';
        } else {
            eyeIcon.style.display = 'none';
            eyeOffIcon.style.display = 'block';
        }
    });
</script>
@endsection