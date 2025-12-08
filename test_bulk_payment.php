<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\TransaksiSampah;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "Testing bulk payment logic...\n";

// Check if there are any karang taruna users
$karangTarunaUsers = User::where('role', 'karang_taruna')->get();

if ($karangTarunaUsers->isEmpty()) {
    echo "No karang taruna users found.\n";
    exit(1);
}

// Use the first karang taruna user
$user = $karangTarunaUsers->first();
Auth::login($user);

echo "Using user: {$user->name}\n";
echo "Karang Taruna ID: {$user->karangTaruna->id}\n";

// Get transactions that are belum_terjual
$transaksiIds = TransaksiSampah::where('karang_taruna_id', $user->karangTaruna->id)
    ->where('status_penjualan', 'belum_terjual')
    ->pluck('id')
    ->toArray();

if (empty($transaksiIds)) {
    echo "No transactions found that are belum_terjual.\n";
    exit(1);
}

echo "Found transactions: " . implode(', ', $transaksiIds) . "\n";

// Simulate the bulkProcessPayment logic
$totalCalculated = 0;
foreach ($transaksiIds as $id) {
    $transaksi = TransaksiSampah::find($id);
    if ($transaksi->karang_taruna_id !== $user->karangTaruna->id) {
        continue;
    }

    $hargaPembayaran = $transaksi->items()->exists()
        ? $transaksi->items()->sum('total_harga')
        : ($transaksi->total_harga ?? 0);

    $totalCalculated += $hargaPembayaran;
    echo "Transaction {$id}: Rp " . number_format($hargaPembayaran) . "\n";
}

echo "Total calculated: Rp " . number_format($totalCalculated) . "\n";

echo "Bulk payment logic test completed.\n";
