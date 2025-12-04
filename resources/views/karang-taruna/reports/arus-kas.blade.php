@extends('karang-taruna.layouts.app')

@section('title', 'Laporan Arus Kas - SisaKu')

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
                        <h1 class="text-3xl font-bold text-gray-900">Laporan Arus Kas</h1>
                        <p class="text-gray-600 mt-1">{{ $summary['bulan_nama'] }} {{ $summary['tahun'] }}</p>
                    </div>
                </div>
                <div class="flex gap-2 flex-wrap">
                    <input type="month" id="bulan-filter" value="{{ $summary['bulan'] }}"
                           class="px-4 py-2 border border-gray-300 rounded-lg">
                    <button onclick="filterBulan()" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('karang-taruna.laporan.arus-kas.export-pdf', request()->query()) }}" class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                        <i class="fas fa-file-pdf"></i><span>Export PDF</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Kas Masuk</p>
                <p class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($summary['total_masuk'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Kas Keluar</p>
                <p class="text-2xl font-bold text-red-600 mt-2">Rp {{ number_format($summary['total_keluar'], 0, ',', '.') }}</p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Saldo Bersih</p>
                <p class="text-2xl font-bold {{ $summary['saldo'] >= 0 ? 'text-emerald-600' : 'text-red-600' }} mt-2">
                    Rp {{ number_format(abs($summary['saldo']), 0, ',', '.') }}
                </p>
            </div>
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <p class="text-gray-600 text-sm font-medium">Total Transaksi</p>
                <p class="text-2xl font-bold text-blue-600 mt-2">{{ count($kasmasuk) + count($kasKeluar) }}</p>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-purple-50 border-l-4 border-purple-600 rounded-lg p-4 mb-8">
            <div class="flex gap-3">
                <i class="fas fa-info-circle text-purple-600 text-lg mt-0.5 flex-shrink-0"></i>
                <div>
                    <h3 class="text-sm font-semibold text-purple-900">Catatan tentang Laporan Arus Kas</h3>
                    <p class="text-sm text-purple-800 mt-1">
                        <strong>Saldo Bersih</strong> adalah hasil dari Kas Masuk dikurangi Kas Keluar. 
                        Jika positif (hijau), Karang Taruna memiliki sisa kas. Jika negatif (merah), ada defisit.
                        <br><strong>Catatan:</strong> Laporan ini menampilkan data per bulan berdasarkan filter tanggal yang Anda pilih.
                    </p>
                </div>
            </div>
        </div>

        <!-- Kas Masuk Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 mb-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <i class="fas fa-arrow-up text-green-600 text-lg"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Kas Masuk</h2>
                <span class="ml-auto text-sm font-semibold text-green-600">Rp {{ number_format($summary['total_masuk'], 0, ',', '.') }}</span>
            </div>

            @if($kasmasuk->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-green-50 border-b border-green-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Kategori</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasmasuk as $kas)
                        <tr class="border-b border-gray-200 hover:bg-green-50/30">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $kas->tanggal_transaksi->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded">
                                    {{ $kas->kategoriKeuangan->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($kas->deskripsi ?? '-', 30) }}</td>
                            <td class="px-4 py-3 text-sm text-right font-semibold text-green-600">
                                Rp {{ number_format($kas->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada kas masuk pada bulan ini</p>
            @endif
        </div>

        <!-- Kas Keluar Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <i class="fas fa-arrow-down text-red-600 text-lg"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">Kas Keluar</h2>
                <span class="ml-auto text-sm font-semibold text-red-600">Rp {{ number_format($summary['total_keluar'], 0, ',', '.') }}</span>
            </div>

            @if($kasKeluar->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-red-50 border-b border-red-200">
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Kategori</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                            <th class="px-4 py-3 text-right text-sm font-semibold text-gray-900">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kasKeluar as $kas)
                        <tr class="border-b border-gray-200 hover:bg-red-50/30">
                            <td class="px-4 py-3 text-sm text-gray-900">{{ $kas->tanggal_transaksi->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-block px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded">
                                    {{ $kas->kategoriKeuangan->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ Str::limit($kas->deskripsi ?? '-', 30) }}</td>
                            <td class="px-4 py-3 text-sm text-right font-semibold text-red-600">
                                Rp {{ number_format($kas->jumlah, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-center py-8">Tidak ada kas keluar pada bulan ini</p>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function filterBulan() {
    const bulan = document.getElementById('bulan-filter').value;
    window.location.href = `{{ route('karang-taruna.laporan.arus-kas') }}?bulan=${bulan}`;
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
