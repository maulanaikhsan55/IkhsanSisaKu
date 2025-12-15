<!-- Floating Chatbot - Modern Design -->
<div id="floatingChatContainer" class="fixed bottom-6 right-6 z-50 font-sans">
    <!-- Chatbot Onboarding Tooltip -->
    <div id="chatbotTooltip" class="absolute bottom-24 right-0 bg-white rounded-2xl shadow-2xl p-4 max-w-xs pointer-events-auto hidden border border-gray-100" style="width: 280px;">
        <div class="flex items-start gap-3 mb-3">
            <div class="flex-shrink-0">
                <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-full">
                    <i class="fas fa-sparkles text-emerald-600"></i>
                </div>
            </div>
            <div class="flex-1">
                <h4 class="font-bold text-gray-900 text-sm">Bantuan AI Sisaku</h4>
                <p class="text-xs text-gray-600 mt-1">Tanya tentang sampah, harga, transaksi, atau fitur apapun. AI siap membantu! 🌱</p>
            </div>
            <button id="closeChatbotTooltip" class="text-gray-400 hover:text-gray-600 transition flex-shrink-0">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>
        <div class="flex gap-2">
            <button id="dismissTooltip" class="flex-1 px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition">Nanti</button>
            <button id="tryTooltip" class="flex-1 px-3 py-1.5 text-xs font-medium text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 rounded-lg transition">Coba</button>
        </div>
    </div>

    <!-- Chat Icon Button -->
    <button id="chatbotIcon" class="w-16 h-16 bg-gradient-to-br from-emerald-500 via-green-500 to-teal-600 hover:from-emerald-600 hover:via-green-600 hover:to-teal-700 text-white rounded-full shadow-2xl hover:shadow-3xl transition-all duration-300 hover:scale-110 active:scale-95 flex items-center justify-center group relative">
        <i class="fas fa-robot text-2xl"></i>
        <!-- Animated pulse indicator -->
        <div class="absolute -top-1 -right-1 w-4 h-4 bg-gradient-to-r from-blue-400 to-cyan-400 rounded-full border-2 border-white shadow-lg animate-pulse"></div>
    </button>

    <!-- Chat Window -->
    <div id="chatbotWindow" class="hidden absolute bottom-24 right-0 w-96 h-[32rem] bg-gradient-to-b from-white via-gray-50 to-white rounded-2xl shadow-2xl flex flex-col border border-gray-100 overflow-hidden transition-all duration-300">
        <!-- Header -->
        <div class="bg-gradient-to-r from-emerald-500 via-green-500 to-teal-600 text-white p-5 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <div class="w-3 h-3 bg-white rounded-full animate-pulse"></div>
                        <div class="absolute inset-0 w-3 h-3 bg-white rounded-full animate-ping opacity-75"></div>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">🤖 Sisaku AI</h3>
                        <p class="text-xs text-emerald-100">Asisten Bank Sampah</p>
                    </div>
                </div>
                <button id="closeChatbot" class="text-white hover:bg-white/20 p-2 rounded-lg transition-all duration-200 hover:scale-110">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Messages Container -->
        <div id="messagesContainer" class="flex-1 overflow-y-auto p-4 bg-gradient-to-b from-gray-50 to-white scroll-smooth">
            <div id="messagesList" class="flex flex-col gap-3">
                <div class="text-center py-8">
                    <div class="text-5xl mb-3">💬</div>
                    <p class="text-gray-700 font-medium">Halo! Selamat Datang</p>
                    <p class="text-xs text-gray-500 mt-2 leading-relaxed">Tanya tentang sampah, harga, transaksi, atau fitur Sisaku. AI siap membantu! 🌱</p>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-200/50 bg-white p-4 flex-shrink-0 rounded-b-2xl">
            <form id="chatForm" class="flex gap-2">
                <input 
                    type="text" 
                    id="chatInput" 
                    placeholder="Tanya apa saja..." 
                    class="flex-1 px-4 py-3 border border-gray-300/50 rounded-xl text-sm focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-200/50 transition-all bg-white/70 shadow-sm focus:shadow-md"
                    autocomplete="off"
                >
                <button 
                    type="submit" 
                    class="px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white rounded-xl transition-all duration-300 hover:shadow-lg active:scale-95 flex items-center justify-center group"
                    title="Kirim Pesan"
                >
                    <i class="fas fa-paper-plane text-sm group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform duration-200"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    #chatbotWindow {
        opacity: 1;
        transform: scale(0);
        transform-origin: bottom right;
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    #chatbotWindow:not(.hidden) {
        transform: scale(1);
    }

    #messagesContainer {
        scrollbar-width: thin;
        scrollbar-color: rgba(34, 197, 94, 0.3) transparent;
    }

    #messagesContainer::-webkit-scrollbar {
        width: 6px;
    }

    #messagesContainer::-webkit-scrollbar-track {
        background: transparent;
    }

    #messagesContainer::-webkit-scrollbar-thumb {
        background: rgba(34, 197, 94, 0.3);
        border-radius: 3px;
    }

    #messagesContainer::-webkit-scrollbar-thumb:hover {
        background: rgba(34, 197, 94, 0.5);
    }

    .message-enter {
        animation: slideInMessage 0.3s ease-out;
    }

    @keyframes slideInMessage {
        from {
            opacity: 0;
            transform: translateY(8px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    @keyframes subtle-glow {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
        }
        50% {
            box-shadow: 0 0 0 8px rgba(34, 197, 94, 0);
        }
    }

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    #chatbotIcon.first-time {
        animation: subtle-glow 2s infinite;
    }

    #chatbotTooltip {
        animation: slideInMessage 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        opacity: 0;
    }

    #chatbotTooltip:not(.hidden) {
        opacity: 1;
    }

    @media (max-width: 640px) {
        #chatbotTooltip {
            width: 260px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatIcon = document.getElementById('chatbotIcon');
    const chatWindow = document.getElementById('chatbotWindow');
    const closeBtn = document.getElementById('closeChatbot');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');
    const messagesList = document.getElementById('messagesList');
    const chatbotTooltip = document.getElementById('chatbotTooltip');
    const closeChatbotTooltip = document.getElementById('closeChatbotTooltip');
    const dismissTooltip = document.getElementById('dismissTooltip');
    const tryTooltip = document.getElementById('tryTooltip');
    let isLoading = false;
    let isAnimating = false;

    if (!chatIcon || !chatWindow || !closeBtn || !chatForm || !chatInput || !messagesList) {
        return;
    }

    function showTooltip() {
        if (!chatbotTooltip) return;
        chatbotTooltip.classList.remove('hidden');
        chatbotTooltip.style.animation = 'slideInMessage 0.3s ease-out';
    }

    function hideTooltip() {
        if (!chatbotTooltip) return;
        chatbotTooltip.classList.add('hidden');
    }

    function showChatbotOnboarding() {
        const hasSeenOnboarding = localStorage.getItem('sisaku_chatbot_onboarded');
        if (!hasSeenOnboarding) {
            chatIcon.classList.add('first-time');
            setTimeout(() => showTooltip(), 800);
        }
    }

    function markOnboardingComplete() {
        localStorage.setItem('sisaku_chatbot_onboarded', 'true');
        hideTooltip();
        chatIcon.classList.remove('first-time');
    }

    function toggleChat(e) {
        e?.preventDefault();
        if (isAnimating) return;
        isAnimating = true;
        hideTooltip();
        
        const isHidden = chatWindow.classList.contains('hidden');
        if (isHidden) {
            chatWindow.classList.remove('hidden');
            setTimeout(() => chatInput.focus(), 100);
        } else {
            chatWindow.classList.add('hidden');
        }
        
        setTimeout(() => { isAnimating = false; }, 300);
    }

    function closeChat(e) {
        e?.preventDefault();
        if (isAnimating) return;
        isAnimating = true;
        chatWindow.classList.add('hidden');
        setTimeout(() => { isAnimating = false; }, 300);
    }

    chatIcon.addEventListener('click', toggleChat);
    chatIcon.addEventListener('touchstart', function(e) {
        e.preventDefault();
        toggleChat();
    }, { passive: false });

    closeBtn.addEventListener('click', closeChat);
    closeBtn.addEventListener('touchstart', function(e) {
        e.preventDefault();
        closeChat();
    }, { passive: false });

    if (closeChatbotTooltip) {
        closeChatbotTooltip.addEventListener('click', hideTooltip);
        closeChatbotTooltip.addEventListener('touchstart', function(e) {
            e.preventDefault();
            hideTooltip();
        }, { passive: false });
    }

    if (dismissTooltip) {
        dismissTooltip.addEventListener('click', function() {
            markOnboardingComplete();
        });
        dismissTooltip.addEventListener('touchstart', function(e) {
            e.preventDefault();
            markOnboardingComplete();
        }, { passive: false });
    }

    if (tryTooltip) {
        tryTooltip.addEventListener('click', function() {
            markOnboardingComplete();
            toggleChat();
        });
        tryTooltip.addEventListener('touchstart', function(e) {
            e.preventDefault();
            markOnboardingComplete();
            toggleChat();
        }, { passive: false });
    }

    showChatbotOnboarding();

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message || isLoading) return;

        addMessage(message, 'user');
        chatInput.value = '';
        isLoading = true;

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), 20000);

        try {
            const response = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ message }),
                signal: controller.signal
            });

            clearTimeout(timeoutId);

            if (!response.ok) {
                addMessage('❌ Layanan sedang tidak tersedia. Coba lagi nanti.', 'bot');
                return;
            }

            let data;
            try {
                data = await response.json();
            } catch (parseError) {
                addMessage('❌ Kesalahan saat memproses respons. Coba lagi!', 'bot');
                return;
            }

            if (data && data.message) {
                addMessage(data.message, 'bot');
            } else if (data && data.error) {
                addMessage('❌ ' + data.error, 'bot');
            } else {
                addMessage('⚠️ Maaf, ada kesalahan. Coba lagi!', 'bot');
            }
        } catch (error) {
            clearTimeout(timeoutId);

            let errorMsg = '⚠️ Terjadi kesalahan. Silakan coba lagi.';
            if (error.name === 'AbortError') {
                errorMsg = '⏱️ Permintaan timeout. Server tidak merespons. Coba lagi nanti.';
            } else if (error instanceof TypeError && error.message.includes('Failed to fetch')) {
                errorMsg = '🌐 Tidak dapat terhubung ke server. Periksa koneksi internet Anda.';
            }
            addMessage(errorMsg, 'bot');
        } finally {
            isLoading = false;
        }
    });

    function addMessage(text, sender) {
        if (messagesList.querySelector('.text-center')) {
            messagesList.querySelector('.text-center').closest('div').remove();
        }

        const msgWrapper = document.createElement('div');
        msgWrapper.className = sender === 'user' ? 'flex justify-end' : 'flex justify-start';
        
        const msgBubble = document.createElement('div');
        if (sender === 'user') {
            msgBubble.className = 'bg-gradient-to-r from-emerald-500 to-teal-600 text-white px-4 py-3 rounded-2xl max-w-xs text-sm break-words shadow-lg';
        } else {
            msgBubble.className = 'bg-gradient-to-b from-gray-100 to-gray-200 text-gray-800 px-4 py-3 rounded-2xl max-w-xs text-sm break-words shadow-md border border-gray-200';
        }
        
        msgBubble.textContent = text;
        msgBubble.style.animation = 'slideInMessage 0.3s ease-out';
        
        msgWrapper.appendChild(msgBubble);
        messagesList.appendChild(msgWrapper);
        
        setTimeout(() => {
            const container = messagesList.parentElement;
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        }, 0);
    }
});
</script>
