@extends('karang-taruna.layouts.app')

@section('title', 'Laporan Arus Kas - SisaKu')

@section('content')
<div class="w-full px-4 md:px-6 lg:px-12">
    <!-- Header -->
    <div class="mb-8 md:mb-12 animate-fade-in-up">
        <div class="flex items-center gap-3 mb-8">
            <div class="flex-1">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1 text-gray-900">
                    Laporan Arus Kas
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Kelola dan pantau aliran kas</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Masuk</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp{{ number_format($summary['total_masuk'] ?? 0, 0) }}</h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Total pemasukan</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-arrow-up text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Keluar</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp{{ number_format($summary['total_keluar'] ?? 0, 0) }}</h3>
                        <p class="text-xs text-red-600 mt-1 sm:mt-2 font-medium">Total pengeluaran</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-red-100 to-red-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-arrow-down text-red-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.2s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Saldo Bersih</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp{{ number_format(abs($summary['saldo'] ?? 0), 0) }}</h3>
                        <p class="text-xs {{ ($summary['saldo'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }} mt-1 sm:mt-2 font-medium">{{ ($summary['saldo'] ?? 0) >= 0 ? '✓ Positif' : '✗ Defisit' }}</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-pie text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.3s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Transaksi</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ is_array($paginatedTransactions) ? count($paginatedTransactions) : $paginatedTransactions->total() }}</h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Jumlah transaksi</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exchange-alt text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg sm:rounded-xl md:rounded-2xl p-4 sm:p-5 md:p-6 mb-6 sm:mb-8 animate-fade-in-up">
            <div class="flex gap-3 sm:gap-4">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-green-600 text-lg sm:text-xl mt-0.5"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-green-900 mb-1">Catatan tentang Laporan Arus Kas</h3>
                    <p class="text-xs sm:text-sm text-green-800 leading-relaxed">
                        Laporan ini menampilkan ringkasan arus kas berdasarkan filter tanggal yang dipilih. <strong>Saldo Bersih</strong> menunjukkan hasil dari Kas Masuk dikurangi Kas Keluar. Jika <strong>positif (hijau)</strong>, Karang Taruna memiliki sisa kas. Jika <strong>negatif (merah)</strong>, ada kekurangan kas yang perlu diperhatikan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Line Chart: Daily Trend -->
            <div class="lg:col-span-2 glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern p-6 sm:p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex items-start gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line text-blue-600 text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900">Trend Harian</h2>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium mt-1">Pergerakan kas masuk dan keluar per hari</p>
                    </div>
                </div>
                <div style="position: relative; height: 300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Pie Chart: Proportion -->
            <div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern p-6 sm:p-8 animate-fade-in-up" style="animation-delay: 0.25s;">
                <div class="flex items-start gap-3 mb-6">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-pie-chart text-purple-600 text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900">Proporsi</h2>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium mt-1">Perbandingan masuk & keluar</p>
                    </div>
                </div>
                <div style="position: relative; height: 300px;">
                    <canvas id="proportionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden" style="animation-delay: 0.15s;">
        <!-- Filter Section -->
<div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-7 gap-2 sm:gap-3 md:gap-4">
        <!-- Search -->
        <div class="sm:col-span-2">
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Cari Transaksi</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                <input
                    type="text"
                    id="search-input-ak-report"
                    placeholder="Cari deskripsi..."
                    class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                >
            </div>
        </div>

        <!-- Filter Kategori -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select id="kategori-filter-report" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm bg-white">
                <option value="">Semua Kategori</option>
                @if(is_array($kategoris) || $kategoris instanceof \Illuminate\Support\Collection)
                    @foreach($kategoris as $kat)
                    <option value="{{ $kat->nama_kategori ?? '' }}">{{ $kat->nama_kategori ?? '' }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <!-- Filter Jenis -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Filter Jenis</label>
            <select id="jenis-filter-report" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm bg-white">
                <option value="semua">Semua</option>
                <option value="masuk">Masuk</option>
                <option value="keluar">Keluar</option>
            </select>
        </div>

        <!-- Filter Tanggal Mulai -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
            <input
                type="date"
                id="start-date-report"
                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm"
            >
        </div>

        <!-- Filter Tanggal Akhir -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
            <input
                type="date"
                id="end-date-report"
                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm"
            >
        </div>

        <!-- Reset Button -->
        <div class="flex items-end">
            <button type="button" onclick="resetArusKasReportFilters()" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm">
                <i class="fas fa-redo"></i>
                <span class="hidden sm:inline">Reset</span>
            </button>
        </div>
    </div>
</div>

        <!-- Table Header with Buttons -->
        <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-table text-green-600 text-lg"></i>
                    </div>
                    <div>
                        <h2 class="text-lg md:text-xl font-bold text-gray-900">Daftar Transaksi</h2>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium mt-1">Riwayat lengkap kas masuk dan keluar</p>
                    </div>
                </div>
                <a href="#" onclick="exportArusKasPdf()" class="w-full sm:w-auto px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg text-xs sm:text-sm font-semibold transition-all flex items-center justify-center gap-2 shadow-soft">
                    <i class="fas fa-file-pdf"></i> <span class="hidden sm:inline">Export PDF</span><span class="sm:hidden">PDF</span>
                </a>
            </div>

                        @if(is_array($paginatedTransactions) ? count($paginatedTransactions) > 0 : $paginatedTransactions->count() > 0)
        <!-- Table Header -->
        <div class="p-3 sm:p-4 md:p-6">
            <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 mb-4">Daftar Transaksi Kas</h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Tanggal</th>
                            <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Jenis</th>
                            <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Kategori</th>
                            <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Deskripsi</th>
                            <th class="text-right py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paginatedTransactions as $kas)
                        <tr class="kas-row border-b border-gray-200" data-jenis="{{ $kas->jenis }}">
                            <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
                                {{ $kas->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($kas->jenis === 'masuk')
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
                                <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                    {{ $kas->kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                {{ $kas->deskripsi ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-right font-semibold" data-jenis-type="{{ $kas->jenis }}">
                                @if($kas->jenis === 'masuk')
                                <span class="text-green-600">+ Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
                                @else
                                <span class="text-red-600">- Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="mt-8 flex justify-center">
            @if($paginatedTransactions->hasPages())
                {{ $paginatedTransactions->links('pagination.custom') }}
            @endif
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <i class="fas fa-inbox text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-600 font-medium">Tidak ada data transaksi</p>
            <p class="text-sm text-gray-500 mt-1">Silakan tambah data atau coba filter lain</p>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input-ak-report');
    const kategoriFilter = document.getElementById('kategori-filter-report');
    const jenisFilter = document.getElementById('jenis-filter-report');
    const startDate = document.getElementById('start-date-report');
    const endDate = document.getElementById('end-date-report');
    const tableBody = document.querySelector('tbody');
    const paginationContainer = document.getElementById('pagination-container');

    let filterTimeout;

    function filterArusKasReport() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(() => {
            const search = searchInput.value;
            const kategori = kategoriFilter.value;
            const jenis = jenisFilter.value;
            const start = startDate.value;
            const end = endDate.value;

            // Show loading state
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-spinner fa-spin text-2xl text-green-600 mb-4"></i>
                            <p class="text-gray-500 font-medium">Memuat data...</p>
                        </div>
                    </td>
                </tr>
            `;

            // Make AJAX request
            fetch(window.location.pathname + '?' + new URLSearchParams({
                search: search,
                kategori: kategori,
                start_date: start,
                end_date: end,
                jenis: jenis
            }), {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = data.html;
                paginationContainer.innerHTML = data.has_pages ? data.pagination : '';
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-2xl text-red-600 mb-4"></i>
                                <p class="text-gray-500 font-medium">Terjadi kesalahan saat memuat data</p>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }, 300);
    }

    // Event listeners for filters
    searchInput.addEventListener('input', filterArusKasReport);
    kategoriFilter.addEventListener('change', filterArusKasReport);
    jenisFilter.addEventListener('change', filterArusKasReport);
    startDate.addEventListener('change', filterArusKasReport);
    endDate.addEventListener('change', filterArusKasReport);

    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('.pagination a')) {
            e.preventDefault();
            const link = e.target.closest('.pagination a');
            const url = new URL(link.href);

            // Get current filter values
            const search = searchInput.value;
            const kategori = kategoriFilter.value;
            const jenis = jenisFilter.value;
            const start = startDate.value;
            const end = endDate.value;

            // Add filter parameters to URL
            if (search) url.searchParams.set('search', search);
            if (kategori) url.searchParams.set('kategori', kategori);
            if (start) url.searchParams.set('start_date', start);
            if (end) url.searchParams.set('end_date', end);
            if (jenis !== 'semua') url.searchParams.set('jenis', jenis);

            // Show loading state
            tableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-spinner fa-spin text-2xl text-green-600 mb-4"></i>
                            <p class="text-gray-500 font-medium">Memuat data...</p>
                        </div>
                    </td>
                </tr>
            `;

            // Make AJAX request
            fetch(url.pathname + url.search, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                tableBody.innerHTML = data.html;
                paginationContainer.innerHTML = data.has_pages ? data.pagination : '';
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-exclamation-triangle text-2xl text-red-600 mb-4"></i>
                                <p class="text-gray-500 font-medium">Terjadi kesalahan saat memuat data</p>
                            </div>
                        </td>
                    </tr>
                `;
            });
        }
    });
});

function resetArusKasReportFilters() {
    document.getElementById('search-input-ak-report').value = '';
    document.getElementById('kategori-filter-report').value = '';
    document.getElementById('jenis-filter-report').value = 'semua';
    document.getElementById('start-date-report').value = '';
    document.getElementById('end-date-report').value = '';
    // Trigger filter update
    document.getElementById('search-input-ak-report').dispatchEvent(new Event('input', { bubbles: true }));
}

function exportArusKasPdf() {
    const search = document.getElementById('search-input-ak-report').value;
    const kategori = document.getElementById('kategori-filter-report').value;
    const jenis = document.getElementById('jenis-filter-report').value;
    const startDate = document.getElementById('start-date-report').value;
    const endDate = document.getElementById('end-date-report').value;

    // Build URL with current filter values
    let url = '{{ route("karang-taruna.laporan.arus-kas.export-pdf") }}?';
    const params = new URLSearchParams();

    if (search) params.append('search', search);
    if (kategori) params.append('kategori', kategori);
    if (jenis && jenis !== 'semua') params.append('jenis', jenis);
    if (startDate) params.append('start_date', startDate);
    if (endDate) params.append('end_date', endDate);

    url += params.toString();

    // Open in new tab/window to download
    window.open(url, '_blank');
}

document.addEventListener('DOMContentLoaded', function() {
    const trendData = @json($dailyTrendData);
    const totalMasuk = {{ $summary['total_masuk'] }};
    const totalKeluar = {{ $summary['total_keluar'] }};

    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: trendData.labels,
            datasets: [
                {
                    label: 'Kas Masuk',
                    data: trendData.masuk,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                },
                {
                    label: 'Kas Keluar',
                    data: trendData.keluar,
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.05)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#ef4444',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, weight: '600' }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 12 } }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    const proportionCtx = document.getElementById('proportionChart').getContext('2d');
    new Chart(proportionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Kas Masuk', 'Kas Keluar'],
            datasets: [
                {
                    data: [totalMasuk, totalKeluar],
                    backgroundColor: ['#10b981', '#ef4444'],
                    borderColor: '#fff',
                    borderWidth: 3
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, weight: '600' }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return label + ': Rp' + value.toLocaleString('id-ID') + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
});
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

.kas-row {
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.kas-row:hover {
    background-color: rgba(34, 197, 94, 0.1);
    transform: translateX(4px) scale(1.01);
    box-shadow: 0 4px 12px rgba(34, 197, 94, 0.15);
}
</style>
@endpush

@endsection
