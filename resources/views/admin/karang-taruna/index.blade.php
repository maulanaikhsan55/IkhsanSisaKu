@extends('admin.layouts.app')

@section('title', 'Kelola Karang Taruna - SisaKu')

@push('styles')
<style>
    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-10px);
        }
    }
</style>
@endpush

@section('content')

<div class="w-full min-h-screen px-2 sm:px-3 md:px-4 lg:px-6 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-6 sm:mb-8 animate-fade-in-up">
    <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
        <div class="min-w-0 flex-1">
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 sm:mb-2 leading-tight">Kelola Karang Taruna</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">Manajemen data Karang Taruna di seluruh RW</p>
        </div>

    </div>
</div>

<!-- Alert Messages -->
@if(session('success'))
<div class="bg-green-50 border-l-4 border-green-500 p-3 sm:p-4 mb-6 rounded-lg sm:rounded-xl animate-scale-in alert-auto-hide text-sm">
    <div class="flex items-center gap-2">
        <i class="fas fa-check-circle text-green-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
        <p class="text-green-800 font-medium">{{ session('success') }}</p>
    </div>
</div>

@if(session('show_password') && session('password_info'))
<div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 sm:p-6 mb-6 rounded-lg sm:rounded-xl animate-scale-in" id="passwordAlert">
    <div class="flex items-start gap-3 sm:gap-4">
        <i class="fas fa-key text-emerald-600 text-lg sm:text-xl mt-1 flex-shrink-0"></i>
        <div class="flex-1 min-w-0">
            <h3 class="text-sm sm:text-base font-bold text-emerald-900 mb-3">Akun Baru Telah Dibuat - Bagikan Kredensial Ini ke Karang Taruna</h3>
            <div class="space-y-2 bg-white p-3 sm:p-4 rounded-lg border border-emerald-200 mb-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <p class="text-xs font-semibold text-emerald-700 mb-1">Nama Karang Taruna</p>
                        <p class="text-sm font-mono bg-emerald-50 p-2 rounded text-gray-900">{{ session('password_info.nama_karang_taruna') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-emerald-700 mb-1">Username</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-mono bg-emerald-50 p-2 rounded text-gray-900 flex-1 truncate">{{ session('password_info.username') }}</p>
                            <button type="button" onclick="copyToClipboard('{{ session('password_info.username') }}')" class="p-2 text-emerald-600 hover:bg-emerald-100 rounded transition" title="Salin">
                                <i class="fas fa-copy text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-emerald-700 mb-1">Email</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-mono bg-emerald-50 p-2 rounded text-gray-900 flex-1 truncate">{{ session('password_info.email') }}</p>
                            <button type="button" onclick="copyToClipboard('{{ session('password_info.email') }}')" class="p-2 text-emerald-600 hover:bg-emerald-100 rounded transition" title="Salin">
                                <i class="fas fa-copy text-sm"></i>
                            </button>
                        </div>
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-emerald-700 mb-1">Password Sementara</p>
                        <div class="flex items-center gap-2">
                            <p class="text-sm font-mono bg-red-50 p-2 rounded text-gray-900 flex-1 break-all transition-all" id="passwordField" style="filter: blur(5px);">{{ session('password_info.password') }}</p>
                            <button type="button" onclick="copyToClipboard('{{ session('password_info.password') }}')" class="p-2 text-emerald-600 hover:bg-emerald-100 rounded transition" title="Salin">
                                <i class="fas fa-copy text-sm"></i>
                            </button>
                            <button type="button" onclick="togglePasswordVisibility()" class="p-2 text-emerald-600 hover:bg-emerald-100 rounded transition" title="Tampil/Sembunyikan">
                                <i class="fas fa-eye text-sm" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-yellow-50 border border-yellow-200 p-3 rounded-lg mb-3">
                <p class="text-xs sm:text-sm text-yellow-800"><strong>⚠️ Penting:</strong> Bagikan informasi ini langsung ke Karang Taruna. Password tidak akan ditampilkan lagi. Setelah login, mereka harus mengubah password ke yang lebih aman.</p>
            </div>
            <button type="button" onclick="closePasswordAlert()" class="px-3 sm:px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs sm:text-sm rounded-lg transition">
                Tutup Notifikasi
            </button>
        </div>
    </div>
</div>
@endif
@endif

@if(session('error'))
<div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 mb-6 rounded-lg sm:rounded-xl animate-scale-in alert-auto-hide text-sm">
    <div class="flex items-center gap-2">
        <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
        <p class="text-red-800 font-medium">{{ session('error') }}</p>
    </div>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in">
        <div class="flex justify-between items-start gap-3">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-2">Total Karang Taruna</p>
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">{{ $totalKarangTaruna }}</h3>
                <p class="text-xs text-green-600 mt-2 font-medium">Unit</p>
            </div>
            <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-building text-green-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.05s;">
        <div class="flex justify-between items-start gap-3">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-2">Sedang Beroperasi</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ $totalAktif }}">{{ $totalAktif }}</h3>
                <p class="text-xs text-green-600 mt-2 font-medium">Aktif</p>
            </div>
            <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-green-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-start gap-3">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-2">Tidak Aktif</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ $totalNonaktif }}">{{ $totalNonaktif }}</h3>
                <p class="text-xs text-red-600 mt-2 font-medium">Nonaktif</p>
            </div>
            <div class="w-10 h-10 sm:w-11 sm:h-11 md:w-12 md:h-12 bg-gradient-to-br from-red-100 to-red-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-times-circle text-red-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Karang Taruna Table with Filter -->
<div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden mb-6 sm:mb-8">
    <!-- Filter Section -->
    <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
        <form method="GET" action="{{ route('admin.karang-taruna.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4">

            <!-- Search -->
            <div class="sm:col-span-2">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Cari Karang Taruna</label>
                <div class="relative">
                    <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama..."
                        class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                    >
                </div>
            </div>

            <!-- Filter Status -->
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Status</label>
                <select name="status" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-end gap-2 sm:gap-3">
                <button type="submit" class="flex-1 px-3 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm min-h-[44px]">
                    <i class="fas fa-filter"></i>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <a href="{{ route('admin.karang-taruna.index') }}" class="px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-br from-gray-50 to-white hover:from-gray-100 hover:to-gray-50 text-gray-700 rounded-lg sm:rounded-xl font-medium transition-all border border-gray-200 hover:border-gray-300 shadow-soft text-sm min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="p-3 sm:p-4 md:p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-4 mb-4 sm:mb-6">
            <h3 class="text-sm sm:text-base md:text-lg font-bold text-gray-900">Daftar Karang Taruna</h3>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.karang-taruna.export-pdf', request()->query()) }}" class="w-full sm:w-auto px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg sm:rounded-xl text-xs sm:text-sm font-semibold transition-all flex items-center justify-center gap-2 shadow-soft min-h-[44px]">
                    <i class="fas fa-file-pdf"></i> <span class="hidden sm:inline">Export PDF</span><span class="sm:hidden">PDF</span>
                </a>
                <a href="{{ route('admin.karang-taruna.create') }}" class="w-full sm:w-auto px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-xl font-semibold transition-all flex items-center justify-center gap-2 shadow-modern text-xs sm:text-sm min-h-[44px]">
                    <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Karang Taruna</span><span class="sm:hidden">Tambah</span>
                </a>
            </div>
        </div>

    <div class="overflow-x-auto -mx-3 sm:-mx-4 md:mx-0 px-3 sm:px-4 md:px-0">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">RW</th>
                    <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Nama Unit</th>
                    <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Pengelola</th>
                    <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">No. Telf</th>
                    <th class="text-center px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Warga</th>
                    <th class="text-center px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Sampah</th>
                    <th class="text-center px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Status</th>
                    <th class="text-center px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody id="karangTarunaTableBody" class="divide-y divide-gray-100">
                @forelse($karangTarunas as $kt)
                <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200">
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                        <span class="inline-flex items-center px-2 sm:px-2.5 py-0.5 sm:py-1 rounded-lg text-xs font-semibold bg-green-100 text-green-700 whitespace-nowrap">
                            RW {{ $kt->rw }}
                        </span>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                        <p class="text-xs sm:text-sm font-semibold text-gray-900 truncate">{{ $kt->nama_karang_taruna }}</p>
                        <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $kt->user->username }}</p>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-700 truncate">{{ $kt->nama_lengkap ?: '-' }}</td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-700 whitespace-nowrap">{{ $kt->no_telp ?: '-' }}</td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-center text-xs sm:text-sm font-semibold text-gray-900">{{ $kt->total_warga }}</td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-center text-xs sm:text-sm font-semibold text-green-600 whitespace-nowrap">{{ number_format($kt->total_sampah, 0) }} kg</td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-center">
                        @if($kt->status == 'aktif')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <i class="fas fa-check-circle mr-1"></i> Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                                <i class="fas fa-times-circle mr-1"></i> Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                        <div class="flex items-center justify-center gap-1 sm:gap-2">
                            <a href="{{ route('admin.karang-taruna.show', $kt->id) }}" class="p-1.5 sm:p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-xs sm:text-sm" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.karang-taruna.edit', $kt->id) }}" class="p-1.5 sm:p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors text-xs sm:text-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button onclick="confirmDelete({{ $kt->id }})" class="p-1.5 sm:p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-xs sm:text-sm" title="Nonaktifkan">
                                <i class="fas fa-ban"></i>
                            </button>
                            <button onclick="confirmForceDelete({{ $kt->id }}, '{{ $kt->nama_karang_taruna }}')" class="p-1.5 sm:p-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors text-xs sm:text-sm" title="Hapus Permanen">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                            <p class="text-gray-500 font-medium">Belum ada data Karang Taruna</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

        @if($karangTarunas->hasPages())
        <div class="px-0 py-4 border-t border-gray-100 bg-gray-50">
            {{ $karangTarunas->links('pagination.custom') }}
        </div>
        @endif
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-all">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Nonaktifkan Karang Taruna?</h3>
            <p class="text-gray-600 mb-6">Karang Taruna akan dinonaktifkan dan tidak bisa login ke sistem.</p>
            <form id="deleteForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-semibold transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">
                    Ya, Nonaktifkan
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Force Delete Modal -->
<div id="forceDeleteModal" class="fixed inset-0 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 max-w-md w-full mx-4 shadow-2xl transform scale-95 transition-all">
        <div class="text-center">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Hapus Permanen?</h3>
            <p class="text-gray-600 mb-4" id="forceDeleteMessage"></p>
            <p class="text-red-600 text-sm font-medium mb-6">Tindakan ini tidak dapat dibatalkan!</p>
            <form id="forceDeleteForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeForceDeleteModal()" class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-xl font-semibold transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl font-semibold transition-all">
                    Ya, Hapus Permanen
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    form.action = `/admin/karang-taruna/${id}`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

function confirmForceDelete(id, name) {
    const modal = document.getElementById('forceDeleteModal');
    const form = document.getElementById('forceDeleteForm');
    const message = document.getElementById('forceDeleteMessage');
    message.textContent = `Karang Taruna "${name}" dan semua data terkait akan dihapus secara permanen.`;
    form.action = `/admin/karang-taruna/${id}/force-delete`;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeForceDeleteModal() {
    const modal = document.getElementById('forceDeleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
        closeForceDeleteModal();
    }
});

// Real-time search functionality
document.querySelector('input[name="search"]').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#karangTarunaTableBody tr');

    rows.forEach(row => {
        if (row.cells.length > 1) { // Skip empty state row
            const rw = row.cells[0].textContent.toLowerCase();
            const namaUnit = row.cells[1].textContent.toLowerCase();
            const namaLengkap = row.cells[2].textContent.toLowerCase();

            const matches = rw.includes(searchTerm) ||
                           namaUnit.includes(searchTerm) ||
                           namaLengkap.includes(searchTerm);

            row.style.display = matches ? '' : 'none';
        }
    });
});

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg text-sm z-50';
        notification.textContent = '✓ Berhasil disalin ke clipboard';
        document.body.appendChild(notification);
        setTimeout(() => notification.remove(), 2000);
    }).catch(() => {
        alert('Gagal menyalin ke clipboard');
    });
}

function togglePasswordVisibility() {
    const passwordField = document.getElementById('passwordField');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField.style.filter === 'blur(5px)') {
        passwordField.style.filter = 'none';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    } else {
        passwordField.style.filter = 'blur(5px)';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    }
}

function closePasswordAlert() {
    const alert = document.getElementById('passwordAlert');
    if (alert) {
        alert.style.animation = 'fadeOut 0.3s ease-out forwards';
        setTimeout(() => alert.remove(), 300);
    }
}

</script>
@endpush
