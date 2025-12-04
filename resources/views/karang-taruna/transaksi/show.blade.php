@extends('karang-taruna.layouts.app')

@section('title', 'Detail Transaksi Sampah - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center gap-4">
                <a href="{{ route('karang-taruna.transaksi.index') }}"
                   class="p-3 hover:bg-white/50 rounded-xl transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-4xl font-bold text-gray-900">Detail Transaksi</h1>
                    <p class="text-gray-600 mt-1">ID #{{ $transaksi->id }} - Tanggal {{ $transaksi->tanggal_transaksi->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Transaction Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                <p class="text-gray-600 text-sm mb-1">Warga</p>
                <p class="text-2xl font-bold text-gray-900">{{ $transaksi->warga?->nama ?? 'N/A' }}</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                <p class="text-gray-600 text-sm mb-1">Total Berat</p>
                <p class="text-2xl font-bold text-green-600">{{ number_format($transaksi->getTotalBeratAttribute(), 2) }} kg</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                <p class="text-gray-600 text-sm mb-1">Total Harga</p>
                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($transaksi->getTotalHargaFromItemsAttribute(), 0) }}</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-6 border border-white/20 shadow-lg">
                <p class="text-gray-600 text-sm mb-1">Status</p>
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
                    {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'Sudah Disetor' : 'Belum Disetor' }}
                </span>
            </div>
        </div>

        <!-- Items Table -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden mb-8 animate-scale-in">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-box text-blue-600"></i>
                    Item Transaksi ({{ $transaksi->items->count() }} item)
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Berat (kg)</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga/kg</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transaksi->items as $index => $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">
                                    {{ $item->kategoriSampah?->nama_kategori ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">{{ number_format($item->berat_kg, 2) }}</td>
                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900">Rp {{ number_format($item->harga_per_kg, 0) }}</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-green-600">Rp {{ number_format($item->total_harga, 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                                <p>Tidak ada item dalam transaksi ini</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($transaksi->items->count() > 0)
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-right font-bold text-gray-900">TOTAL:</td>
                            <td class="px-6 py-4 text-right text-sm font-bold text-gray-900">{{ number_format($transaksi->getTotalBeratAttribute(), 2) }} kg</td>
                            <td class="px-6 py-4"></td>
                            <td class="px-6 py-4 text-right text-lg font-bold text-green-600">Rp {{ number_format($transaksi->getTotalHargaFromItemsAttribute(), 0) }}</td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Transaction Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Info Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-white/20 shadow-lg">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-info-circle text-green-600"></i>
                    </div>
                    Informasi Transaksi
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">ID Transaksi</span>
                        <span class="font-bold text-gray-900">#{{ $transaksi->id }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Tanggal Transaksi</span>
                        <span class="font-bold text-gray-900">{{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">No. Telepon Warga</span>
                        <span class="font-bold text-gray-900">{{ $transaksi->warga?->no_telepon ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-sm text-gray-600">Status Penyetoran</span>
                        <span class="inline-flex px-2.5 py-0.5 text-xs font-semibold rounded-full
                            {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $transaksi->status_penjualan == 'sudah_terjual' ? 'Sudah Disetor' : 'Belum Disetor' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Financial Summary Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 border border-white/20 shadow-lg">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calculator text-blue-600"></i>
                    </div>
                    Ringkasan Keuangan
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Nilai Sampah</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($transaksi->getTotalHargaFromItemsAttribute(), 0) }}</span>
                    </div>
                    @if($transaksi->status_penjualan === 'sudah_terjual' && $transaksi->harga_pembayaran)
                    <div class="flex justify-between py-2 border-b border-gray-200">
                        <span class="text-sm text-gray-600">Kontribusi Desa (Dicatat)</span>
                        <span class="font-bold text-blue-600">Rp {{ number_format($transaksi->harga_pembayaran, 0) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between py-4 border-t-2 border-gray-200 bg-green-50 -mx-4 px-4 rounded">
                        <span class="font-bold text-gray-900">Nilai Kontribusi untuk Desa</span>
                        <span class="font-bold text-green-600 text-lg">Rp {{ number_format($transaksi->harga_pembayaran ?? $transaksi->getTotalHargaFromItemsAttribute(), 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Info for Paid Transactions -->
        @if($transaksi->status_penjualan === 'sudah_terjual')
        <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8 flex items-center gap-3">
            <i class="fas fa-check-circle text-2xl text-green-600"></i>
            <div>
                <p class="font-bold text-green-900">Sudah Disetor ke Bank Sampah</p>
                <p class="text-sm text-green-700">Sampah telah disetor ke bank sampah dan nilainya telah dicatat sebagai kontribusi untuk desa. Untuk perubahan, hubungi administrator.</p>
            </div>
        </div>
        @else
        <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6 mb-8 flex items-center gap-3">
            <i class="fas fa-hourglass-half text-2xl text-yellow-600"></i>
            <div>
                <p class="font-bold text-yellow-900">Menunggu Penyetoran ke Bank Sampah</p>
                <p class="text-sm text-yellow-700">Sampah masih menumpuk. Setelah disetor ke bank sampah dan menerima pembayaran, klik tombol "Sudah Terbayar" untuk mencatat penjualan sampah.</p>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            @if($transaksi->status_penjualan === 'belum_terjual')
            <a href="{{ route('karang-taruna.transaksi.processPaymentForm', $transaksi) }}"
               class="flex-1 px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all text-center">
                <i class="fas fa-check-circle mr-2"></i>
                Sudah Terbayar
            </a>

            <a href="{{ route('karang-taruna.transaksi.edit', $transaksi) }}"
               class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all text-center">
                <i class="fas fa-edit mr-2"></i>
                Edit Transaksi
            </a>

            <form action="{{ route('karang-taruna.transaksi.destroy', $transaksi) }}" method="POST" class="flex-1"
                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="w-full px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus Transaksi
                </button>
            </form>
            @else
            <a href="{{ route('karang-taruna.transaksi.index') }}"
               class="flex-1 px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all text-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
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
