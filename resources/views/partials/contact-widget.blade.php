<!-- Gemini Kinetic Support Chat Widget -->
<div class="fixed bottom-8 right-8 z-[100] flex flex-col items-end gap-4">
    <!-- Chat Window Popover -->
    <div id="contact-popover" class="hidden animate-in fade-in slide-in-from-bottom-4 duration-300">
        <div class="glass-card rounded-[2rem] flex flex-col w-80 md:w-96 h-[500px] shadow-2xl border border-primary-lime/20 mb-2 overflow-hidden">
            <!-- Header -->
            <div class="p-6 bg-primary-lime/10 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full kinetic-gradient flex items-center justify-center">
                            <span class="material-symbols-outlined text-on-primary text-xl">bolt</span>
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-[#111318] rounded-full"></span>
                    </div>
                    <div>
                        <h4 class="text-white font-headline font-bold text-sm tracking-tight">Gemini Kinetic Support</h4>
                        <p class="text-[10px] text-primary-lime font-bold uppercase tracking-widest">Always Active</p>
                    </div>
                </div>
                <button onclick="toggleContactPopover()" class="text-on-surface-variant hover:text-white transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Chat Body (Scrollable) -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-6 space-y-4 no-scrollbar">
                <!-- Initial Bot Message -->
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary-lime/10 flex items-center justify-center flex-shrink-0 mt-1">
                        <span class="material-symbols-outlined text-primary-lime text-xs">bolt</span>
                    </div>
                    <div class="bg-surface-container-high rounded-2xl rounded-tl-none p-4 max-w-[80%]">
                        <p class="text-sm text-on-surface leading-relaxed">
                            Namaste! I'm your Gemini Kinetic assistant. How can I help you automate your facility today?
                        </p>
                        <span class="text-[9px] text-on-surface-variant/40 mt-2 block uppercase tracking-widest">Just now</span>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 bg-black/20 border-t border-white/5">
                <div class="relative flex items-center gap-2">
                    <input type="text" id="chat-input" 
                        onkeypress="handleChatKeyPress(event)"
                        placeholder="Type your query..." 
                        class="w-full bg-surface-container-low border border-white/10 rounded-full px-5 py-3 text-sm focus:border-primary-lime focus:outline-none transition-all pr-12">
                    <button onclick="sendChatMessage()" class="absolute right-1 w-10 h-10 rounded-full kinetic-gradient flex items-center justify-center hover:scale-105 active:scale-95 transition-all">
                        <span class="material-symbols-outlined text-on-primary text-xl">send</span>
                    </button>
                </div>
                <p class="text-[9px] text-center text-on-surface-variant/40 mt-3 uppercase tracking-[0.2em]">Powered by Gemini Kinetic Systems</p>
            </div>
        </div>
    </div>

    <!-- Toggle Button -->
    <button onclick="toggleContactPopover()" class="w-16 h-16 rounded-full kinetic-gradient shadow-xl shadow-primary-lime/20 flex items-center justify-center hover:scale-110 active:scale-95 transition-all group relative">
        <span id="contact-icon" class="material-symbols-outlined text-on-primary text-3xl transition-transform group-hover:rotate-12">chat_bubble</span>
        <span id="close-icon" class="hidden material-symbols-outlined text-on-primary text-3xl">close</span>
        <!-- Notification Dot -->
        <span id="notif-dot" class="absolute top-0 right-0 w-4 h-4 bg-red-500 border-2 border-[#111318] rounded-full animate-pulse"></span>
    </button>
</div>

<script>
const chatMessages = document.getElementById('chat-messages');
const chatInput = document.getElementById('chat-input');
const notifDot = document.getElementById('notif-dot');

function toggleContactPopover() {
    const popover = document.getElementById('contact-popover');
    const contactIcon = document.getElementById('contact-icon');
    const closeIcon = document.getElementById('close-icon');
    
    if (popover.classList.contains('hidden')) {
        popover.classList.remove('hidden');
        contactIcon.classList.add('hidden');
        closeIcon.classList.remove('hidden');
        notifDot.classList.add('hidden');
        // Focus input after opening
        setTimeout(() => chatInput.focus(), 300);
    } else {
        popover.classList.add('hidden');
        contactIcon.classList.remove('hidden');
        closeIcon.classList.add('hidden');
    }
}

function handleChatKeyPress(e) {
    if (e.key === 'Enter') {
        sendChatMessage();
    }
}

function addMessage(text, isUser = false) {
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const msgDiv = document.createElement('div');
    msgDiv.className = `flex gap-3 ${isUser ? 'flex-row-reverse' : ''} animate-in fade-in slide-in-from-bottom-2 duration-300`;
    
    const icon = isUser ? 'person' : 'bolt';
    const iconClass = isUser ? 'bg-secondary/10 text-secondary' : 'bg-primary-lime/10 text-primary-lime';
    const bgClass = isUser ? 'bg-primary-lime text-on-primary rounded-tr-none' : 'bg-surface-container-high text-on-surface rounded-tl-none';
    
    msgDiv.innerHTML = `
        <div class="w-8 h-8 rounded-full ${iconClass} flex items-center justify-center flex-shrink-0 mt-1">
            <span class="material-symbols-outlined text-xs">${icon}</span>
        </div>
        <div class="${bgClass} rounded-2xl p-4 max-w-[80%]">
            <p class="text-sm leading-relaxed">${text}</p>
            <span class="text-[9px] ${isUser ? 'text-on-primary/60' : 'text-on-surface-variant/40'} mt-2 block uppercase tracking-widest">${time}</span>
        </div>
    `;
    
    chatMessages.appendChild(msgDiv);
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

function sendChatMessage() {
    const text = chatInput.value.trim();
    if (!text) return;
    
    // Add user message
    addMessage(text, true);
    chatInput.value = '';
    
    // Simulate Gemini Thinking
    setTimeout(() => {
        const response = getGeminiResponse(text);
        addMessage(response, false);
    }, 1000);
}

function getGeminiResponse(query) {
    const q = query.toLowerCase();
    
    if (q.includes('price') || q.includes('cost') || q.includes('package')) {
        return "Our kinetic plans start at NPR 800/mo. You can see the full breakdown on our Pricing section. Would you like me to link you there?";
    }
    if (q.includes('contact') || q.includes('phone') || q.includes('call')) {
        return "You can reach us at 9811144402 or visit our Parsa office at Birgunj-13, Radhemai. We're open Mon-Fri!";
    }
    if (q.includes('esewa') || q.includes('khalti') || q.includes('pay')) {
        return "Absolutely! We support eSewa, Khalti, and Bank Transfers. Payments are tracked automatically in your dashboard.";
    }
    if (q.includes('trial') || q.includes('free') || q.includes('test')) {
        return "We offer a 30-day full access trial! No credit card needed. Just click 'Get Started' in the header to begin your kinetic journey.";
    }
    
    return "That's a great question about our kinetic systems. Let me connect you with one of our specialists, or you can check our Support page for detailed docs!";
}
</script>
