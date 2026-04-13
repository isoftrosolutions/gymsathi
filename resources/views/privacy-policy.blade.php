@extends('layouts.public')

@section('title', 'Privacy Policy — GymSathi')

@section('content')
<div class="pt-32 pb-24">
    <!-- Hero Section -->
    <header class="max-w-4xl mx-auto px-8 mb-16 text-center">
        <span class="inline-block py-1 px-3 rounded-full bg-surface-container-high border border-outline-variant/20 text-secondary text-xs font-bold tracking-widest uppercase mb-4">Legal</span>
        <h1 class="text-4xl md:text-6xl font-headline font-bold tracking-tight leading-none mb-6">
            Privacy <span class="text-[#C8F135] text-glow">Policy</span>
        </h1>
        <p class="text-xl text-on-surface-variant max-w-2xl mx-auto font-light leading-relaxed">
            How we collect, use, and protect your personal information at GymSathi.
        </p>
        <p class="text-sm text-on-surface-variant/60 mt-4">Last updated: April 2026</p>
    </header>

    <!-- Content Section -->
    <section class="max-w-4xl mx-auto px-8">
        <div class="prose prose-lg prose-invert max-w-none">
            <div class="glass-card rounded-2xl p-8 md:p-12 mb-8">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">Information We Collect</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <div>
                        <h3 class="text-lg font-bold mb-3 text-on-surface">Personal Information</h3>
                        <p>We collect information you provide directly to us, such as when you create an account, use our services, or contact us for support. This may include:</p>
                        <ul class="list-disc pl-6 mt-3 space-y-2">
                            <li>Name, email address, and contact information</li>
                            <li>Business information for gym/facility registration</li>
                            <li>Payment information for subscription services</li>
                            <li>Member data you manage through our platform</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold mb-3 text-on-surface">Usage Information</h3>
                        <p>We automatically collect certain information when you use our services:</p>
                        <ul class="list-disc pl-6 mt-3 space-y-2">
                            <li>Log data (IP address, browser type, pages visited)</li>
                            <li>Device information and screen resolution</li>
                            <li>Usage patterns and feature interactions</li>
                            <li>Cookies and similar tracking technologies</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 md:p-12 mb-8">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">How We Use Your Information</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <p>We use the information we collect to:</p>
                    <ul class="list-disc pl-6 space-y-2">
                        <li>Provide, maintain, and improve our services</li>
                        <li>Process transactions and manage subscriptions</li>
                        <li>Send administrative information and updates</li>
                        <li>Respond to your comments, questions, and requests</li>
                        <li>Analyze usage patterns to improve user experience</li>
                        <li>Comply with legal obligations</li>
                        <li>Prevent fraud and ensure platform security</li>
                    </ul>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 md:p-12 mb-8">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">Information Sharing</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy:</p>
                    <ul class="list-disc pl-6 space-y-2 mt-3">
                        <li><strong>Service Providers:</strong> We may share information with trusted third-party service providers who assist us in operating our platform</li>
                        <li><strong>Legal Requirements:</strong> We may disclose information if required by law or to protect our rights and safety</li>
                        <li><strong>Business Transfers:</strong> In the event of a merger or acquisition, user information may be transferred as part of the transaction</li>
                    </ul>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 md:p-12 mb-8">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">Data Security</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <p>We implement appropriate technical and organizational measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction. These measures include:</p>
                    <ul class="list-disc pl-6 space-y-2 mt-3">
                        <li>Encryption of data in transit and at rest</li>
                        <li>Regular security audits and updates</li>
                        <li>Access controls and authentication requirements</li>
                        <li>Secure data centers and infrastructure</li>
                    </ul>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 md:p-12 mb-8">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">Your Rights</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <p>You have the following rights regarding your personal information:</p>
                    <ul class="list-disc pl-6 space-y-2 mt-3">
                        <li><strong>Access:</strong> Request a copy of your personal information</li>
                        <li><strong>Correction:</strong> Request correction of inaccurate information</li>
                        <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                        <li><strong>Portability:</strong> Request transfer of your data to another service</li>
                        <li><strong>Objection:</strong> Object to processing of your personal information</li>
                    </ul>
                    <p class="mt-4">To exercise these rights, please contact us using the information provided below.</p>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 md:p-12 mb-8">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">Cookies and Tracking</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <p>We use cookies and similar technologies to enhance your experience on our platform. You can control cookie preferences through your browser settings.</p>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 md:p-12 mb-8">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">Contact Us</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <p>If you have any questions about this Privacy Policy or our data practices, please contact us:</p>
                    <div class="bg-surface-container-low rounded-xl p-6 mt-4">
                        <p><strong>Email:</strong> privacy@gymsathi.com</p>
                        <p><strong>Address:</strong> Kathmandu, Nepal</p>
                        <p><strong>Phone:</strong> +977-1-XXXXXXX</p>
                    </div>
                </div>
            </div>

            <div class="glass-card rounded-2xl p-8 md:p-12">
                <h2 class="text-2xl font-headline font-bold mb-6 text-primary-container">Changes to This Policy</h2>
                <div class="space-y-6 text-on-surface-variant">
                    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last updated" date.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection