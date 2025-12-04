@extends('karang-taruna.layouts.app')

@section('title', 'Laporan Dampak Lingkungan - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('karang-taruna.dashboard') }}"
                       class="p-3 hover:bg-white/50 rounded-xl transition-colors">
                        <i class="fas fa-arrow-left text-gray-600"></i>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Laporan Dampak Lingkungan</h1>
                        <p class="text-gray-600 mt-1">{{ $summary['bulan_nama'] }} {{ $summary['tahun'] }}</p>
                    </div>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <input type="month" id="bulan-filter" value="{{ $summary['bulan'] }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg">
                    <button onclick="filterBulan()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('karang-taruna.laporan.dampak-lingkungan.export-pdf', request()->query()) }}" class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i><span>Export PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Total Berat Sampah</p>
                <p class="text-2xl font-bold text-blue-600 mt-2">{{ number_format($summary['total_berat'], 2) }} kg</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Pengurangan CO₂e</p>
                <p class="text-2xl font-bold text-emerald-600 mt-2">{{ number_format($summary['total_co2'], 2) }} kg CO₂e</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Jumlah Transaksi</p>
                <p class="text-2xl font-bold text-cyan-600 mt-2">{{ $summary['jumlah_transaksi'] }}</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Warga Partisipan</p>
                <p class="text-2xl font-bold text-purple-600 mt-2">{{ $summary['jumlah_warga'] }}</p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border-l-4 border-blue-600 rounded-lg p-4 mb-8">
            <div class="flex gap-3">
                <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5 flex-shrink-0"></i>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900">Catatan tentang Jumlah Transaksi</h3>
                    <p class="text-sm text-blue-800 mt-1">
                        Kolom "Transaksi" pada tabel kategori menunjukkan <strong>berapa banyak transaksi yang berkontribusi ke kategori tersebut</strong>, 
                        bukan total transaksi keseluruhan. Satu transaksi dapat berisi sampah dari beberapa kategori sekaligus, 
                        sehingga jumlah di setiap kategori bisa berbeda dengan total transaksi.
                    </p>
                </div>
            </div>
        </div>

        <!-- Breakdown Per Kategori -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <i class="fas fa-chart-pie text-blue-600"></i>
                Rincian Per Kategori Sampah
            </h2>

            @if($byCategory->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-blue-50 border-b border-blue-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Kategori</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Berat (kg)</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">CO₂e Berkurang</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">% Berat</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-900 group relative cursor-help">
                                Transaksi
                                <div class="hidden group-hover:block absolute bottom-full mb-2 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs px-2 py-1 rounded whitespace-nowrap z-10">
                                    Jumlah transaksi yang berkontribusi ke kategori ini
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byCategory as $cat)
                        <tr class="border-b border-gray-200 hover:bg-blue-50/30">
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $cat['kategori'] }}</td>
                            <td class="px-4 py-3 text-sm text-right text-gray-600">{{ number_format($cat['total_berat'], 2) }}</td>
                            <td class="px-4 py-3 text-sm text-right font-semibold text-emerald-600">{{ number_format($cat['total_co2'], 2) }} kg CO₂e</td>
                            <td class="px-4 py-3 text-sm text-right">
                                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded">
                                    {{ $summary['total_berat'] > 0 ? round(($cat['total_berat'] / $summary['total_berat']) * 100, 1) : 0 }}%
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-center text-gray-600">{{ $cat['jumlah_transaksi'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada transaksi pada bulan ini</p>
            @endif
        </div>

        <!-- Detail Transaksi -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                <i class="fas fa-list text-cyan-600"></i>
                Detail Semua Transaksi
            </h2>

            @if($transaksi->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-cyan-50 border-b border-cyan-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Warga</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Kategori</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Berat (kg)</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">CO₂e Berkurang</th>
                            <th class="px-4 py-3 text-center text-sm font-semibold text-gray-900">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $trans)
                            @if($trans->items->count() > 0)
                                @foreach($trans->items as $item)
                                <tr class="border-b border-gray-200 hover:bg-cyan-50/30">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $trans->tanggal_transaksi->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $trans->warga?->nama ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-block px-2 py-1 bg-cyan-100 text-cyan-800 text-xs font-semibold rounded">
                                            {{ $item->kategoriSampah?->nama_kategori ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-600">{{ number_format($item->berat_kg, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-right font-semibold text-emerald-600">{{ number_format($item->co2_tersimpan, 2) }} kg CO₂e</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        @if($trans->status_penjualan === 'sudah_terjual')
                                        <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded">
                                            <i class="fas fa-check-circle mr-1"></i>Terjual
                                        </span>
                                        @else
                                        <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">
                                            <i class="fas fa-hourglass-half mr-1"></i>Menunggu
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr class="border-b border-gray-200 hover:bg-cyan-50/30">
                                    <td class="px-4 py-3 text-sm text-gray-900">{{ $trans->tanggal_transaksi->format('d M Y') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600">{{ $trans->warga?->nama ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        <span class="inline-block px-2 py-1 bg-cyan-100 text-cyan-800 text-xs font-semibold rounded">
                                            {{ $trans->kategoriSampah?->nama_kategori ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right text-gray-600">{{ number_format($trans->berat_kg, 2) }}</td>
                                    <td class="px-4 py-3 text-sm text-right font-semibold text-emerald-600">{{ number_format($trans->co2_tersimpan, 2) }} kg CO₂e</td>
                                    <td class="px-4 py-3 text-sm text-center">
                                        @if($trans->status_penjualan === 'sudah_terjual')
                                        <span class="inline-block px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-semibold rounded">
                                            <i class="fas fa-check-circle mr-1"></i>Terjual
                                        </span>
                                        @else
                                        <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">
                                            <i class="fas fa-hourglass-half mr-1"></i>Menunggu
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada transaksi pada bulan ini</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterBulan() {
    const bulan = document.getElementById('bulan-filter').value;
    window.location.href = `{{ route('karang-taruna.laporan.dampak-lingkungan') }}?bulan=${bulan}`;
}
</script>
@endpush

@push('styles')
<style>
.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
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
</style>
@endpush

@endsection
