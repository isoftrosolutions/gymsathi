<!-- GymSathi AI Chat Widget -->
<div id="gymsathi-chat">

    <!-- Floating Button -->
    <button id="chat-toggle" onclick="toggleChat()" aria-label="Open chat support">
        <span id="chat-icon-open" class="material-symbols-outlined">chat_bubble</span>
        <span id="chat-icon-close" class="material-symbols-outlined" style="display:none;">close</span>
    </button>

    <!-- Chat Window -->
    <div id="chat-window" style="display:none;">
        <div id="chat-header">
            <div id="chat-header-info">
                <div id="chat-avatar">
                   <span class="material-symbols-outlined" style="font-size: 20px;">smart_toy</span>
                </div>
                <div>
                    <div id="chat-name">GymSathi Assistant</div>
                    <div id="chat-status">🟢 Online</div>
                </div>
            </div>
            <button onclick="toggleChat()" id="chat-close-btn">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div id="chat-messages">
            <div class="chat-msg bot-msg">
                👋 Hi! I'm the GymSathi assistant. Ask me anything about our gym management platform, pricing, or features!
            </div>
        </div>

        <div id="chat-input-area">
            <input
                type="text"
                id="chat-input"
                placeholder="Ask a question..."
                onkeypress="handleKeyPress(event)"
                maxlength="500"
            />
            <button id="chat-send" onclick="sendMessage()">
                <span class="material-symbols-outlined">send</span>
            </button>
        </div>
    </div>
</div>

<style>
#gymsathi-chat {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 99999;
    font-family: 'Space Grotesk', sans-serif;
}

#chat-toggle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #C8F135;
    color: #0a0a0a;
    border: none;
    cursor: pointer;
    font-size: 1.5rem;
    box-shadow: 0 4px 20px rgba(200, 241, 53, 0.4);
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

#chat-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 28px rgba(200, 241, 53, 0.6);
}

#chat-window {
    position: absolute;
    bottom: 75px;
    right: 0;
    width: 360px;
    height: 500px;
    background: #1a1a1a;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 20px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}

#chat-header {
    background: #C8F135;
    color: #0a0a0a;
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

#chat-header-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

#chat-avatar {
    width: 36px;
    height: 36px;
    background: #0a0a0a;
    color: #C8F135;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 1rem;
}

#chat-name {
    font-weight: 700;
    font-size: 0.9rem;
}

#chat-status {
    font-size: 0.7rem;
    opacity: 0.7;
}

#chat-close-btn {
    background: none;
    border: none;
    cursor: pointer;
    font-size: 1rem;
    color: #0a0a0a;
    padding: 4px;
}

#chat-messages {
    flex: 1;
    overflow-y: auto;
    padding: 16px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

#chat-messages::-webkit-scrollbar {
    width: 4px;
}
#chat-messages::-webkit-scrollbar-track {
    background: transparent;
}
#chat-messages::-webkit-scrollbar-thumb {
    background: rgba(255,255,255,0.1);
    border-radius: 4px;
}

.chat-msg {
    max-width: 85%;
    padding: 10px 14px;
    border-radius: 16px;
    font-size: 0.85rem;
    line-height: 1.5;
    word-wrap: break-word;
}

.bot-msg {
    background: #2a2a2a;
    color: #e0e0e0;
    border-bottom-left-radius: 4px;
    align-self: flex-start;
}

.user-msg {
    background: #C8F135;
    color: #0a0a0a;
    border-bottom-right-radius: 4px;
    align-self: flex-end;
    font-weight: 500;
}

.typing-indicator {
    background: #2a2a2a;
    color: rgba(255,255,255,0.4);
    font-style: italic;
    font-size: 0.8rem;
    padding: 10px 14px;
    border-radius: 16px;
    border-bottom-left-radius: 4px;
    align-self: flex-start;
}

#chat-input-area {
    padding: 12px 16px;
    border-top: 1px solid rgba(255,255,255,0.08);
    display: flex;
    gap: 8px;
    background: #1a1a1a;
}

#chat-input {
    flex: 1;
    background: #2a2a2a;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 24px;
    padding: 10px 16px;
    color: #fff;
    font-family: inherit;
    font-size: 0.85rem;
    outline: none;
}

#chat-input:focus {
    border-color: #C8F135;
}

#chat-input::placeholder {
    color: rgba(255,255,255,0.3);
}

#chat-send {
    width: 40px;
    height: 40px;
    background: #C8F135;
    border: none;
    border-radius: 50%;
    color: #0a0a0a;
    cursor: pointer;
    flex-shrink: 0;
    transition: transform 0.15s;
    display: flex;
    align-items: center;
    justify-content: center;
}

#chat-send .material-symbols-outlined {
    font-size: 1.2rem;
}

#chat-send:hover {
    transform: scale(1.1);
}

@media (max-width: 420px) {
    #chat-window {
        width: calc(100vw - 48px);
        right: -12px;
    }
}
</style>

<script>
let chatHistory = [];
let isOpen = false;
let isWaiting = false;

function toggleChat() {
    isOpen = !isOpen;
    const chatWindow = document.getElementById('chat-window');
    const iconOpen = document.getElementById('chat-icon-open');
    const iconClose = document.getElementById('chat-icon-close');

    chatWindow.style.display = isOpen ? 'flex' : 'none';
    iconOpen.style.display = isOpen ? 'none' : 'block';
    iconClose.style.display = isOpen ? 'block' : 'none';

    if (isOpen) {
        document.getElementById('chat-input').focus();
    }
}

function handleKeyPress(event) {
    if (event.key === 'Enter' && !isWaiting) {
        sendMessage();
    }
}

function addMessage(text, role) {
    const container = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.classList.add('chat-msg');
    div.classList.add(role === 'user' ? 'user-msg' : 'bot-msg');
    div.textContent = text;
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
    return div;
}

function showTyping() {
    const container = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.classList.add('typing-indicator');
    div.id = 'typing-indicator';
    div.textContent = 'GymSathi is thinking...';
    container.appendChild(div);
    container.scrollTop = container.scrollHeight;
}

function removeTyping() {
    const el = document.getElementById('typing-indicator');
    if (el) el.remove();
}

async function sendMessage() {
    const input = document.getElementById('chat-input');
    const message = input.value.trim();

    if (!message || isWaiting) return;

    input.value = '';
    isWaiting = true;
    document.getElementById('chat-send').disabled = true;

    // Add user message to UI
    addMessage(message, 'user');
    chatHistory.push({ role: 'user', content: message });

    // Show typing indicator
    showTyping();

    try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const response = await fetch("{{ route('chatbot') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken || '',
            },
            body: JSON.stringify({
                message: message,
                history: chatHistory.slice(-6),
            }),
        });

        const data = await response.json();
        removeTyping();

        const reply = data.reply || 'Sorry, I could not process that. Please contact support.';
        addMessage(reply, 'bot');
        chatHistory.push({ role: 'assistant', content: reply });

    } catch (error) {
        removeTyping();
        addMessage('Connection error. Please try again or contact us at mind59024@gmail.com', 'bot');
    }

    isWaiting = false;
    document.getElementById('chat-send').disabled = false;
    input.focus();
}
</script>
