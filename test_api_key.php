<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Testing GROQ API Key Configuration:\n";
echo "===================================\n\n";

$apiKey = config('app.groq_api_key');
echo "API Key from config('app.groq_api_key'): " . ($apiKey ? "SET (length: " . strlen($apiKey) . ")" : "NOT SET") . "\n";

$envKey = env('GROQ_API_KEY');
echo "API Key from env('GROQ_API_KEY'): " . ($envKey ? "SET (length: " . strlen($envKey) . ")" : "NOT SET") . "\n";

if ($apiKey) {
    echo "\nAPI Key starts with: " . substr($apiKey, 0, 10) . "...\n";
    echo "API Key ends with: ..." . substr($apiKey, -10) . "\n";
}

echo "\nTesting API connection...\n";

if (!$apiKey) {
    echo "❌ API Key not configured. Please add GROQ_API_KEY to your .env file.\n";
    exit(1);
}

try {
    $response = Illuminate\Support\Facades\Http::timeout(10)
        ->withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])
        ->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'user', 'content' => 'Hello']
            ],
            'max_tokens' => 10
        ]);

    if ($response->successful()) {
        echo "✅ API connection successful!\n";
        echo "Response: " . json_encode($response->json());
    } else {
        echo "❌ API connection failed!\n";
        echo "Status: " . $response->status() . "\n";
        echo "Response: " . $response->body() . "\n";
    }
} catch (Exception $e) {
    echo "❌ API connection error: " . $e->getMessage() . "\n";
}
