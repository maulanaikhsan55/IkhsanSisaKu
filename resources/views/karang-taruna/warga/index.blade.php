@extends('karang-taruna.layouts.app')

@section('title', 'Kelola Warga - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

<!-- Header Section -->
<div class="mb-8 animate-fade-in-up">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl font-black text-gray-900">Kelola Warga</h1>
            <p class="text-gray-600 mt-2">Kelola daftar warga yang terdaftar di Karang Taruna Anda</p>
        </div>
        <a href="{{ route('karang-taruna.warga.create') }}" class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl hover:from-green-600 hover:to-emerald-700 transform hover:-translate-y-1 transition-all duration-300 inline-flex items-center gap-2 whitespace-nowrap">
            <i class="fas fa-plus"></i> Tambah Warga
        </a>
    </div>
</div>

<!-- Stats Overview Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 animate-fade-in-up" style="animation-delay: 0.05s;">
    <!-- Total Warga Card -->
    <div class="group relative">
        <div class="absolute inset-0 bg-gradient-to-r from-green-200 via-emerald-200 to-green-100 rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white rounded-3xl p-8 shadow-md hover:shadow-xl card-hover border border-gray-200/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-black text-green-600 uppercase tracking-widest mb-2">Total Warga Terdaftar</p>
                    <h3 class="text-4xl font-black text-gray-900">{{ count($warga) }}</h3>
                    <p class="text-xs text-gray-500 mt-2">orang</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Warga Aktif Card -->
    <div class="group relative">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-200 via-green-200 to-emerald-100 rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-300"></div>
        <div class="relative bg-white rounded-3xl p-8 shadow-md hover:shadow-xl card-hover border border-gray-200/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-black text-emerald-600 uppercase tracking-widest mb-2">Warga Aktif</p>
                    <h3 class="text-4xl font-black text-gray-900">{{ count($warga) }}</h3>
                    <p class="text-xs text-gray-500 mt-2">Terdata</p>
                </div>
                <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-green-100 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user-check text-emerald-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="bg-green-50 border-l-4 border-green-600 rounded-lg p-4 mb-8">
    <div class="flex gap-3">
        <i class="fas fa-info-circle text-green-600 text-lg mt-0.5 flex-shrink-0"></i>
        <div>
            <h3 class="text-sm font-semibold text-green-900">Catatan tentang Data Warga</h3>
            <p class="text-sm text-green-800 mt-1">
                Data warga yang ditampilkan adalah warga yang telah terdaftar di Karang Taruna Anda. 
                Setiap warga dapat melakukan transaksi penjualan sampah. 
                Anda dapat menambah warga baru, melihat detail, atau mengedit informasi warga yang sudah terdaftar.
            </p>
        </div>
    </div>
</div>

<!-- Warga List -->
<div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden" style="animation-delay: 0.1s;">
    <!-- Filter Section -->
    <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3 md:gap-4">
            <!-- Search Nama -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Cari Warga</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                    <input
                        type="text"
                        id="search-input"
                        placeholder="Cari nama..."
                        class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                    >
                </div>
            </div>

            <!-- Search Alamat -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Cari Alamat</label>
                <div class="relative">
                    <i class="fas fa-map-marker-alt absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                    <input
                        type="text"
                        id="search-address"
                        placeholder="Cari alamat..."
                        class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                    >
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-1.5 sm:gap-2">
                <button type="button" onclick="resetWargaFilters()" class="flex-1 px-3 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm">
                    <i class="fas fa-redo"></i>
                    <span class="hidden sm:inline">Segarkan</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Table Header -->
    <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200">
        <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Daftar Warga</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gradient-to-r from-green-50 to-emerald-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Nama</th>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Alamat</th>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Telepon</th>
                    <th class="px-6 py-4 text-center text-sm font-black text-gray-900">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($warga as $w)
                <tr class="hover:bg-green-50/30 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ $w->nama }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($w->alamat, 30) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $w->no_telepon ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('karang-taruna.warga.show', $w) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 transition-colors" title="Lihat">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                            <a href="{{ route('karang-taruna.warga.edit', $w) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-yellow-100 text-yellow-600 hover:bg-yellow-200 transition-colors" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <form method="POST" action="{{ route('karang-taruna.warga.destroy', $w) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-red-100 text-red-600 hover:bg-red-200 transition-colors" title="Hapus">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 font-medium">Belum ada warga terdaftar</p>
                            <p class="text-sm text-gray-400 mt-1">Mulai dengan menambahkan warga baru</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($warga->hasPages())
<div class="mt-8 flex justify-center">
    {{ $warga->links() }}
</div>
@endif

</div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const searchAddress = document.getElementById('search-address');
    const rows = document.querySelectorAll('tbody tr');

    function filterWarga() {
        const searchName = searchInput.value.toLowerCase();
        const searchAdd = searchAddress.value.toLowerCase();

        rows.forEach(row => {
            if (row.textContent.includes('Belum ada warga')) return;

            const nama = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const alamat = row.querySelector('td:nth-child(2)').textContent.toLowerCase();

            const matchesName = nama.includes(searchName);
            const matchesAddress = alamat.includes(searchAdd);

            if (matchesName && matchesAddress) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterWarga);
    searchAddress.addEventListener('input', filterWarga);
});

function resetWargaFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('search-address').value = '';
    const searchInput = document.getElementById('search-input');
    const event = new Event('input', { bubbles: true });
    searchInput.dispatchEvent(event);
}
</script>
@endpush

@push('styles')
<style>
    .card-hover {
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .card-hover:hover {
        transform: translateY(-8px) scale(1.01);
    }
</style>
@endpush
