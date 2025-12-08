 @extends('karang-taruna.layouts.app')

{{-- @var \Illuminate\Pagination\LengthAwarePaginator $arusKas --}}
{{-- @var \stdClass $statisticsMasuk --}}
{{-- @var \stdClass $statisticsKeluar --}}
{{-- @var \Illuminate\Support\Collection $kategoris --}}

@section('title', 'Arus Kas - SisaKu')

@section('content')

<div class="w-full">

<!-- Header -->
        <div class="mb-8 md:mb-12 animate-fade-in-up">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
                <div class="flex-1 min-w-0">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">Arus Kas</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium mt-1">Kelola semua transaksi kas masuk dan keluar</p>
                </div>
                <a href="{{ route('karang-taruna.arus-kas.create') }}"
                   class="w-full sm:w-auto inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm whitespace-nowrap min-h-[48px]">
                    <i class="fas fa-plus mr-2"></i>Tambah Transaksi
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8 md:mb-10">
            <!-- Kas Masuk Card -->
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Masuk</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($statisticsMasuk->total_masuk ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Total Pemasukan</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-arrow-down text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Kas Keluar Card -->
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Keluar</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($statisticsKeluar->total_keluar ?? 0, 0, ',', '.') }}</h3>
                        <p class="text-xs text-red-600 mt-1 sm:mt-2 font-medium">Total Pengeluaran</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-red-100 to-red-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-arrow-up text-red-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Saldo Bersih Card -->
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.2s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Saldo Bersih</p>
                        @php
                            $saldo = ($statisticsMasuk->total_masuk ?? 0) - ($statisticsKeluar->total_keluar ?? 0);
                        @endphp
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Sisa Kas</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-wallet text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi Card -->
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.3s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Transaksi</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ ($statisticsMasuk->total_count ?? 0) + ($statisticsKeluar->total_count ?? 0) }}</h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Transaksi</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-receipt text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg sm:rounded-xl md:rounded-2xl p-4 sm:p-5 md:p-6 mb-6 sm:mb-8 animate-fade-in-up flex items-start gap-3 sm:gap-4">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-green-600 text-lg sm:text-xl mt-0.5"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-sm font-semibold text-green-900 mb-1">Catatan tentang Filter</h3>
                <p class="text-xs sm:text-sm text-green-800 leading-relaxed">
                    Filter jenis transaksi (Semua, Masuk, Keluar) hanya memfilter tampilan data dalam tabel.
                    <strong>Statistik di atas (Kas Masuk, Kas Keluar, Saldo Bersih, Total Transaksi) selalu menampilkan semua data</strong>
                    dan tidak terpengaruh oleh filter yang dipilih.
                </p>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden mb-6 sm:mb-8">
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
                    id="search-input-ak"
                    placeholder="Cari deskripsi..."
                    class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                >
            </div>
        </div>

        <!-- Filter Kategori -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Kategori</label>
            <select id="kategori-filter" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm bg-white">
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
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Jenis</label>
            <select id="jenis-filter" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm bg-white">
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
                id="start-date"
                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm"
            >
        </div>

        <!-- Filter Tanggal Akhir -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Tanggal Akhir</label>
            <input
                type="date"
                id="end-date"
                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm"
            >
        </div>

        <!-- Reset Button -->
        <div class="flex items-end">
            <button type="button" onclick="resetArusKasFilters()" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm min-h-[44px]">
                <i class="fas fa-redo"></i>
                <span class="hidden sm:inline">Reset</span>
            </button>
        </div>
    </div>
</div>

<!-- Table Header -->
<div class="p-3 sm:p-4 md:p-6">
    <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900 mb-4 sm:mb-6">Daftar Transaksi Kas</h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Tanggal</th>
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Jenis</th>
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Kategori</th>
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Deskripsi</th>
                    <th class="text-right py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Jumlah</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
                <tbody id="table-body">
                    @include('karang-taruna.arus-kas.partials.table-rows')
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div id="pagination-container" class="mt-6 sm:mt-8 flex justify-center p-3 sm:p-4 md:p-6">
            @if($arusKas->hasPages())
                {{ $arusKas->links('pagination.custom') }}
            @endif
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden pointer-events-none z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-lg sm:rounded-2xl p-4 sm:p-6 w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0 pointer-events-auto" id="deleteModalContent">
        <div class="text-center">
            <div class="w-12 sm:w-16 h-12 sm:h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-lg sm:text-2xl"></i>
            </div>
            <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-2">Hapus Transaksi Kas</h3>
            <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-6" id="deleteMessage">Apakah Anda yakin ingin menghapus transaksi kas ini?</p>

            <div class="flex gap-2 sm:gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg sm:rounded-xl font-medium transition-all duration-200 text-xs sm:text-sm min-h-[44px] flex items-center justify-center">
                    Batal
                </button>
                <button onclick="confirmDelete()" class="flex-1 px-3 sm:px-4 py-2.5 sm:py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg sm:rounded-xl font-medium transition-all duration-200 text-xs sm:text-sm min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-trash mr-1 sm:mr-2"></i><span class="hidden sm:inline">Hapus</span><span class="sm:hidden">Ya</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let deleteArusKasId = null;

function openDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');

    modal.classList.remove('hidden');
    if (modal.classList.contains('pointer-events-none')) {
        modal.classList.remove('pointer-events-none');
    }

    setTimeout(() => {
        if (modalContent) {
            modalContent.classList.remove('scale-95', 'opacity-0');
            modalContent.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('deleteModalContent');

    if (modalContent) {
        modalContent.classList.add('scale-95', 'opacity-0');
        modalContent.classList.remove('scale-100', 'opacity-100');
    }

    setTimeout(() => {
        modal.classList.add('hidden');
        if (modal.classList.contains('pointer-events-none') === false) {
            modal.classList.add('pointer-events-none');
        }
        deleteArusKasId = null;
    }, 300);
}

function deleteArusKas(id, deskripsi) {
    deleteArusKasId = id;
    const message = deskripsi ? `Apakah Anda yakin ingin menghapus transaksi "${deskripsi}"?` : 'Apakah Anda yakin ingin menghapus transaksi kas ini?';
    document.getElementById('deleteMessage').textContent = message;
    openDeleteModal();
}

function confirmDelete() {
    if (deleteArusKasId) {
        const deleteBtn = event.target;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';

        fetch(`/karang-taruna/arus-kas/${deleteArusKasId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeDeleteModal();
                showNotification(data.message || 'Transaksi kas berhasil dihapus', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                closeDeleteModal();
                showNotification(data.message || 'Terjadi kesalahan saat menghapus transaksi kas', 'error');
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<i class="fas fa-trash mr-1 sm:mr-2"></i><span class="hidden sm:inline">Hapus</span><span class="sm:hidden">Ya</span>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            closeDeleteModal();
            showNotification('Terjadi kesalahan saat menghapus transaksi kas', 'error');
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="fas fa-trash mr-1 sm:mr-2"></i><span class="hidden sm:inline">Hapus</span><span class="sm:hidden">Ya</span>';
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-input-ak');
    const kategoriFilter = document.getElementById('kategori-filter');
    const jenisFilter = document.getElementById('jenis-filter');
    const startDate = document.getElementById('start-date');
    const endDate = document.getElementById('end-date');
    const tableBody = document.getElementById('table-body');
    const paginationContainer = document.getElementById('pagination-container');

    let filterTimeout;

    function filterArusKas() {
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
                    <td colspan="6" class="px-6 py-12 text-center">
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
                        <td colspan="6" class="px-6 py-12 text-center">
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
    searchInput.addEventListener('input', filterArusKas);
    kategoriFilter.addEventListener('change', filterArusKas);
    jenisFilter.addEventListener('change', filterArusKas);
    startDate.addEventListener('change', filterArusKas);
    endDate.addEventListener('change', filterArusKas);

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
                    <td colspan="6" class="px-6 py-12 text-center">
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
                        <td colspan="6" class="px-6 py-12 text-center">
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

function resetArusKasFilters() {
    document.getElementById('search-input-ak').value = '';
    document.getElementById('kategori-filter').value = '';
    document.getElementById('jenis-filter').value = 'semua';
    document.getElementById('start-date').value = '';
    document.getElementById('end-date').value = '';
    // Trigger filter update
    document.getElementById('search-input-ak').dispatchEvent(new Event('input', { bubbles: true }));
}


</script>
@endpush

@push('styles')
<style>
.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.animate-scale-in {
    animation: scaleIn 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.animate-fade-in-up-delay-0 {
    animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.1s both;
}

.animate-fade-in-up-delay-1 {
    animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.3s both;
}

.animate-fade-in-up-delay-2 {
    animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) 0.5s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.kas-row {
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.kas-row:hover {
    background-color: rgba(59, 130, 246, 0.05);
    transform: translateX(4px);
}
</style>
@endpush

@endsection
