@extends('layouts.public')

@section('title', 'GymSathi — Kinetic Gym Management for Nepal')

@section('styles')
<style>
    /* Critical overlap styles for Editorial feel */
    .hero-title-overlap {
        position: absolute;
        bottom: -2rem;
        right: 0;
        font-size: 15vw;
        opacity: 0.03;
        pointer-events: none;
        z-index: 1;
        white-space: nowrap;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero" style="padding-top: 120px;">
    <div class="container hero-content">
        <p style="color: var(--primary-lime); font-weight: 800; text-transform: uppercase; margin-bottom: 1rem; letter-spacing: 0.2rem;">Stop the chaos. Start the growth.</p>
        <h1>AUTOMATE YOUR<br>FACILITY</h1>
        <p>The all-in-one system for Nepal's modern fitness owners. Stop chasing payments and start scaling your business with automated SMS, real-time revenue tracking, and effortless member management.</p>
        <div class="hero-actions">
            <a href="#pricing" class="btn btn-primary">Automate My Gym Today</a>
            <a href="{{ route('sectors') }}" class="btn btn-secondary">See Sector Solutions</a>
        </div>
    </div>
    <div class="hero-title-overlap">GYMSATHI</div>
</section>

<!-- Why GymSathi / Problem -->
<section id="features" class="section-padding">
    <div class="container">
        <div style="margin-bottom: var(--space-xl); max-width: 600px;">
            <h2 style="font-size: 3rem; margin-bottom: var(--space-md);">DOMINATE YOUR MARKET</h2>
            <p style="color: var(--on-surface-variant);">We didn't just build a dashboard. We built a system that makes manual management look like a liability. Designed locally for Nepal's unique payment and business landscape.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <span class="feature-number">01</span>
                <h3>Digital Notebook</h3>
                <p>Search members instantly. No more flipping through ink-stained pages. Full history at your fingertips.</p>
            </div>
            <div class="feature-card">
                <span class="feature-number">02</span>
                <h3>WhatsApp Pulse</h3>
                <p>Automatic renewal reminders sent directly to members' phones. Professional, timely, and 100% automated.</p>
            </div>
            <div class="feature-card">
                <span class="feature-number">03</span>
                <h3>Local Core</h3>
                <p>Integrated with eSewa & Khalti. Manage your revenue in NPR without checking exchange rates or using foreign wallets.</p>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section -->
<section id="pricing" class="section-padding pricing-section">
    <div class="container">
        <div style="text-align: center; margin-bottom: var(--space-xl);">
            <h2 style="font-size: 3.5rem;">CHOOSE YOUR SPEED</h2>
            <p style="color: var(--on-surface-variant); margin-top: 1rem;">From single branch to fitness empires.</p>
        </div>

        <div class="pricing-grid">
            <!-- Basic -->
            <div class="price-card">
                <div>
                    <h4>BASIC</h4>
                    <div class="price-value">NPR 800<span>/mo</span></div>
                </div>
                <ul class="price-features">
                    <li>Up to 100 Members</li>
                    <li>Manual Attendance</li>
                    <li>Payment Tracking</li>
                    <li>Core Dashboard</li>
                </ul>
                <a href="#" class="btn btn-secondary" style="margin-left: 0; text-align: center;">Join Basic</a>
            </div>

            <!-- Standard -->
            <div class="price-card popular">
                <div>
                    <div style="background: var(--primary-lime); color: var(--on-primary-lime); display: inline-block; padding: 0.2rem 0.6rem; font-size: 0.7rem; font-weight: 800; margin-bottom: 0.5rem; border-radius: 4px;">BEST VALUE</div>
                    <h4>STANDARD</h4>
                    <div class="price-value">NPR 1,200<span>/mo</span></div>
                </div>
                <ul class="price-features">
                    <li>Up to 300 Members</li>
                    <li>WhatsApp Reminders</li>
                    <li>One-Tap Attendance</li>
                    <li>PDF Report Exports</li>
                </ul>
                <a href="#" class="btn btn-primary" style="text-align: center;">Join Standard</a>
            </div>

            <!-- Premium -->
            <div class="price-card">
                <div>
                    <h4>PREMIUM</h4>
                    <div class="price-value">NPR 2,000<span>/mo</span></div>
                </div>
                <ul class="price-features">
                    <li>Unlimited Members</li>
                    <li>Multi-Staff Access</li>
                    <li>advanced Analytics</li>
                    <li>Priority Support</li>
                </ul>
                <a href="#" class="btn btn-secondary" style="margin-left: 0; text-align: center;">Join Premium</a>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section-padding" style="text-align: center; position: relative; overflow: hidden;">
    <div class="container">
        <h2 style="font-size: 5vw; margin-bottom: var(--space-md);">START MANAGING SMARTER</h2>
        <p style="color: var(--on-surface-variant); margin-bottom: var(--space-lg); max-width: 600px; margin-inline: auto;">Join 50+ facilities across Nepal already scaling with GymSathi. Get 30 days of full access, no credit card required.</p>
        <div style="background: var(--surface-high); padding: var(--space-lg); border-radius: var(--space-md); display: inline-flex; gap: var(--space-sm); align-items: center; justify-content: center; width: 100%; max-width: 500px;">
            <input type="email" placeholder="YOUR@EMAIL.COM" style="background: transparent; border: none; border-bottom: 2px solid var(--surface-bright); color: white; padding: 0.5rem; flex: 1; outline: none; font-family: 'Space Grotesk';">
            <button class="btn btn-primary" style="padding: 1rem 2rem;">START FREE TRIAL</button>
        </div>
    </div>
    <!-- Background Decoration -->
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: radial-gradient(circle at 50% 50%, rgba(218, 255, 1, 0.05) 0%, transparent 70%); pointer-events: none;"></div>
</section>
@endsection
