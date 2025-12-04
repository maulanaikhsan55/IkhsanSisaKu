@extends('admin.layouts.app')

@section('title', 'Chatbot AI - SisaKu')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-6 animate-fade-in-up">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Chatbot AI SISAKU</h1>
                <p class="text-sm text-gray-500">Tanya apapun tentang bank sampah, harga, atau transaksi</p>
            </div>
            <button onclick="clearChatHistory()" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg font-medium transition-all text-sm">
                <i class="fas fa-trash mr-2"></i>Hapus Chat
            </button>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="glass-dark rounded-2xl p-6 shadow-modern overflow-hidden border-modern">
        <!-- Chat Messages -->
        <div id="chatMessages" class="h-96 overflow-y-auto mb-4 space-y-4 bg-gray-50 rounded-lg p-4">
            @forelse($messages as $message)
                <div class="flex {{ $message->sender === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="flex gap-3 {{ $message->sender === 'user' ? 'flex-row-reverse' : 'flex-row' }} max-w-xs">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 {{ $message->sender === 'user' ? 'bg-green-500' : 'bg-blue-500' }}">
                            <i class="fas {{ $message->sender === 'user' ? 'fa-user' : 'fa-robot' }} text-white text-sm"></i>
                        </div>
                        <div class="px-4 py-2 rounded-lg {{ $message->sender === 'user' ? 'bg-green-500 text-white rounded-br-none' : 'bg-gray-200 text-gray-900 rounded-bl-none' }} text-sm break-words">
                            {{ $message->message }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-full">
                    <div class="text-center">
                        <i class="fas fa-robot text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500">Mulai percakapan dengan chatbot AI SISAKU</p>
                        <p class="text-xs text-gray-400 mt-2">Tanya tentang harga, kategori, atau cara transaksi</p>
                    </div>
                </div>
            @endforelse
            <div id="loadingIndicator" class="hidden flex justify-start">
                <div class="flex gap-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-blue-500">
                        <i class="fas fa-robot text-white text-sm"></i>
                    </div>
                    <div class="px-4 py-2 rounded-lg bg-gray-200 rounded-bl-none">
                        <span class="text-gray-600 text-sm">Mengetik<span class="animate-pulse">...</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-200 pt-4">
            <form id="chatForm" class="flex gap-3">
                @csrf
                <input type="text" id="messageInput" name="message" placeholder="Ketik pesan Anda..." 
                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm"
                       required>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg font-medium transition-all flex items-center gap-2">
                    <i class="fas fa-paper-plane"></i>
                    <span class="hidden sm:inline">Kirim</span>
                </button>
            </form>
            <div class="mt-3 flex gap-2 flex-wrap">
                <button onclick="sendQuickMessage('Berapa harga plastik?')" class="px-3 py-1 text-xs bg-blue-50 text-blue-700 rounded-full hover:bg-blue-100 transition-all">Harga plastik?</button>
                <button onclick="sendQuickMessage('Bagaimana cara transaksi?')" class="px-3 py-1 text-xs bg-blue-50 text-blue-700 rounded-full hover:bg-blue-100 transition-all">Cara transaksi?</button>
                <button onclick="sendQuickMessage('Kategori sampah apa saja?')" class="px-3 py-1 text-xs bg-blue-50 text-blue-700 rounded-full hover:bg-blue-100 transition-all">Kategori sampah?</button>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
        <p class="text-xs sm:text-sm text-blue-700">
            <i class="fas fa-info-circle mr-2"></i>
            <strong>Catatan:</strong> Chatbot ini menggunakan AI Google Gemini. Respon berdasarkan data terkini dari SISAKU. Untuk pertanyaan kompleks, hubungi admin.
        </p>
    </div>
</div>

<script>
const chatMessages = document.getElementById('chatMessages');
const chatForm = document.getElementById('chatForm');
const messageInput = document.getElementById('messageInput');
const loadingIndicator = document.getElementById('loadingIndicator');

chatForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const message = messageInput.value.trim();
    
    if (!message) return;

    addMessageToChat(message, 'user');
    messageInput.value = '';
    
    showLoadingIndicator();

    try {
        const response = await fetch('{{ route("chatbot.send") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: message })
        });

        const data = await response.json();
        
        hideLoadingIndicator();

        if (data.success) {
            addMessageToChat(data.message, 'bot');
        } else {
            addMessageToChat('Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
        }
    } catch (error) {
        hideLoadingIndicator();
        console.error('Error:', error);
        addMessageToChat('Terjadi kesalahan koneksi. Silakan coba lagi.', 'bot');
    }
});

function addMessageToChat(message, sender) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `flex ${sender === 'user' ? 'justify-end' : 'justify-start'}`;
    
    const color = sender === 'user' ? 'green' : 'blue';
    const bgClass = sender === 'user' ? 'bg-green-500 text-white rounded-br-none' : 'bg-gray-200 text-gray-900 rounded-bl-none';
    const icon = sender === 'user' ? 'fa-user' : 'fa-robot';

    messageDiv.innerHTML = `
        <div class="flex gap-3 ${sender === 'user' ? 'flex-row-reverse' : 'flex-row'} max-w-xs">
            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 bg-${color}-500">
                <i class="fas ${icon} text-white text-sm"></i>
            </div>
            <div class="px-4 py-2 rounded-lg ${bgClass} text-sm break-words">
                ${escapeHtml(message)}
            </div>
        </div>
    `;

    chatMessages.appendChild(messageDiv);
    scrollToBottom();
}

function showLoadingIndicator() {
    loadingIndicator.classList.remove('hidden');
    scrollToBottom();
}

function hideLoadingIndicator() {
    loadingIndicator.classList.add('hidden');
}

function scrollToBottom() {
    setTimeout(() => {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }, 0);
}

function sendQuickMessage(message) {
    messageInput.value = message;
    chatForm.dispatchEvent(new Event('submit'));
}

function clearChatHistory() {
    if (confirm('Hapus semua pesan chat?')) {
        fetch('{{ route("chatbot.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => {
            location.reload();
        });
    }
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

window.addEventListener('load', scrollToBottom);
</script>

<style>
    .glass-dark {
        background: rgba(255, 255, 255, 0.95);
    }

    #chatMessages::-webkit-scrollbar {
        width: 8px;
    }

    #chatMessages::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    #chatMessages::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    #chatMessages::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>
@endsection
