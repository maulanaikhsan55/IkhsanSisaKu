@extends('karang-taruna.layouts.app')

@section('title', 'Kelola Warga - SisaKu')

@section('content')

<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">

    <!-- Header Section -->
    <div class="mb-6 sm:mb-8 animate-fade-in-up">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div class="flex-1 min-w-0">
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 sm:mb-2 leading-tight">Kelola Warga</h1>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Kelola daftar warga yang terdaftar di Karang Taruna</p>
            </div>
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3 w-full sm:w-auto">
                <a href="{{ route('karang-taruna.warga.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm whitespace-nowrap min-h-[48px]">
                    <i class="fas fa-plus mr-2"></i>
                    <span class="hidden sm:inline">Tambah Warga</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
                <a href="#" onclick="exportWargaPdf()" class="w-full sm:w-auto inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm whitespace-nowrap min-h-[48px]">
                    <i class="fas fa-file-pdf mr-2"></i>
                    <span class="hidden sm:inline">Export PDF</span>
                    <span class="sm:hidden">PDF</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Stats Overview Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6 md:mb-8">
        <!-- Total Warga Card -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in">
            <div class="flex justify-between items-start">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Warga Terdaftar</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $warga->total() }}</h3>
                    <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Orang</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-green-600 text-base sm:text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Warga Aktif Card -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
            <div class="flex justify-between items-start">
                <div class="min-w-0">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Warga Aktif</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $warga->count() }}</h3>
                    <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Terdata</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-check text-green-600 text-base sm:text-lg md:text-xl"></i>
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
                <h3 class="text-sm font-semibold text-green-900 mb-1">Tentang Data Warga</h3>
                <p class="text-xs sm:text-sm text-green-800 leading-relaxed">
                    Data warga yang terdaftar di Karang Taruna Anda. Setiap warga dapat melakukan transaksi penjualan sampah. Anda dapat menambah, melihat detail, atau mengedit informasi warga yang sudah terdaftar.
                </p>
            </div>
        </div>
    </div>

    <!-- Warga List -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden">
        <!-- Filter Section -->
        <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-3 md:gap-4">
                <!-- Search -->
                <div class="sm:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Cari Warga</label>
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Cari nama..."
                            class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm min-h-[44px]"
                        >
                    </div>
                </div>

                <!-- Filter Alamat -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <div class="relative">
                        <i class="fas fa-map-marker-alt absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                        <input
                            type="text"
                            id="addressInput"
                            placeholder="Cari alamat..."
                            class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm min-h-[44px]"
                        >
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-1.5 sm:gap-2">
                    <button type="button" id="resetBtn" class="flex-1 px-3 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base min-h-[44px]">
                        <i class="fas fa-redo"></i>
                        <span class="hidden sm:inline">Reset</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="p-3 sm:p-4 md:p-6">
            <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-3">
                <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Daftar Warga</h3>
                <span class="text-xs sm:text-sm text-gray-500"><span id="resultCount">{{ count($warga) }}</span> warga terdaftar</span>
            </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b-2 border-gray-200 bg-gray-50">
                                <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Nama</th>
                                <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Alamat</th>
                                <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Telepon</th>
                                <th class="text-center py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="wargaTableBody">
                            @forelse($warga as $w)
                            <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200">
                                <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm font-medium text-gray-800 truncate">{{ $w->nama }}</td>
                                <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm text-gray-700 whitespace-nowrap">{{ $w->alamat }}</td>
                                <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm text-gray-700 whitespace-nowrap">{{ $w->no_telepon ?? '-' }}</td>
                                <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-center">
                                    <div class="flex items-center justify-center gap-1 sm:gap-2">
                                        <a href="{{ route('karang-taruna.warga.show', $w) }}" class="p-1.5 sm:p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-xs sm:text-sm" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('karang-taruna.warga.edit', $w) }}" class="p-1.5 sm:p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-xs sm:text-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="{{ route('karang-taruna.warga.destroy', $w) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 sm:p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors text-xs sm:text-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-3 sm:px-4 md:px-6 py-12 text-center">
                                    <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                                    <p class="text-gray-500 font-medium text-sm">Belum ada warga terdaftar</p>
                                    <p class="text-xs text-gray-400 mt-1">Mulai dengan menambahkan warga baru</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        </div>

        <!-- Pagination -->
        @if($warga->hasPages())
        <div class="mt-8 flex justify-center">
            {{ $warga->links('pagination.custom') }}
        </div>
        @endif

<script>
    const searchInput = document.getElementById('searchInput');
    const addressInput = document.getElementById('addressInput');
    const resetBtn = document.getElementById('resetBtn');
    const wargaTableBody = document.getElementById('wargaTableBody');
    const resultCount = document.getElementById('resultCount');
    const rows = wargaTableBody.querySelectorAll('tr');

    function filterWarga() {
        const searchTerm = searchInput.value.toLowerCase();
        const addressTerm = addressInput.value.toLowerCase();
        let visibleCount = 0;

        rows.forEach(row => {
            // Skip the empty state row
            if (row.querySelector('td[colspan="4"]')) {
                return;
            }

            const nama = row.cells[0]?.textContent.toLowerCase() || '';
            const alamat = row.cells[1]?.textContent.toLowerCase() || '';

            const matchesSearch = !searchTerm || nama.includes(searchTerm);
            const matchesAddress = !addressTerm || alamat.includes(addressTerm);

            if (matchesSearch && matchesAddress) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        resultCount.textContent = visibleCount;
    }

    searchInput.addEventListener('input', filterWarga);
    addressInput.addEventListener('input', filterWarga);

    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        addressInput.value = '';
        filterWarga();
    });

    function exportWargaPdf() {
        const search = searchInput.value;
        const address = addressInput.value;

        // Build URL with current filter values
        let url = '{{ route("karang-taruna.warga.export-pdf") }}?';
        const params = new URLSearchParams();

        if (search) params.append('search', search);
        if (address) params.append('address', address);

        url += params.toString();

        // Open in new tab/window to download
        window.open(url, '_blank');
    }
</script>

@endsection
