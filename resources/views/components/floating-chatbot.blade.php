<!-- Floating Chatbot Component - Clean & Reliable -->
<div id="floatingChatbot" class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:bottom-6 z-40 font-sans flex justify-end" style="opacity: 0; visibility: hidden; transition: opacity 0.2s cubic-bezier(0.4, 0, 0.6, 1); will-change: opacity; backface-visibility: hidden;">
    <!-- Welcome Arrow (shows only on first visit) -->
    <div id="welcomeArrow" class="absolute bottom-20 right-2 opacity-0 pointer-events-none z-10">
        <div class="bg-white text-gray-900 px-3 py-2 rounded-lg shadow-lg text-xs font-medium whitespace-nowrap border border-gray-200">
            💡 AI Assistant Tersedia
            <div class="absolute top-full right-4 border-4 border-transparent border-t-white"></div>
        </div>
        <div class="absolute top-8 right-6 text-gray-400">
            <i class="fas fa-arrow-down text-lg opacity-60"></i>
        </div>
    </div>

    <!-- AI Chatbot Button -->
    <button type="button" id="chatbubbleBtn"
            class="w-16 h-16 sm:w-18 sm:h-18 bg-gradient-to-br from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white rounded-2xl shadow-2xl hover:shadow-3xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 relative group"
            onclick="toggleFloatingChat()" title="Chat dengan AI Sisaku">
        <!-- Modern AI Icon with Gradient -->
        <div class="relative flex items-center justify-center">
            <div class="absolute inset-0 bg-white/20 rounded-xl blur-sm"></div>
            <i class="fas fa-robot text-2xl sm:text-3xl relative z-10 drop-shadow-sm"></i>
            <!-- Subtle AI Indicator -->
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 rounded-full border-2 border-white shadow-lg animate-soft-pulse"></div>
            <div class="absolute -top-1 -right-1 w-3 h-3 bg-gradient-to-r from-blue-400 via-purple-500 to-pink-500 rounded-full border-2 border-white shadow-lg"></div>
        </div>

        <!-- Enhanced AI Label -->
        <div class="absolute -top-16 -left-20 bg-gradient-to-r from-gray-800 to-gray-700 text-white text-xs px-3 py-2 rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 whitespace-nowrap shadow-xl border border-gray-600 z-20">
            🤖 AI Chatbot Sisaku
            <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
        </div>
    </button>

    <!-- Chat Window -->
    <div id="floatingChatWindow" class="floating-chat-hidden" style="position: absolute; bottom: 5rem; right: 0; width: 380px; max-width: calc(100vw - 32px); height: 520px; background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%); border-radius: 1.5rem; box-shadow: 0 32px 64px -12px rgba(0, 0, 0, 0.2), 0 0 0 1px rgba(34, 197, 94, 0.1); overflow: hidden; flex-direction: column; backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.2); will-change: transform, opacity; backface-visibility: hidden;">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 text-white p-4 flex-shrink-0 flex items-center justify-between relative overflow-hidden">
            <!-- Animated background pattern -->
            <div class="absolute inset-0 opacity-20">
                <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-r from-transparent via-white/10 to-transparent animate-pulse"></div>
            </div>
            <div class="flex items-center gap-3 relative z-10">
                <div class="relative">
                    <div class="w-3 h-3 bg-green-200 rounded-full animate-pulse shadow-lg"></div>
                    <div class="absolute inset-0 w-3 h-3 bg-green-200 rounded-full animate-ping opacity-75"></div>
                </div>
                <div class="min-w-0">
                    <div class="font-bold text-base leading-tight flex items-center gap-2">
                        🤖 Sisaku AI
                        <span class="text-xs bg-white/20 px-2 py-0.5 rounded-full font-medium">Beta</span>
                    </div>
                    <div class="text-xs text-green-100 mt-0.5">Asisten Pintar Bank Sampah</div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <!-- Button Close -->
                <button type="button" id="closeChatBtn" onclick="closeFloatingChat(event)" class="bg-white/20 hover:bg-white/30 text-white p-2 rounded-lg transition-all duration-200 hover:scale-110 cursor-pointer z-20 relative" title="Tutup">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Messages Container -->
        <div id="floatingChatMessagesContainer" class="flex-1 overflow-y-auto overflow-x-hidden bg-gradient-to-b from-gray-50 to-white p-4">
            <div id="floatingChatMessages" class="flex flex-col gap-3">
                <div class="flex justify-center py-6">
                    <div class="text-center">
                        <div class="text-5xl mb-3">💬</div>
                        <div class="text-gray-700 text-sm font-medium">Halo! Selamat datang</div>
                        <div class="text-gray-500 text-xs mt-2 leading-relaxed max-w-xs">Tanya tentang sampah, harga, transaksi, atau fitur Sisaku. AI siap membantu! 🌱</div>

                        <!-- Quick Action Buttons -->
                        <div class="mt-4 flex flex-col gap-2">
                            <button onclick="sendQuickMessage('Berapa harga plastik hari ini?')" class="px-4 py-2 bg-white border border-green-200 hover:border-green-400 text-green-700 text-xs rounded-lg transition-all hover:shadow-md">
                                💰 Cek harga plastik
                            </button>
                            <button onclick="sendQuickMessage('Bagaimana cara melakukan transaksi?')" class="px-4 py-2 bg-white border border-green-200 hover:border-green-400 text-green-700 text-xs rounded-lg transition-all hover:shadow-md">
                                📋 Cara transaksi
                            </button>
                            <button onclick="sendQuickMessage('Kategori sampah apa saja yang diterima?')" class="px-4 py-2 bg-white border border-green-200 hover:border-green-400 text-green-700 text-xs rounded-lg transition-all hover:shadow-md">
                                🗂️ Kategori sampah
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading -->
            <div id="floatingLoadingIndicator" style="display: none; padding: 0.5rem 0; margin-top: 0.5rem;">
                <div class="flex gap-2 justify-center">
                    <div class="w-2 h-2 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full animate-bounce" style="animation-delay: 0s;"></div>
                    <div class="w-2 h-2 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.1s;"></div>
                    <div class="w-2 h-2 bg-gradient-to-r from-green-400 to-emerald-400 rounded-full animate-bounce" style="animation-delay: 0.2s;"></div>
                </div>
            </div>
        </div>

        <!-- Input -->
        <div class="border-t border-gray-200/50 bg-white/80 backdrop-blur-sm p-3 flex-shrink-0 rounded-b-2xl">
            <form id="floatingChatForm" class="flex gap-2" onsubmit="handleChatSubmit(event)">
                <div class="flex-1 relative">
                    <input type="text" id="floatingMessageInput" placeholder="Tanya apa saja..."
                           class="w-full px-3 py-2.5 pr-10 border border-gray-300/50 rounded-xl text-sm focus:outline-none focus:border-green-400 focus:ring-2 focus:ring-green-200/50 transition-all bg-white/70 backdrop-blur-sm shadow-sm focus:shadow-md"
                           required autocomplete="off">
                </div>
                <button type="submit" class="px-4 py-2.5 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:via-emerald-600 hover:to-teal-600 text-white rounded-xl transition-all duration-300 hover:shadow-xl active:scale-95 flex-shrink-0 flex items-center justify-center group" title="Kirim Pesan">
                    <i class="fas fa-paper-plane text-sm group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform duration-200"></i>
                </button>
            </form>

            <!-- Footer Actions -->
            <div class="mt-2 flex items-center justify-center text-xs">
                <span class="text-gray-500 opacity-75">AI Sisaku 24/7 🌱</span>
            </div>
        </div>
    </div>
</div>

<script>
// Floating Chatbot - Clean Implementation
let isLoading = false;
let floatingChatHistory = [];
let floatingChatInitialized = false;

// Toggle chat window visibility
function toggleFloatingChat() {
    const chatWindow = document.getElementById('floatingChatWindow');
    if (!chatWindow) return;

    const isHidden = chatWindow.classList.contains('floating-chat-hidden');

    if (isHidden) {
        openFloatingChat();
    } else {
        closeFloatingChat();
    }
}

// Open chat window
function openFloatingChat() {
    const chatWindow = document.getElementById('floatingChatWindow');
    if (!chatWindow) return;

    chatWindow.classList.remove('floating-chat-hidden');
    chatWindow.style.animation = 'scaleIn 0.3s cubic-bezier(0.36, 0, 0.66, -0.56)';

    setTimeout(() => {
        const input = document.getElementById('floatingMessageInput');
        if (input) input.focus();
    }, 100);
}

// Close chat window
function closeFloatingChat(event) {
    if (event) {
        event.preventDefault();
        event.stopPropagation();
    }

    const chatWindow = document.getElementById('floatingChatWindow');
    if (!chatWindow) return;

    chatWindow.classList.add('floating-chat-hidden');
}

// Handle form submission
async function handleChatSubmit(e) {
    e.preventDefault();

    if (isLoading) return;

    const messageInput = document.getElementById('floatingMessageInput');
    const message = messageInput.value.trim();

    if (!message) return;

    // Store in memory
    floatingChatHistory.push({ message: message, sender: 'user' });

    addMessageToChat(message, 'user');
    messageInput.value = '';

    isLoading = true;
    showLoadingIndicator();

    try {
        const response = await fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });

        const data = await response.json();
        hideLoadingIndicator();
        isLoading = false;

        if (data.success && data.message) {
            floatingChatHistory.push({ message: data.message, sender: 'bot' });
            addMessageToChat(data.message, 'bot');
        } else {
            const errorMsg = 'Maaf, tidak bisa merespon. Coba lagi!';
            floatingChatHistory.push({ message: errorMsg, sender: 'bot' });
            addMessageToChat(errorMsg, 'bot');
        }
    } catch (error) {
        hideLoadingIndicator();
        isLoading = false;

        const errorMsg = 'Saat ini AI chat sedang offline. Silakan gunakan menu sistem Sisaku untuk bantuan. Sistem tetap berfungsi normal!';
        floatingChatHistory.push({ message: errorMsg, sender: 'bot' });
        addMessageToChat(errorMsg, 'bot');
    } finally {
        messageInput.focus();
    }
}

// Send quick message
function sendQuickMessage(message) {
    const messageInput = document.getElementById('floatingMessageInput');
    if (messageInput) {
        messageInput.value = message;
        handleChatSubmit(new Event('submit'));
    }
}

// Add message to chat
function addMessageToChat(message, sender) {
    const chatMessages = document.getElementById('floatingChatMessages');
    if (!chatMessages) return;

    // Remove welcome message if it exists
    const welcomeMessage = chatMessages.querySelector('.flex.justify-center');
    if (welcomeMessage) welcomeMessage.remove();

    // Create message container
    const messageDiv = document.createElement('div');
    messageDiv.className = sender === 'user' ? 'message-container-user' : 'message-container-bot';

    // Create message bubble
    const msgBubble = document.createElement('div');
    msgBubble.className = sender === 'user' ? 'message-bubble message-user' : 'message-bubble message-bot';
    msgBubble.textContent = message;

    messageDiv.appendChild(msgBubble);
    chatMessages.appendChild(messageDiv);
    
    // Save history to sessionStorage
    sessionStorage.setItem('chatbot_floating_history', JSON.stringify(floatingChatHistory));
    
    scrollToBottom();
}

// Show loading indicator
function showLoadingIndicator() {
    const indicator = document.getElementById('floatingLoadingIndicator');
    if (indicator) {
        indicator.style.display = 'flex';
        scrollToBottom();
    }
}

// Hide loading indicator
function hideLoadingIndicator() {
    const indicator = document.getElementById('floatingLoadingIndicator');
    if (indicator) {
        indicator.style.display = 'none';
    }
}

// Scroll to bottom
function scrollToBottom() {
    const container = document.getElementById('floatingChatMessagesContainer');
    if (container) {
        requestAnimationFrame(() => {
            container.scrollTop = container.scrollHeight;
        });
    }
}

// Initialize on DOM load
function initializeFloatingChatbot() {
    if (floatingChatInitialized) return;
    floatingChatInitialized = true;

    const messageInput = document.getElementById('floatingMessageInput');
    const welcomeArrow = document.getElementById('welcomeArrow');
    const closeBtn = document.getElementById('closeChatBtn');
    const loadingIndicator = document.getElementById('floatingLoadingIndicator');
    const chatWindow = document.getElementById('floatingChatWindow');
    const chatbot = document.getElementById('floatingChatbot');

    if (!chatWindow) return;

    // Ensure initial state is clean - no display changes, only classes
    chatWindow.classList.add('floating-chat-hidden');
    if (loadingIndicator) {
        loadingIndicator.style.display = 'none';
    }
    isLoading = false;

    // Ensure chatbot is visible - use minimal changes
    if (chatbot) {
        chatbot.style.opacity = '1';
        chatbot.style.visibility = 'visible';
        chatbot.style.pointerEvents = 'auto';
    }

    // Close button event listener
    if (closeBtn) {
        closeBtn.removeEventListener('click', closeFloatingChat);
        closeBtn.addEventListener('click', function(e) {
            closeFloatingChat(e);
        });
    }

    // Enter key handler
    if (messageInput) {
        messageInput.removeEventListener('keydown', handleKeyDown);
        messageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleChatSubmit(new Event('submit'));
            }
        });
    }

    // Welcome arrow animation - show only on first visit
    if (welcomeArrow) {
        const arrowShown = localStorage.getItem('chatbot_arrow_shown');
        
        if (!arrowShown) {
            // Delay arrow animation to ensure page is fully loaded
            const arrowTimeout1 = setTimeout(() => {
                if (welcomeArrow) {
                    welcomeArrow.style.animation = 'fadeInUp 0.6s ease-out forwards';
                    welcomeArrow.style.opacity = '1';
                    localStorage.setItem('chatbot_arrow_shown', 'true');
                }
            }, 2500);

            const arrowTimeout2 = setTimeout(() => {
                if (welcomeArrow) {
                    welcomeArrow.style.animation = 'fadeOut 0.8s ease-out forwards';
                    welcomeArrow.style.opacity = '0';
                }
            }, 6500);

            // Cleanup timeouts on unload
            window.addEventListener('beforeunload', () => {
                clearTimeout(arrowTimeout1);
                clearTimeout(arrowTimeout2);
            }, { once: true });
        } else {
            welcomeArrow.style.display = 'none';
        }
    }

    // Load chat history from sessionStorage
    const savedHistory = sessionStorage.getItem('chatbot_floating_history');
    if (savedHistory) {
        try {
            floatingChatHistory = JSON.parse(savedHistory);
        } catch (e) {
        }
    }
}

// Initialize when DOM is ready - with check for already initialized
const handleKeyDown = (e) => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        handleChatSubmit(new Event('submit'));
    }
};

if (document.readyState === 'loading') {
    const initOnDOMReady = () => {
        initializeFloatingChatbot();
        document.removeEventListener('DOMContentLoaded', initOnDOMReady);
    };
    document.addEventListener('DOMContentLoaded', initOnDOMReady);
} else {
    // DOM already loaded
    initializeFloatingChatbot();
}
</script>

<style>
    #floatingChatbot {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .message-bubble {
        padding: 0.75rem 1rem;
        border-radius: 1.25rem;
        word-break: break-word;
        white-space: pre-wrap;
        font-size: 0.875rem;
        max-width: 280px;
        line-height: 1.5;
        font-family: inherit;
        animation: slideIn 0.3s ease-out;
    }

    .message-user {
        background: linear-gradient(to bottom right, #22c55e, #10b981);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
    }

    .message-bot {
        background: #f3f4f6;
        color: #1f2937;
        border-bottom-left-radius: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    .message-container-user {
        display: flex;
        justify-content: flex-end;
    }

    .message-container-bot {
        display: flex;
        justify-content: flex-start;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(15px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
        }
        to {
            opacity: 0;
        }
    }

    #floatingChatWindow {
        animation: none;
    }
    
    #floatingChatWindow:not(.floating-chat-hidden) {
        animation: scaleIn 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #floatingChatMessagesContainer {
        scroll-behavior: smooth;
    }

    #floatingChatMessagesContainer::-webkit-scrollbar {
        width: 5px;
    }

    #floatingChatMessagesContainer::-webkit-scrollbar-track {
        background: transparent;
    }

    #floatingChatMessagesContainer::-webkit-scrollbar-thumb {
        background: rgba(34, 197, 94, 0.3);
        border-radius: 5px;
    }

    #floatingChatMessagesContainer::-webkit-scrollbar-thumb:hover {
        background: rgba(34, 197, 94, 0.5);
    }

    #floatingChatMessagesContainer {
        scrollbar-width: thin;
        scrollbar-color: rgba(34, 197, 94, 0.3) transparent;
    }

    #chatbubbleBtn {
        box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.3);
    }

    #chatbubbleBtn:hover {
        box-shadow: 0 15px 35px -5px rgba(34, 197, 94, 0.45);
        transform: translateY(-2px) scale(1.05);
    }

    #floatingChatWindow {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
    }

    .message-user {
        background: linear-gradient(135deg, #22c55e 0%, #10b981 50%, #059669 100%);
        box-shadow: 0 8px 25px rgba(34, 197, 94, 0.3);
    }

    .message-bot {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .animate-soft-pulse {
        animation: softPulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes softPulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    @media (max-width: 640px) {
        #floatingChatWindow {
            width: 90vw !important;
            right: 8px !important;
            bottom: 5rem !important;
            height: 70vh !important;
        }

        #welcomeArrow {
            bottom: 18rem !important;
            right: 1rem !important;
        }

        #chatbubbleBtn {
            width: 18vw !important;
            height: 18vw !important;
            min-width: 60px !important;
            min-height: 60px !important;
        }
    }

    @media (max-width: 480px) {
        #floatingChatWindow {
            width: 95vw !important;
            height: 75vh !important;
        }
    }

    .floating-chat-hidden {
        display: none !important;
        visibility: hidden !important;
    }

    /* Prevent initial flash */
    #floatingChatWindow {
        backface-visibility: hidden;
        -webkit-backface-visibility: hidden;
        perspective: 1000px;
        -webkit-perspective: 1000px;
        will-change: auto;
    }

    /* Smooth content loading animations */
    @media (prefers-reduced-motion: no-preference) {
        main, .flex-1, [role="main"] {
            animation: fadeInContent 0.4s cubic-bezier(0.4, 0, 0.2, 1) both;
        }

        @keyframes fadeInContent {
            from {
                opacity: 0;
                transform: translateY(4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    }
</style>
