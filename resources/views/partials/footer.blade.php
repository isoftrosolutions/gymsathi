<!-- Footer -->
<footer class="bg-[#0C0E13] py-12">
    <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="font-headline font-bold text-[#C8F135] text-xl">
            <a href="{{ route('welcome') }}">GymSathi</a>
        </div>
        <div class="flex flex-wrap justify-center gap-8">
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-all text-sm font-label {{ request()->routeIs('privacy-policy') ? 'text-primary-container font-bold' : '' }}" href="{{ route('privacy-policy') }}">Privacy Policy</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-all text-sm font-label {{ request()->routeIs('terms-of-service') ? 'text-primary-container font-bold' : '' }}" href="{{ route('terms-of-service') }}">Terms of Service</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-all text-sm font-label {{ request()->routeIs('security') ? 'text-primary-container font-bold' : '' }}" href="{{ route('security') }}">Security</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-all text-sm font-label {{ request()->routeIs('contact-support') ? 'text-primary-container font-bold' : '' }}" href="{{ route('contact-support') }}">Contact Support</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-all text-sm font-label {{ request()->routeIs('sectors') ? 'text-primary-container font-bold' : '' }}" href="{{ route('sectors') }}">Sector Solutions</a>
        </div>

        <div class="text-[#C5C9AE] text-sm font-body">
            © {{ date('Y') }} GymSathi Kinetic. All rights reserved.
        </div>
    </div>
</footer>
