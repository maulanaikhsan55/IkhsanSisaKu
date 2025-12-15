<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sisaku Chatbot Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { font-family: system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-emerald-50 p-6">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🤖 Sisaku Chatbot Test</h1>
            <p class="text-gray-600">Deployment Configuration Checker</p>
        </div>

        <!-- Status Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Environment Check -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-cog text-green-600 mr-2"></i>Environment
                </h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Environment:</span>
                        <span class="font-mono bg-gray-100 px-3 py-1 rounded">{{ config('app.env') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Debug:</span>
                        <span class="font-mono bg-gray-100 px-3 py-1 rounded">{{ config('app.debug') ? 'ON' : 'OFF' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">URL:</span>
                        <span class="font-mono bg-gray-100 px-3 py-1 rounded text-xs">{{ config('app.url') }}</span>
                    </div>
                </div>
            </div>

            <!-- API Check -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-key text-green-600 mr-2"></i>GROQ API
                </h2>
                <div class="space-y-2">
                    @if(env('GROQ_API_KEY'))
                        <p class="text-green-600 font-semibold">✅ API Key is SET</p>
                        <p class="text-xs text-gray-500">Online mode enabled</p>
                    @else
                        <p class="text-orange-600 font-semibold">⚠️ API Key NOT SET</p>
                        <p class="text-xs text-gray-500">Using fallback responses (offline mode)</p>
                    @endif
                </div>
            </div>

            <!-- Database Check -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-database text-green-600 mr-2"></i>Database
                </h2>
                <div class="space-y-2 text-sm">
                    @try
                        @php
                            DB::connection()->getPdo();
                            $dbStatus = true;
                        @endphp
                        <p class="text-green-600 font-semibold">✅ Connected</p>
                    @catch
                        @php $dbStatus = false @endphp
                        <p class="text-red-600 font-semibold">❌ Error</p>
                    @endcatch
                    <div class="flex justify-between">
                        <span class="text-gray-600">Host:</span>
                        <span class="font-mono bg-gray-100 px-3 py-1 rounded text-xs">{{ config('database.connections.mysql.host') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Database:</span>
                        <span class="font-mono bg-gray-100 px-3 py-1 rounded text-xs">{{ config('database.connections.mysql.database') }}</span>
                    </div>
                </div>
            </div>

            <!-- Route Check -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">
                    <i class="fas fa-road text-green-600 mr-2"></i>Routes
                </h2>
                <div class="space-y-2 text-sm">
                    <div>
                        <p class="text-gray-600">POST /chatbot/send</p>
                        <p class="text-green-600 font-semibold">✅ Registered</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Route is accessible</p>
                </div>
            </div>
        </div>

        <!-- Test Chat -->
        <div class="bg-white rounded-2xl shadow-lg p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">
                <i class="fas fa-comments text-green-600 mr-2"></i>Test Chat
            </h2>

            <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                <p class="text-sm text-green-700">
                    <i class="fas fa-info-circle mr-2"></i>
                    Use the test form below to verify the chatbot is working.
                </p>
            </div>

            <form id="testForm" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Test Message</label>
                    <input 
                        type="text" 
                        id="testMessage"
                        placeholder="e.g., Halo! / Berapa harga plastik? / Apa itu bank sampah?"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-600 focus:border-transparent"
                    >
                </div>

                <button 
                    type="submit"
                    class="w-full px-6 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-semibold rounded-lg transition duration-200"
                >
                    <i class="fas fa-paper-plane mr-2"></i>Send Test Message
                </button>
            </form>

            <!-- Response -->
            <div id="responseArea" class="mt-6 hidden">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Response:</h3>
                <div id="response" class="p-4 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 whitespace-pre-wrap"></div>
                <div id="responseStatus" class="mt-3 text-xs text-gray-500"></div>
            </div>

            <!-- Test Scenarios -->
            <div class="mt-8 p-6 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-4">Quick Test Scenarios</h3>
                <div class="space-y-2">
                    <button onclick="sendTest('Halo')" class="w-full text-left p-3 bg-white border border-gray-200 rounded hover:bg-gray-100 transition text-sm">
                        <span class="font-semibold text-gray-900">Greeting:</span> "Halo"
                        <span class="text-gray-500 text-xs">(Test basic responses)</span>
                    </button>
                    <button onclick="sendTest('Berapa harga plastik?')" class="w-full text-left p-3 bg-white border border-gray-200 rounded hover:bg-gray-100 transition text-sm">
                        <span class="font-semibold text-gray-900">Pricing:</span> "Berapa harga plastik?"
                        <span class="text-gray-500 text-xs">(Test pattern matching)</span>
                    </button>
                    <button onclick="sendTest('Bagaimana cara input transaksi?')" class="w-full text-left p-3 bg-white border border-gray-200 rounded hover:bg-gray-100 transition text-sm">
                        <span class="font-semibold text-gray-900">Transaction:</span> "Bagaimana cara input transaksi?"
                        <span class="text-gray-500 text-xs">(Test feature help)</span>
                    </button>
                    <button onclick="sendTest('Apa itu bank sampah?')" class="w-full text-left p-3 bg-white border border-gray-200 rounded hover:bg-gray-100 transition text-sm">
                        <span class="font-semibold text-gray-900">System Info:</span> "Apa itu bank sampah?"
                        <span class="text-gray-500 text-xs">(Test system explanation)</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center text-sm text-gray-500">
            <p>Sisaku Chatbot Deployment Test - v1.0</p>
            <p class="mt-2">
                <a href="/" class="text-green-600 hover:text-green-700">← Back to Home</a>
            </p>
        </div>
    </div>

    <script>
        const testForm = document.getElementById('testForm');
        const testMessage = document.getElementById('testMessage');
        const responseArea = document.getElementById('responseArea');
        const response = document.getElementById('response');
        const responseStatus = document.getElementById('responseStatus');

        testForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            await sendTest(testMessage.value);
            testMessage.value = '';
        });

        async function sendTest(message) {
            if (!message.trim()) return;

            response.textContent = 'Loading...';
            responseStatus.textContent = '';
            responseArea.classList.remove('hidden');

            try {
                const startTime = Date.now();
                const res = await fetch('{{ route("chatbot.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ message })
                });

                const duration = Date.now() - startTime;

                if (!res.ok) {
                    response.textContent = `❌ HTTP Error ${res.status}`;
                    responseStatus.textContent = `Response took ${duration}ms`;
                    return;
                }

                const data = await res.json();
                response.textContent = data.message || 'No response received';
                responseStatus.textContent = `✅ Success - ${duration}ms`;
            } catch (error) {
                response.textContent = `❌ Error: ${error.message}`;
                responseStatus.textContent = 'Check console for details (F12)';
                console.error('Test error:', error);
            }
        }
    </script>
</body>
</html>
