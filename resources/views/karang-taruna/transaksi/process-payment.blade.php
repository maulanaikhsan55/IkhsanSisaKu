@extends('karang-taruna.layouts.app')

@section('title', 'Catat Penjualan Sampah - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center gap-4">
                <a href="{{ route('karang-taruna.transaksi.show', $transaksi) }}"
                   class="p-3 hover:bg-white/50 rounded-xl transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Catat Penjualan Sampah</h1>
                    <p class="text-gray-600 mt-1">Catat penjualan sampah yang telah disetor ke bank sampah</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 animate-scale-in">
            
            <!-- Transaksi Info -->
            <div class="mb-8 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-200">
                <h3 class="font-semibold text-gray-900 mb-3">Detail Transaksi</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-600">Warga:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ $transaksi->warga?->nama ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Kategori:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ $transaksi->kategoriSampah->nama_kategori }}</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Berat:</span>
                        <span class="font-semibold text-gray-900 ml-2">{{ number_format($transaksi->berat_kg, 2) }} kg</span>
                    </div>
                    <div>
                        <span class="text-gray-600">Harga Awal:</span>
                        <span class="font-semibold text-gray-900 ml-2">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('karang-taruna.transaksi.processPayment', $transaksi) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Harga Penjualan -->
                <div>
                    <label for="harga_pembayaran" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nilai Penjualan Sampah untuk Desa <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                        <input type="number" name="harga_pembayaran" id="harga_pembayaran" 
                               step="0.01" min="0.01" 
                               value="{{ old('harga_pembayaran', $transaksi->harga_pembayaran ?? $transaksi->total_harga) }}"
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                               placeholder="0.00" required>
                    </div>
                    @error('harga_pembayaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="fas fa-info-circle mr-1"></i>
                        Masukkan jumlah nilai penjualan sampah yang diterima dari bank sampah
                    </p>
                </div>

                <!-- Catatan Penjualan -->
                <div>
                    <label for="catatan_pembayaran" class="block text-sm font-semibold text-gray-700 mb-2">
                        Catatan Tambahan
                    </label>
                    <textarea name="catatan_pembayaran" id="catatan_pembayaran" rows="4"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"
                              placeholder="Contoh: Penjualan sesuai laporan bank sampah tanggal...">{{ old('catatan_pembayaran', $transaksi->catatan) }}</textarea>
                    @error('catatan_pembayaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Box -->
                <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div class="flex gap-3">
                        <i class="fas fa-lightbulb text-blue-600 mt-0.5"></i>
                        <div class="text-sm text-blue-900">
                            <p class="font-semibold mb-1">Informasi Penting:</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Status transaksi akan berubah menjadi "Sudah Disetor"</li>
                                <li>Akan dicatat otomatis dalam laporan Arus Kas</li>
                                <li>Nilai penjualan akan ditambahkan ke kas desa</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.transaksi.show', $transaksi) }}"
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-check-circle mr-2"></i>
                        Sudah Terbayar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

.animate-scale-in {
    animation: scaleIn 0.5s ease-out;
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

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
</style>
@endpush

@endsection
