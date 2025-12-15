<!-- Floating Chatbot - Modern Design -->
<div id="floatingChatContainer" class="fixed bottom-6 right-6 z-50 font-sans">
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

    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
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
    let isLoading = false;

    chatIcon.addEventListener('click', function() {
        chatWindow.classList.toggle('hidden');
        if (!chatWindow.classList.contains('hidden')) {
            chatInput.focus();
        }
    });

    closeBtn.addEventListener('click', function() {
        chatWindow.classList.add('hidden');
    });

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message || isLoading) return;

        addMessage(message, 'user');
        chatInput.value = '';
        isLoading = true;

        try {
            const response = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            if (data.success && data.message) {
                addMessage(data.message, 'bot');
            } else {
                addMessage('Maaf, ada kesalahan. Coba lagi!', 'bot');
            }
        } catch (error) {
            console.error('Error:', error);
            addMessage('AI offline. Coba lagi nanti!', 'bot');
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
