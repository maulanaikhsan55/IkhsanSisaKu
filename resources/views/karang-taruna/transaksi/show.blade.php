@extends('karang-taruna.layouts.app')

@section('title', 'Detail Transaksi Sampah - SisaKu')

@section('content')
<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="mb-6 sm:mb-8 animate-fade-in-up">
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('karang-taruna.transaksi.index') }}"
                   class="p-2.5 sm:p-3 hover:bg-white/50 rounded-lg sm:rounded-xl transition-colors flex-shrink-0 min-h-[48px] min-w-[48px] flex items-center justify-center">
                    <i class="fas fa-arrow-left text-gray-600 text-lg sm:text-xl"></i>
                </a>
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">Detail Transaksi</h1>
                    <p class="text-gray-600 mt-1 text-xs sm:text-sm">ID #{{ $transaksi->id }} - Tanggal {{ $transaksi->tanggal_transaksi->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Transaction Overview -->
        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4 mb-6 sm:mb-8">
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-5 shadow-lg border border-green-200/30 hover:border-green-300/50 transition-all animate-scale-in">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-700 mb-1 sm:mb-2">Warga</p>
                        <h3 class="text-sm sm:text-lg md:text-2xl font-bold text-gray-900 truncate">{{ $transaksi->warga?->nama ?? 'N/A' }}</h3>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-user text-green-600 text-xs sm:text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-5 shadow-lg border border-green-200/30 hover:border-green-300/50 transition-all animate-scale-in" style="animation-delay: 0.05s;">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-700 mb-1 sm:mb-2">Total Berat</p>
                        <h3 class="text-sm sm:text-lg md:text-2xl font-bold text-gray-900"><span class="block">{{ number_format((float)$transaksi->total_berat, 2) }}</span><span class="text-xs text-gray-500 font-semibold">kg</span></h3>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-weight text-green-600 text-xs sm:text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-5 shadow-lg border border-green-200/30 hover:border-green-300/50 transition-all animate-scale-in" style="animation-delay: 0.1s;">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-700 mb-1 sm:mb-2">Total Harga</p>
                        <h3 class="text-sm sm:text-lg md:text-2xl font-bold text-gray-900 leading-tight break-words">Rp{{ number_format((float) ($transaksi->total_harga_from_items ?? 0), 0) }}</h3>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-wallet text-green-600 text-xs sm:text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-5 shadow-lg border border-green-200/30 hover:border-green-300/50 transition-all animate-scale-in" style="animation-delay: 0.15s;">
                <div class="flex items-start justify-between gap-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-700 mb-1 sm:mb-2">Status</p>
                        <span class="inline-block px-2 sm:px-3 py-0.5 sm:py-1 text-xs font-semibold rounded-full whitespace-nowrap
                            {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'Disetor' : 'Belum' }}
                        </span>
                    </div>
                    <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check-circle text-green-600 text-xs sm:text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-2xl shadow-xl border border-white/20 overflow-hidden mb-6 sm:mb-8 animate-scale-in">
            <div class="px-3 sm:px-6 py-3 sm:py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <h3 class="text-xs sm:text-base md:text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-box text-green-600"></i>
                    <span>Item Transaksi <span class="text-xs sm:text-sm font-normal text-gray-600">({{ $transaksi->items->count() }} item)</span></span>
                </h3>
            </div>

            <!-- Desktop Table -->
            <div class="hidden sm:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-700">#</th>
                            <th class="px-3 sm:px-4 md:px-6 py-3 text-left text-xs font-semibold text-gray-700">Kategori</th>
                            <th class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs font-semibold text-gray-700">Berat (kg)</th>
                            <th class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs font-semibold text-gray-700">Harga/kg</th>
                            <th class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs font-semibold text-gray-700">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transaksi->items as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-3 sm:px-4 md:px-6 py-3 text-xs sm:text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-3 sm:px-4 md:px-6 py-3">
                                <span class="inline-flex px-2 sm:px-3 py-0.5 sm:py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                                    {{ $item->kategoriSampah?->nama_kategori ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs sm:text-sm font-medium text-gray-900">{{ number_format((float)$item->berat_kg, 2) }}</td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs sm:text-sm font-medium text-gray-900">Rp {{ number_format((float)$item->harga_per_kg, 0) }}</td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs sm:text-sm font-bold text-green-600">Rp {{ number_format((float)$item->total_harga, 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-3 sm:px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                                <p class="text-xs sm:text-sm">Tidak ada item dalam transaksi ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($transaksi->items->count() > 0)
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="2" class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs sm:text-sm font-bold text-gray-900">TOTAL:</td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 text-right text-xs sm:text-sm font-bold text-gray-900">{{ number_format((float)$transaksi->getTotalBeratAttribute(), 2) }} kg</td>
                            <td class="px-3 sm:px-4 md:px-6 py-3"></td>
                            <td class="px-3 sm:px-4 md:px-6 py-3 text-right text-sm sm:text-lg font-bold text-green-600">Rp {{ number_format((float)$transaksi->total_harga_from_items, 0) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>

            <!-- Mobile Cards View -->
            <div class="sm:hidden divide-y divide-gray-200 p-3">
                @forelse($transaksi->items as $index => $item)
                <div class="py-3 first:pt-0">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <span class="text-xs font-semibold text-gray-700">#{{ $index + 1 }}</span>
                        <span class="inline-flex px-2 py-0.5 text-xs font-semibold bg-green-100 text-green-800 rounded-full">
                            {{ $item->kategoriSampah?->nama_kategori ?? 'N/A' }}
                        </span>
                    </div>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div>
                            <p class="text-gray-600 mb-1">Berat</p>
                            <p class="font-semibold text-gray-900">{{ number_format((float)$item->berat_kg, 2) }} kg</p>
                        </div>
                        <div>
                            <p class="text-gray-600 mb-1">Harga/kg</p>
                            <p class="font-semibold text-gray-900">Rp {{ number_format((float)$item->harga_per_kg, 0) }}</p>
                        </div>
                    </div>
                    <div class="mt-2 pt-2 border-t border-gray-200">
                        <p class="text-gray-600 text-xs mb-1">Total</p>
                        <p class="text-sm font-bold text-green-600">Rp {{ number_format((float)$item->total_harga, 0) }}</p>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-gray-500">
                    <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                    <p class="text-xs">Tidak ada item</p>
                </div>
                @endforelse
                @if($transaksi->items->count() > 0)
                <div class="py-3 bg-gray-50 -mx-3 px-3 mt-3 rounded-lg">
                    <div class="flex justify-between mb-2">
                        <span class="text-xs font-bold text-gray-700">Total Berat:</span>
                        <span class="text-xs font-bold text-gray-900">{{ number_format((float)$transaksi->getTotalBeratAttribute(), 2) }} kg</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs font-bold text-gray-700">Total Harga:</span>
                        <span class="text-sm font-bold text-green-600">Rp {{ number_format((float)$transaksi->total_harga_from_items, 0) }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Transaction Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Info Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-white/20 shadow-lg">
                <h3 class="text-xs sm:text-base md:text-lg font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded flex sm:rounded-lg items-center justify-center">
                        <i class="fas fa-info-circle text-green-600 text-xs sm:text-base"></i>
                    </div>
                    Informasi Transaksi
                </h3>
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-200 text-xs sm:text-sm">
                        <span class="text-gray-600">ID Transaksi</span>
                        <span class="font-bold text-gray-900 text-right">#{{ $transaksi->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 text-xs sm:text-sm">
                        <span class="text-gray-600">Tanggal</span>
                        <span class="font-bold text-gray-900 text-right">{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200 text-xs sm:text-sm">
                        <span class="text-gray-600">Telepon Warga</span>
                        <span class="font-bold text-gray-900 text-right">{{ $transaksi->warga?->no_telepon ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2 text-xs sm:text-sm">
                        <span class="text-gray-600">Status</span>
                        <span class="inline-flex px-2 sm:px-2.5 py-0.5 text-xs font-semibold rounded-full
                            {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'Sudah' : 'Belum' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Financial Summary Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-2xl p-4 sm:p-6 md:p-8 border border-white/20 shadow-lg">
                <h3 class="text-xs sm:text-base md:text-lg font-bold text-gray-900 mb-4 sm:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-green-100 rounded flex sm:rounded-lg items-center justify-center">
                        <i class="fas fa-calculator text-green-600 text-xs sm:text-base"></i>
                    </div>
                    Ringkasan Keuangan
                </h3>
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-200 text-xs sm:text-sm">
                        <span class="text-gray-600">Nilai Sampah</span>
                        <span class="font-bold text-gray-900 text-right">Rp {{ number_format($transaksi->getTotalHargaFromItemsAttribute(), 0) }}</span>
                    </div>
                    @if($transaksi->status_penjualan === 'sudah_terjual' && $transaksi->harga_pembayaran)
                    <div class="flex justify-between py-2 border-b border-gray-200 text-xs sm:text-sm">
                        <span class="text-gray-600">Kontribusi Desa (Dicatat)</span>
                        <span class="font-bold text-blue-600 text-right">Rp {{ number_format((float)$transaksi->harga_pembayaran, 0) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between py-3 sm:py-4 border-t-2 border-gray-200 bg-green-50 -mx-4 sm:-mx-6 md:-mx-8 px-4 sm:px-6 md:px-8 rounded text-xs sm:text-sm">
                        <span class="font-bold text-gray-900">Nilai Kontribusi untuk Desa</span>
                        <span class="font-bold text-green-600 text-sm sm:text-lg text-right">Rp {{ number_format($transaksi->harga_pembayaran ?? $transaksi->total_harga_from_items, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Info for Paid Transactions -->
        @if($transaksi->status_penjualan === 'sudah_terjual')
        <div class="bg-green-50 border border-green-200 rounded-lg sm:rounded-2xl p-3 sm:p-6 mb-6 sm:mb-8 flex items-start gap-3">
            <i class="fas fa-check-circle text-base sm:text-2xl text-green-600 mt-0.5 flex-shrink-0"></i>
            <div class="min-w-0 flex-1">
                <p class="font-bold text-green-900 text-xs sm:text-base">Sudah Disetor ke Bank Sampah</p>
                <p class="text-xs text-green-700 mt-1">Sampah telah disetor ke bank sampah dan nilainya telah dicatat sebagai kontribusi untuk desa. Untuk perubahan, hubungi administrator.</p>
            </div>
        </div>
        @else
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg sm:rounded-2xl p-3 sm:p-6 mb-6 sm:mb-8 flex items-start gap-3">
            <i class="fas fa-hourglass-half text-base sm:text-2xl text-emerald-600 mt-0.5 flex-shrink-0"></i>
            <div class="min-w-0 flex-1">
                <p class="font-bold text-emerald-900 text-xs sm:text-base">Menunggu Penyetoran ke Bank Sampah</p>
                <p class="text-xs text-emerald-700 mt-1">Sampah masih menumpuk. Setelah disetor ke bank sampah dan menerima pembayaran, klik tombol "Sudah Terbayar" untuk mencatat penjualan sampah.</p>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col gap-2 sm:gap-3">
            @if($transaksi->status_penjualan === 'belum_terjual')
            <a href="{{ route('karang-taruna.transaksi.processPaymentForm', $transaksi) }}"
               class="flex-1 px-4 md:px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all text-center text-sm md:text-base min-h-[48px] flex items-center justify-center">
                <i class="fas fa-check-circle mr-2"></i>
                Sudah Terbayar
            </a>

            <a href="{{ route('karang-taruna.transaksi.edit', $transaksi) }}"
               class="flex-1 px-4 md:px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all text-center text-sm md:text-base min-h-[48px] flex items-center justify-center">
                <i class="fas fa-edit mr-2"></i>
                Edit Transaksi
            </a>

            <form action="{{ route('karang-taruna.transaksi.destroy', $transaksi) }}" method="POST" class="flex-1"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full px-4 md:px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all text-sm md:text-base min-h-[48px] flex items-center justify-center">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Transaksi
                </button>
            </form>
            @endif
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
