@extends('layouts.public')

@section('title', 'Contact Support — GymSathi')

@section('content')
<div class="pt-32 pb-24">
    <!-- Hero Section -->
    <header class="max-w-4xl mx-auto px-8 mb-16 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-surface-container-high border border-outline-variant/20 text-secondary text-xs font-bold tracking-widest uppercase mb-4">Support</span>
        <h1 class="text-4xl md:text-6xl font-headline font-bold tracking-tight leading-none mb-6">
            Contact <span class="text-[#C8F135] text-glow">Support</span>
        </h1>
        <p class="text-xl text-on-surface-variant max-w-2xl mx-auto font-light leading-relaxed">
            Get help with your GymSathi account and services. We're here to assist you.
        </p>
    </header>

    <!-- Contact Options -->
    <section class="max-w-6xl mx-auto px-8 mb-16">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Phone Support -->
            <div class="glass-card rounded-2xl p-8 text-center group hover:scale-105 transition-all duration-300">
                <div class="w-16 h-16 bg-primary-container/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-container/30 transition-colors">
                    <span class="material-symbols-outlined text-primary-container text-3xl">phone</span>
                </div>
                <h3 class="text-xl font-headline font-bold mb-4">Phone Support</h3>
                <p class="text-on-surface-variant mb-6">Speak directly with our support team for immediate assistance.</p>
                <div class="space-y-2">
                    <p class="font-bold text-on-surface">+977 9811144402</p>
                    <p class="text-sm text-on-surface-variant/60">Mon-Fri: 9AM-6PM NPT</p>
                </div>
            </div>

            <!-- Email Support -->
            <div class="glass-card rounded-2xl p-8 text-center group hover:scale-105 transition-all duration-300">
                <div class="w-16 h-16 bg-secondary/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-secondary/30 transition-colors">
                    <span class="material-symbols-outlined text-secondary text-3xl">mail</span>
                </div>
                <h3 class="text-xl font-headline font-bold mb-4">Email Support</h3>
                <p class="text-on-surface-variant mb-6">Send us detailed queries and we'll respond within 24 hours.</p>
                <div class="space-y-2">
                    <p class="font-bold text-on-surface">mind59024@gmail.com</p>
                    <p class="text-sm text-on-surface-variant/60">24/7 Response</p>
                </div>
            </div>

            <!-- Live Chat -->
            <div class="glass-card rounded-2xl p-8 text-center group hover:scale-105 transition-all duration-300">
                <div class="w-16 h-16 bg-tertiary-fixed-dim/20 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-tertiary-fixed-dim/30 transition-colors">
                    <span class="material-symbols-outlined text-tertiary-fixed-dim text-3xl">chat</span>
                </div>
                <h3 class="text-xl font-headline font-bold mb-4">Live Chat</h3>
                <p class="text-on-surface-variant mb-6">Chat with our AI assistant for quick answers and common solutions.</p>
                <div class="space-y-2">
                    <p class="font-bold text-on-surface">Available Now</p>
                    <p class="text-sm text-on-surface-variant/60">Instant Response</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form -->
    <section class="max-w-4xl mx-auto px-8 mb-16">
        <div class="glass-card rounded-2xl p-8 md:p-12">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-headline font-bold mb-4">Send us a Message</h2>
                <p class="text-on-surface-variant">Fill out the form below and we'll get back to you as soon as possible.</p>
            </div>

            <form class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="first_name" class="block text-sm font-bold text-on-surface mb-2">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="w-full px-4 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:border-primary-container focus:outline-none transition-colors" required>
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-bold text-on-surface mb-2">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="w-full px-4 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:border-primary-container focus:outline-none transition-colors" required>
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-on-surface mb-2">Email Address</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:border-primary-container focus:outline-none transition-colors" required>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-bold text-on-surface mb-2">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" class="w-full px-4 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:border-primary-container focus:outline-none transition-colors">
                </div>

                <div>
                    <label for="subject" class="block text-sm font-bold text-on-surface mb-2">Subject</label>
                    <select id="subject" name="subject" class="w-full px-4 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:border-primary-container focus:outline-none transition-colors" required>
                        <option value="">Select a subject</option>
                        <option value="technical">Technical Support</option>
                        <option value="billing">Billing & Payments</option>
                        <option value="account">Account Issues</option>
                        <option value="feature">Feature Request</option>
                        <option value="partnership">Partnership Inquiry</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="facility_type" class="block text-sm font-bold text-on-surface mb-2">Facility Type</label>
                    <select id="facility_type" name="facility_type" class="w-full px-4 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:border-primary-container focus:outline-none transition-colors">
                        <option value="">Select your facility type</option>
                        <option value="gym">Fitness Club/Gym</option>
                        <option value="dance">Dance Academy</option>
                        <option value="yoga">Yoga Center</option>
                        <option value="swim">Swim Center</option>
                        <option value="spa">Spa & Leisure</option>
                        <option value="training">Training Institute</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="message" class="block text-sm font-bold text-on-surface mb-2">Message</label>
                    <textarea id="message" name="message" rows="6" class="w-full px-4 py-3 bg-surface-container-low border border-outline-variant/30 rounded-xl focus:border-primary-container focus:outline-none transition-colors resize-none" placeholder="Describe your issue or question in detail..." required></textarea>
                </div>

                <div class="flex items-start space-x-3">
                    <input type="checkbox" id="urgent" name="urgent" class="mt-1 w-4 h-4 bg-surface-container-low border border-outline-variant/30 rounded focus:ring-primary-container">
                    <label for="urgent" class="text-sm text-on-surface-variant">
                        <span class="font-bold">Mark as urgent</span> - We'll prioritize your request and respond within 4 hours
                    </label>
                </div>

                <div class="text-center">
                    <button type="submit" class="kinetic-gradient text-on-primary font-headline font-bold px-8 py-4 rounded-xl hover:scale-105 transition-all shadow-xl shadow-primary-container/20">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="max-w-4xl mx-auto px-8 mb-16">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-headline font-bold mb-4">Frequently Asked Questions</h2>
            <p class="text-on-surface-variant">Quick answers to common questions about GymSathi.</p>
        </div>

        <div class="space-y-6">
            <div class="glass-card rounded-2xl p-6">
                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none">
                        <h3 class="text-lg font-bold text-on-surface">How do I reset my password?</h3>
                        <span class="material-symbols-outlined text-primary-container group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-on-surface-variant">
                        <p>You can reset your password by clicking "Forgot Password" on the login page. We'll send a reset link to your registered email address.</p>
                    </div>
                </details>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none">
                        <h3 class="text-lg font-bold text-on-surface">How do I add new members to my gym?</h3>
                        <span class="material-symbols-outlined text-primary-container group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-on-surface-variant">
                        <p>Go to the Members section in your dashboard and click "Add Member". Fill in their details, set up their membership plan, and they'll be automatically added to your system.</p>
                    </div>
                </details>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none">
                        <h3 class="text-lg font-bold text-on-surface">Can I integrate with WhatsApp for reminders?</h3>
                        <span class="material-symbols-outlined text-primary-container group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-on-surface-variant">
                        <p>Yes! GymSathi includes built-in WhatsApp integration for automated renewal reminders, birthday wishes, and custom notifications to keep your members engaged.</p>
                    </div>
                </details>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none">
                        <h3 class="text-lg font-bold text-on-surface">What payment methods do you support?</h3>
                        <span class="material-symbols-outlined text-primary-container group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-on-surface-variant">
                        <p>We support eSewa and Khalti digital wallets, which are the most popular payment methods in Nepal. Credit/debit card payments are also available.</p>
                    </div>
                </details>
            </div>

            <div class="glass-card rounded-2xl p-6">
                <details class="group">
                    <summary class="flex justify-between items-center cursor-pointer list-none">
                        <h3 class="text-lg font-bold text-on-surface">How do I export my member data?</h3>
                        <span class="material-symbols-outlined text-primary-container group-open:rotate-180 transition-transform">expand_more</span>
                    </summary>
                    <div class="mt-4 text-on-surface-variant">
                        <p>In your dashboard, go to Reports > Export Data. You can export member lists, attendance records, and payment history in CSV or Excel format.</p>
                    </div>
                </details>
            </div>
        </div>
    </section>

    <!-- Office Information -->
    <section class="max-w-4xl mx-auto px-8">
        <div class="glass-card rounded-2xl p-8 md:p-12 text-center">
            <h2 class="text-3xl font-headline font-bold mb-8">Visit Our Office</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4 text-primary-container">Parsa Office</h3>
                    <div class="text-left space-y-2 text-on-surface-variant">
                        <p><span class="material-symbols-outlined align-middle mr-2">location_on</span>Birgunj-13, Radhemai, Parsa, Nepal</p>
                        <p><span class="material-symbols-outlined align-middle mr-2">phone</span>+977 9811144402</p>
                        <p><span class="material-symbols-outlined align-middle mr-2">mail</span>mind59024@gmail.com</p>
                        <p><span class="material-symbols-outlined align-middle mr-2">schedule</span>Mon-Fri: 9AM-6PM NPT</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-4 text-primary-container">Business Hours</h3>
                    <div class="text-left space-y-2 text-on-surface-variant">
                        <p><strong>Monday - Friday:</strong> 9:00 AM - 6:00 PM NPT</p>
                        <p><strong>Saturday:</strong> 10:00 AM - 4:00 PM NPT</p>
                        <p><strong>Sunday:</strong> Closed</p>
                        <p><strong>Emergency Support:</strong> 24/7 via email</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection