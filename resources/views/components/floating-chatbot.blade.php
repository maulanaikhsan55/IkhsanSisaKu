<!-- Floating Chatbot -->
<div id="floatingChatbot" class="fixed bottom-4 left-4 right-4 sm:left-auto sm:right-6 sm:bottom-6 z-50 font-sans flex justify-end">
    <!-- AI Chatbot Button -->
    <button type="button" id="chatbubbleBtn"
            class="w-14 h-14 sm:w-16 sm:h-16 bg-gradient-to-br from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-full shadow-xl hover:shadow-2xl flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95 relative group"
            onclick="toggleFloatingChat(event)" title="Chat dengan AI Sisaku">
        <!-- Clean Modern AI Robot Icon -->
        <div class="relative flex items-center justify-center">
            <i class="fas fa-robot text-xl sm:text-2xl"></i>
            <!-- Subtle AI Indicator -->
            <div class="absolute -top-1 -right-1 w-2 h-2 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full border border-white shadow-sm"></div>
        </div>

        <!-- AI Label (shows on hover) -->
        <div class="absolute -top-12 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap shadow-lg">
            AI Chatbot
            <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800"></div>
        </div>
    </button>

    <!-- Chat Window -->
    <div id="floatingChatWindow" style="display: none; position: absolute; bottom: 5rem; right: 0; width: 360px; max-width: calc(100vw - 32px); height: 500px; background: white; border-radius: 1.25rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15); overflow: hidden; flex-direction: column; border: 1px solid rgba(0, 0, 0, 0.05);">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 text-white p-4 sm:p-5 flex-shrink-0 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 bg-green-200 rounded-full animate-pulse"></div>
                <div class="min-w-0">
                    <div class="font-bold text-sm sm:text-base leading-tight">Sisaku Chat</div>
                    <div class="text-xs text-green-100 mt-0.5">Bank Sampah AI</div>
                </div>
            </div>
            <button type="button" onclick="toggleFloatingChat(event)" class="bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-all duration-200 flex-shrink-0" title="Tutup">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>

        <!-- Messages Container -->
        <div id="floatingChatMessagesContainer" class="flex-1 overflow-y-auto overflow-x-hidden bg-gradient-to-b from-gray-50 to-white p-4">
            <div id="floatingChatMessages" class="flex flex-col gap-3">
                <div class="flex justify-center py-8">
                    <div class="text-center">
                        <div class="text-5xl mb-3">💬</div>
                        <div class="text-gray-700 text-sm font-medium">Halo! Selamat datang</div>
                        <div class="text-gray-500 text-xs mt-2 leading-relaxed max-w-xs">Tanya tentang sampah, harga, transaksi, atau fitur Sisaku. AI siap membantu! 🌱</div>
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
        <div class="border-t border-gray-200 bg-white p-3 sm:p-4 flex-shrink-0 rounded-b-xl">
            <form id="floatingChatForm" class="flex gap-2 sm:gap-3" onsubmit="handleChatSubmit(event)">
                <input type="text" id="floatingMessageInput" placeholder="Ketik pesan..." 
                       class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-full text-sm focus:outline-none focus:border-green-500 focus:ring-2 focus:ring-green-200 transition-all bg-gray-50 focus:bg-white"
                       required autocomplete="off">
                <button type="submit" class="px-4 sm:px-5 py-3 sm:py-3 mr-2 bg-gradient-to-r from-green-500 to-emerald-500 hover:from-green-600 hover:to-emerald-600 text-white rounded-full transition-all duration-200 hover:shadow-lg active:scale-95 flex-shrink-0 flex items-center justify-center" title="Kirim">
                    <i class="fas fa-paper-plane text-lg sm:text-lg"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
let isLoading = false;

function toggleFloatingChat(e) {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    const chatWindow = document.getElementById('floatingChatWindow');
    
    if (!chatWindow) return;
    
    const isHidden = chatWindow.style.display === 'none';
    
    if (isHidden) {
        chatWindow.style.display = 'flex';
        chatWindow.style.animation = 'scaleIn 0.3s cubic-bezier(0.36, 0, 0.66, -0.56)';
        setTimeout(() => {
            const input = document.getElementById('floatingMessageInput');
            if (input) input.focus();
        }, 100);
    } else {
        chatWindow.style.display = 'none';
    }
}

async function handleChatSubmit(e) {
    e.preventDefault();
    
    if (isLoading) return;
    
    const messageInput = document.getElementById('floatingMessageInput');
    const message = messageInput.value.trim();
    
    if (!message) return;

    addMessageToFloatingChat(message, 'user');
    messageInput.value = '';
    
    isLoading = true;
    showFloatingLoadingIndicator();

    try {
        const response = await fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        hideFloatingLoadingIndicator();
        isLoading = false;

        if (data.success && data.message) {
            addMessageToFloatingChat(data.message, 'bot');
        } else {
            addMessageToFloatingChat('Maaf, tidak bisa merespon. Coba lagi!', 'bot');
        }
    } catch (error) {
        hideFloatingLoadingIndicator();
        isLoading = false;
        console.error('Chat error:', error);
        addMessageToFloatingChat('Kesalahan koneksi. Periksa jaringan Anda.', 'bot');
    }
    
    messageInput.focus();
}

function addMessageToFloatingChat(message, sender) {
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
    floatingScrollToBottom();
}

function showFloatingLoadingIndicator() {
    const indicator = document.getElementById('floatingLoadingIndicator');
    if (indicator) {
        indicator.style.display = 'flex';
        floatingScrollToBottom();
    }
}

function hideFloatingLoadingIndicator() {
    const indicator = document.getElementById('floatingLoadingIndicator');
    if (indicator) {
        indicator.style.display = 'none';
    }
}

function floatingScrollToBottom() {
    const container = document.getElementById('floatingChatMessagesContainer');
    if (container) {
        requestAnimationFrame(() => {
            container.scrollTop = container.scrollHeight;
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const floatingMessageInput = document.getElementById('floatingMessageInput');
    
    if (floatingMessageInput) {
        floatingMessageInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                handleChatSubmit(new Event('submit'));
            }
        });
    }
});
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

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-4px);
        }
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.6;
        }
    }

    #floatingChatWindow {
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

    /* Firefox scrollbar */
    #floatingChatMessagesContainer {
        scrollbar-width: thin;
        scrollbar-color: rgba(34, 197, 94, 0.3) transparent;
    }

    #chatbubbleBtn {
        box-shadow: 0 10px 25px -5px rgba(34, 197, 94, 0.3);
    }

    #chatbubbleBtn:hover {
        box-shadow: 0 15px 35px -5px rgba(34, 197, 94, 0.45);
    }

    @media (max-width: 640px) {
        #floatingChatWindow {
            width: 85vw !important;
            right: 8px !important;
            bottom: 5rem !important;
            height: 65vh !important;
        }
    }
</style>
