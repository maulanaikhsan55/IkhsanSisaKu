@extends('karang-taruna.layouts.app')

{{-- @var \Illuminate\Pagination\LengthAwarePaginator $arusKas --}}
{{-- @var \stdClass $statisticsMasuk --}}
{{-- @var \stdClass $statisticsKeluar --}}
{{-- @var \Illuminate\Support\Collection $kategoris --}}

@section('title', 'Arus Kas - SisaKu')

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
                        <h1 class="text-3xl font-bold text-gray-900">Arus Kas</h1>
                        <p class="text-gray-600 mt-1">Kelola semua transaksi kas masuk dan keluar</p>
                    </div>
                </div>
                <a href="{{ route('karang-taruna.arus-kas.create') }}"
                   class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all">
                    <i class="fas fa-plus mr-2"></i>Tambah Transaksi
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Kas Masuk</p>
                        <p class="text-3xl font-bold text-green-600 mt-2">Rp {{ number_format($statisticsMasuk->total_masuk ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-arrow-down text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Kas Keluar</p>
                        <p class="text-3xl font-bold text-red-600 mt-2">Rp {{ number_format($statisticsKeluar->total_keluar ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-arrow-up text-red-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Saldo Bersih</p>
                        @php
                            $saldo = ($statisticsMasuk->total_masuk ?? 0) - ($statisticsKeluar->total_keluar ?? 0);
                            $saldoClass = $saldo >= 0 ? 'text-green-600' : 'text-red-600';
                        @endphp
                        <p class="text-3xl font-bold {{ $saldoClass }} mt-2">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fas fa-wallet text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Total Transaksi</p>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">{{ ($statisticsMasuk->total_count ?? 0) + ($statisticsKeluar->total_count ?? 0) }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-receipt text-indigo-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-blue-50 border-l-4 border-blue-600 rounded-lg p-4 mb-8">
            <div class="flex gap-3">
                <i class="fas fa-info-circle text-blue-600 text-lg mt-0.5 flex-shrink-0"></i>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900">Catatan tentang Tab Penyaringan</h3>
                    <p class="text-sm text-blue-800 mt-1">
                        Tab "Semua", "Masuk", dan "Keluar" hanya memfilter tampilan data dalam tabel. 
                        <strong>Statistik di atas (Kas Masuk, Kas Keluar, Saldo Bersih, Total Transaksi) selalu menampilkan semua data</strong> 
                        dan tidak terpengaruh oleh tab yang dipilih.
                    </p>
                </div>
            </div>
        </div>

        <!-- Filter & Tabs Card -->
        <div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden">
            <!-- Filter Section -->
            <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4 mb-4">
                    <!-- Search Deskripsi -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Cari Transaksi</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                            <input
                                type="text"
                                id="search-input-ak"
                                placeholder="Cari deskripsi..."
                                class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                            >
                        </div>
                    </div>

                    <!-- Filter Kategori -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Kategori</label>
                        <select id="kategori-filter" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm">
                            <option value="">Semua Kategori</option>
                            @if(is_array($kategoris) || $kategoris instanceof \Illuminate\Support\Collection)
                                @foreach($kategoris as $kat)
                                <option value="{{ $kat->id ?? '' }}">{{ $kat->nama_kategori ?? '' }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <!-- Filter Tanggal -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Dari Tanggal</label>
                        <input
                            type="date"
                            id="start-date"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm"
                        >
                    </div>

                    <!-- Filter Tanggal Akhir -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Hingga Tanggal</label>
                        <input
                            type="date"
                            id="end-date"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm"
                        >
                    </div>
                </div>

                <!-- Reset Button -->
                <div class="flex gap-2">
                    <button type="button" onclick="resetArusKasFilters()" class="px-4 py-2 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-2 text-xs sm:text-sm">
                        <i class="fas fa-redo"></i>
                        <span class="hidden sm:inline">Segarkan</span>
                    </button>
                </div>
            </div>

            <!-- Tabs -->
            <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-white flex gap-2 overflow-x-auto">
                <button onclick="showTab('semua')" class="px-4 sm:px-6 py-2 sm:py-3 bg-green-600 text-white font-medium rounded-lg sm:rounded-xl transition-all active-tab whitespace-nowrap text-xs sm:text-sm" id="tab-semua">
                    <i class="fas fa-list mr-2"></i>Semua
                </button>
                <button onclick="showTab('masuk')" class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-200 text-gray-700 font-medium rounded-lg sm:rounded-xl transition-all whitespace-nowrap text-xs sm:text-sm" id="tab-masuk">
                    <i class="fas fa-arrow-down mr-2"></i>Masuk
                </button>
                <button onclick="showTab('keluar')" class="px-4 sm:px-6 py-2 sm:py-3 bg-gray-200 text-gray-700 font-medium rounded-lg sm:rounded-xl transition-all whitespace-nowrap text-xs sm:text-sm" id="tab-keluar">
                    <i class="fas fa-arrow-up mr-2"></i>Keluar
                </button>
            </div>

            <!-- Table Card -->
            <div class="overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-100 to-indigo-100 border-b border-blue-200">
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Jenis</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Kategori</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Deskripsi</th>
                        <th class="px-6 py-4 text-right text-sm font-semibold text-gray-900">Jumlah</th>
                        <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @forelse($arusKas as $kas)
                    <tr class="hover:bg-blue-50/30 transition-colors border-b border-gray-200 kas-row" data-jenis="{{ $kas->jenis_transaksi }}">
                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                            {{ $kas->tanggal_transaksi->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($kas->jenis_transaksi === 'masuk')
                            <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                <i class="fas fa-arrow-down mr-1"></i>Masuk
                            </span>
                            @else
                            <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                <i class="fas fa-arrow-up mr-1"></i>Keluar
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                {{ $kas->kategoriKeuangan->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($kas->deskripsi ?? '-', 30) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-right font-semibold" data-jenis-type="{{ $kas->jenis_transaksi }}">
                            @if($kas->jenis_transaksi === 'masuk')
                            <span class="text-green-600">+ Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
                            @else
                            <span class="text-red-600">- Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('karang-taruna.arus-kas.edit', $kas) }}"
                                   class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors"
                                   title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('karang-taruna.arus-kas.destroy', $kas) }}" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition-colors"
                                            title="Hapus">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                                <p class="text-gray-500 font-medium">Belum ada transaksi kas</p>
                                <p class="text-sm text-gray-400 mt-1">Mulai dengan menambahkan transaksi baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($arusKas->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $arusKas->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function showTab(tabName) {
    const rows = document.querySelectorAll('.kas-row');
    const tabs = document.querySelectorAll('[id^="tab-"]');
    
    tabs.forEach(tab => {
        tab.classList.remove('bg-green-600', 'text-white');
        tab.classList.add('bg-gray-200', 'text-gray-700');
    });
    
    document.getElementById('tab-' + tabName).classList.remove('bg-gray-200', 'text-gray-700');
    document.getElementById('tab-' + tabName).classList.add('bg-green-600', 'text-white');
    
    rows.forEach(row => {
        if (tabName === 'semua') {
            row.style.display = '';
        } else {
            row.style.display = row.getAttribute('data-jenis') === tabName ? '' : 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input-ak');
    const kategoriFilter = document.getElementById('kategori-filter');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const rows = document.querySelectorAll('.kas-row');

    function filterArusKas() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedKategori = kategoriFilter.value;
        const startVal = startDate.value;
        const endVal = endDate.value;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const tanggal = row.querySelector('td:nth-child(1)').textContent.trim();
            
            const matchesSearch = text.includes(searchTerm);
            const matchesKategori = selectedKategori === '' || row.textContent.includes(selectedKategori);
            
            let matchesDate = true;
            if (startVal || endVal) {
                const rowDate = new Date(tanggal.split(' ')[0].split('/').reverse().join('-'));
                if (startVal) {
                    matchesDate = matchesDate && rowDate >= new Date(startVal);
                }
                if (endVal) {
                    matchesDate = matchesDate && rowDate <= new Date(endVal);
                }
            }

            if (matchesSearch && matchesKategori && matchesDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterArusKas);
    kategoriFilter.addEventListener('change', filterArusKas);
    startDate.addEventListener('change', filterArusKas);
    endDate.addEventListener('change', filterArusKas);
});

function resetArusKasFilters() {
    document.getElementById('search-input-ak').value = '';
    document.getElementById('kategori-filter').value = '';
    document.getElementById('start-date').value = '';
    document.getElementById('end-date').value = '';
    document.getElementById('search-input-ak').dispatchEvent(new Event('input', { bubbles: true }));
}
</script>
@endpush

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
