<!-- Top Navigation Bar -->
<nav class="fixed top-0 w-full z-50 bg-[#111318]/80 backdrop-blur-xl">
    <div class="max-w-7xl mx-auto px-8 h-20 flex justify-between items-center">
        <div class="text-2xl font-bold tracking-tighter text-[#C8F135] font-headline">
            <a href="{{ route('welcome') }}">GymSathi</a>
        </div>
        <div class="hidden md:flex items-center gap-8">
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight {{ request()->routeIs('sectors') ? 'text-[#C8F135] font-bold border-b-2 border-[#C8F135] pb-1' : '' }}" href="{{ route('sectors') }}">Sectors</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight" href="#features">Features</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight" href="#pricing">Pricing</a>
            <a class="text-[#C5C9AE] hover:text-[#C8F135] transition-colors font-headline tracking-tight" href="#about">About</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="text-[#C5C9AE] hover:text-[#C8F135] transition-all px-4 py-2 font-headline font-medium tracking-tight">Login</a>
            <button class="kinetic-gradient text-on-primary font-headline font-bold px-6 py-2.5 rounded-full hover:opacity-90 transition-all active:scale-95">Get Started</button>
        </div>
    </div>
</nav>
