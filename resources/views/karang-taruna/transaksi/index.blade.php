@extends('karang-taruna.layouts.app')

@section('title', 'Kelola Transaksi Sampah - SisaKu')

@section('content')

<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">

        <!-- Header -->
        <div class="mb-8 md:mb-12 animate-page-load">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 leading-tight">Kelola Transaksi Sampah</h1>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Pantau dan kelola semua transaksi sampah dari warga</p>
                </div>
                <div class="w-full sm:w-auto flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="{{ route('karang-taruna.transaksi.showBulkPayment') }}"
                       class="inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm whitespace-nowrap min-h-[48px]">
                        <i class="fas fa-money-check mr-2"></i>
                        <span class="hidden sm:inline">Catat Penjualan Massal</span>
                        <span class="sm:hidden">Penjualan Massal</span>
                    </a>
                    <a href="{{ route('karang-taruna.transaksi.create') }}"
                       class="inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm whitespace-nowrap min-h-[48px]">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Transaksi
                    </a>
                </div>
            </div>
        </div>

<!-- Stats Cards -->
<div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-4 md:gap-6 mb-4 sm:mb-6 md:mb-8">
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-2 sm:p-4 md:p-6 shadow-modern border-modern card-hover scroll-reveal">
        <div class="flex justify-between items-start gap-2">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Transaksi</p>
                <h3 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ ($statisticsDicatat->total_count ?? 0) + ($statisticsDisetor->total_count ?? 0) }}</h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Semua status</p>
            </div>
            <div class="w-8 h-8 sm:w-11 md:w-12 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-receipt text-green-600 text-sm sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-2 sm:p-4 md:p-6 shadow-modern border-modern card-hover scroll-reveal" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-start gap-2">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Belum Disetor</p>
                <h3 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp{{ number_format($statisticsDicatat->total_nilai ?? 0, 0) }}</h3>
                <p class="text-xs text-yellow-600 mt-1 sm:mt-2 font-medium">{{ ($statisticsDicatat->total_count ?? 0) }} transaksi</p>
            </div>
            <div class="w-8 h-8 sm:w-11 md:w-12 sm:h-11 md:h-12 bg-gradient-to-br from-yellow-100 to-yellow-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-hourglass-half text-yellow-600 text-sm sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-2 sm:p-4 md:p-6 shadow-modern border-modern card-hover scroll-reveal" style="animation-delay: 0.2s;">
        <div class="flex justify-between items-start gap-2">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Sudah Disetor</p>
                <h3 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">Rp{{ number_format($statisticsDisetor->total_nilai ?? 0, 0) }}</h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">{{ ($statisticsDisetor->total_count ?? 0) }} transaksi</p>
            </div>
            <div class="w-8 h-8 sm:w-11 md:w-12 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-check-circle text-green-600 text-sm sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-2 sm:p-4 md:p-6 shadow-modern border-modern card-hover scroll-reveal" style="animation-delay: 0.3s;">
        <div class="flex justify-between items-start gap-2">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Berat</p>
                <h3 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ number_format(($statisticsDicatat->total_berat ?? 0) + ($statisticsDisetor->total_berat ?? 0), 2) }}<span class="text-xs text-green-600"> kg</span></h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Semua transaksi</p>
            </div>
            <div class="w-8 h-8 sm:w-11 md:w-12 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-weight text-green-600 text-sm sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Info Box -->
<div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-lg sm:rounded-xl md:rounded-2xl p-4 sm:p-5 md:p-6 mb-6 sm:mb-8 animate-page-load">
    <div class="flex gap-3 sm:gap-4">
        <div class="flex-shrink-0">
            <i class="fas fa-info-circle text-green-600 text-lg sm:text-xl mt-0.5"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h3 class="text-sm font-semibold text-green-900 mb-1">Catatan tentang Status Transaksi</h3>
            <p class="text-xs sm:text-sm text-green-800 leading-relaxed">
                <strong>Belum Disetor:</strong> Sampah telah dikumpulkan dari warga namun belum diserahkan/dijual.
                <br><strong>Sudah Disetor:</strong> Sampah telah diserahkan/dijual dan transaksi penjualan sudah dicatat.
                <br>Setelah status berubah menjadi "Sudah Disetor", transaksi terkunci dan tidak dapat diedit.
            </p>
        </div>
    </div>
</div>

        <!-- Transactions Table -->
        <div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern animate-page-load overflow-hidden">
<!-- Filter Section -->
<div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <!-- Search -->
        <div class="sm:col-span-2">
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Cari Transaksi</label>
            <div class="relative">
                <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm sm:text-base"></i>
                <input
                    type="text"
                    id="search-input"
                    placeholder="Cari nama warga..."
                    class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm min-h-[44px]"
                >
            </div>
        </div>

        <!-- Filter Status -->
        <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Status Transaksi</label>
            <select id="status-filter" class="w-full px-3 sm:px-4 py-3 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm min-h-[44px]">
                <option value="">Semua Status</option>
                <option value="belum_terjual">Belum Disetor</option>
                <option value="sudah_terjual">Sudah Disetor</option>
            </select>
        </div>

        <!-- Buttons -->
        <div class="flex items-end gap-2 sm:gap-3">
            <button type="button" id="resetFiltersBtn" class="flex-1 px-3 sm:px-6 py-3 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-2 text-sm min-h-[44px]">
                <i class="fas fa-redo"></i>
                <span class="hidden sm:inline">Reset</span>
            </button>
        </div>
    </div>
</div>

<!-- Table Header -->
<div class="p-3 sm:p-4 md:p-6">
    <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 mb-4">Daftar Transaksi</h3>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b-2 border-gray-200 bg-gray-50">
                    <th class="text-left py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">ID</th>
                    <th class="text-left py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Tanggal</th>
                    <th class="text-left py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Warga</th>
                    <th class="text-left py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Total Berat</th>
                    <th class="text-right py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Total Harga</th>
                    <th class="text-left py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Status</th>
                    <th class="text-center py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Item</th>
                    <th class="text-center py-2 sm:py-3 md:py-4 px-2 sm:px-3 md:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody id="transactions-table-body">
                @forelse($transaksi as $transaction)
                <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200 transaction-row" data-status="{{ $transaction->status_penjualan }}">
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-xs sm:text-sm font-semibold">
                        <span class="inline-flex px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs">
                            #{{ $transaction->id }}
                        </span>
                    </td>
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-xs sm:text-sm text-gray-900 whitespace-nowrap">
                        {{ $transaction->tanggal_transaksi->format('d/m/Y') }}
                    </td>
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-xs sm:text-sm font-medium text-gray-900">
                        {{ $transaction->warga?->nama ?? 'N/A' }}
                    </td>
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-xs sm:text-sm font-semibold text-gray-900">
                        {{ number_format((float)$transaction->getTotalBeratAttribute(), 2) }} kg
                    </td>
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-right text-xs sm:text-sm font-bold text-green-600">
                        Rp {{ number_format((float)$transaction->total_harga_from_items, 0) }}
                    </td>
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-xs sm:text-sm">
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $transaction->status_penjualan == 'sudah_terjual' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $transaction->status_penjualan == 'sudah_terjual' ? 'Sudah Disetor' : 'Belum Disetor' }}
                        </span>
                    </td>
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-center">
                        <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-green-100 text-green-700 rounded-full">
                            {{ $transaction->items->count() }}
                        </span>
                    </td>
                    <td class="py-3 sm:py-4 px-2 sm:px-3 md:px-6 text-center">
                        <div class="flex items-center justify-center gap-1 sm:gap-2">
                            @if($transaction->status_penjualan === 'belum_terjual')
                            <button onclick="openPaymentModal({{ $transaction->id }}, '{{ $transaction->warga?->nama ?? 'N/A' }}', {{ $transaction->getTotalHargaFromItemsAttribute() }})"
                                    class="p-2 sm:p-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors min-h-[32px] min-w-[32px] flex items-center justify-center" title="Catat Penjualan">
                                <i class="fas fa-check-circle text-sm"></i>
                            </button>
                            <a href="{{ route('karang-taruna.transaksi.edit', $transaction) }}"
                               class="p-2 sm:p-2 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg transition-colors min-h-[32px] min-w-[32px] flex items-center justify-center" title="Edit">
                                <i class="fas fa-edit text-sm"></i>
                            </a>
                            <button onclick="deleteTransaksi({{ $transaction->id }}, '{{ $transaction->warga?->nama ?? 'N/A' }}')"
                                    class="p-2 sm:p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors min-h-[32px] min-w-[32px] flex items-center justify-center" title="Hapus">
                                <i class="fas fa-trash text-sm"></i>
                            </button>
                            @else
                            <span class="p-2 sm:p-2 text-gray-400 cursor-not-allowed min-h-[32px] min-w-[32px] flex items-center justify-center" title="Terkunci">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            @endif
                            <a href="{{ route('karang-taruna.transaksi.show', $transaction) }}"
                               class="p-2 sm:p-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors min-h-[32px] min-w-[32px] flex items-center justify-center" title="Lihat Detail">
                                <i class="fas fa-eye text-sm"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-3 sm:px-4 md:px-6 py-12 text-center">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium text-sm">Belum ada transaksi</p>
                        <p class="text-xs text-gray-400 mt-1">Mulai catat transaksi sampah dari warga</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if($transaksi->hasPages())
<div class="mt-8 flex justify-center">
    {{ $transaksi->links('pagination.custom') }}
</div>
@endif

</div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden pointer-events-none z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-lg sm:rounded-2xl p-4 sm:p-6 w-full max-w-sm transform transition-all duration-300 scale-95 opacity-0 pointer-events-auto" id="deleteModalContent">
        <div class="text-center">
            <div class="w-12 sm:w-16 h-12 sm:h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                <i class="fas fa-exclamation-triangle text-red-600 text-lg sm:text-2xl"></i>
            </div>
            <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-800 mb-2">Hapus Transaksi</h3>
            <p class="text-xs sm:text-sm text-gray-600 mb-4 sm:mb-6" id="deleteMessage">Apakah Anda yakin ingin menghapus transaksi ini?</p>

            <div class="flex gap-2 sm:gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 px-3 sm:px-4 py-2 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg sm:rounded-xl font-medium transition-all duration-200 text-sm sm:text-base">
                    Batal
                </button>
                <button onclick="confirmDelete()" class="flex-1 px-3 sm:px-4 py-2 sm:py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg sm:rounded-xl font-medium transition-all duration-200 text-sm sm:text-base">
                    <i class="fas fa-trash mr-1 sm:mr-2"></i><span class="hidden sm:inline">Hapus</span><span class="sm:hidden">Ya</span>
                </button>
            </div>
        </div>
    </div>
</div>

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

.transaction-row {
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.transaction-row:hover {
    background-color: rgba(59, 130, 246, 0.05);
    transform: translateX(4px);
}
</style>
@endpush

@push('scripts')
<script>
let deleteTransaksiId = null;

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
        deleteTransaksiId = null;
    }, 300);
}

function deleteTransaksi(id, wargaNama) {
    deleteTransaksiId = id;
    document.getElementById('deleteMessage').textContent = `Apakah Anda yakin ingin menghapus transaksi dari "${wargaNama}"?`;
    openDeleteModal();
}

function confirmDelete() {
    if (deleteTransaksiId) {
        const deleteBtn = event.target;
        deleteBtn.disabled = true;
        deleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Menghapus...';

        fetch(`/karang-taruna/transaksi/${deleteTransaksiId}`, {
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
                showNotification(data.message || 'Transaksi berhasil dihapus', 'success');
                setTimeout(() => location.reload(), 1500);
            } else {
                closeDeleteModal();
                showNotification(data.message || 'Terjadi kesalahan saat menghapus transaksi', 'error');
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = '<i class="fas fa-trash mr-1 sm:mr-2"></i><span class="hidden sm:inline">Hapus</span><span class="sm:hidden">Ya</span>';
            }
        })
        .catch(error => {
            closeDeleteModal();
            showNotification('Terjadi kesalahan saat menghapus transaksi', 'error');
            deleteBtn.disabled = false;
            deleteBtn.innerHTML = '<i class="fas fa-trash mr-1 sm:mr-2"></i><span class="hidden sm:inline">Hapus</span><span class="sm:hidden">Ya</span>';
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const resetFiltersBtn = document.getElementById('resetFiltersBtn');
    const tableBody = document.getElementById('transactions-table-body');
    const rows = tableBody.querySelectorAll('.transaction-row');
    const closePaymentModalBtn = document.getElementById('closePaymentModalBtn');
    const cancelPaymentBtn = document.getElementById('cancelPaymentBtn');
    const submitPaymentBtn = document.getElementById('submitPaymentBtn');

    function filterTransactions() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const status = row.getAttribute('data-status');

            const matchesSearch = text.includes(searchTerm);
            const matchesStatus = statusValue === '' || status === statusValue;

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTransactions);
    statusFilter.addEventListener('change', filterTransactions);
    resetFiltersBtn.addEventListener('click', resetFilters);
    closePaymentModalBtn.addEventListener('click', closePaymentModal);
    cancelPaymentBtn.addEventListener('click', closePaymentModal);
    submitPaymentBtn.addEventListener('click', processQuickPayment);
});

function openPaymentModal(transaksiId, wargaNama, totalHarga) {
    document.getElementById('paymentModal').classList.remove('hidden');
    document.getElementById('paymentTransaksiId').value = transaksiId;
    document.getElementById('paymentWargaNama').textContent = wargaNama;
    document.getElementById('paymentAmount').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalHarga);
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}

function processQuickPayment() {
    const transaksiId = document.getElementById('paymentTransaksiId').value;
    const submitBtn = document.getElementById('submitPaymentBtn');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mencatat...';

    fetch(`/karang-taruna/transaksi/${transaksiId}/quick-payment`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closePaymentModal();
            showNotification(data.message || 'Penjualan berhasil dicatat', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification('Error: ' + data.message, 'error');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Sudah Terbayar';
        }
    })
    .catch(error => {
        showNotification('Terjadi kesalahan. Silakan coba lagi.', 'error');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Sudah Terbayar';
    });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closePaymentModal();
    }
});

function resetFilters() {
    document.getElementById('search-input').value = '';
    document.getElementById('status-filter').value = '';
    const searchInput = document.getElementById('search-input');
    const event = new Event('input', { bubbles: true });
    searchInput.dispatchEvent(event);
}
</script>
@endpush

<!-- Quick Contribution Modal -->
<div id="paymentModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-scale-in">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-900">Catat Penjualan Sampah</h3>
            <button type="button" id="closePaymentModalBtn" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <div class="space-y-4 mb-6">
            <div class="p-4 bg-green-50 rounded-xl border border-green-200">
                <p class="text-sm text-gray-600 mb-1">Nama Warga</p>
                <p id="paymentWargaNama" class="text-lg font-bold text-gray-900"></p>
            </div>

            <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                <p class="text-sm text-gray-600 mb-1">Nilai Sampah untuk Desa</p>
                <p id="paymentAmount" class="text-2xl font-bold text-green-600"></p>
            </div>

            <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-200">
                <p class="text-xs text-yellow-800">
                    <i class="fas fa-info-circle mr-2"></i>
                    Nilai ini merupakan penerimaan sampah yang telah disetor ke bank sampah
                </p>
            </div>
        </div>

        <input type="hidden" id="paymentTransaksiId" value="">

        <div class="flex gap-3">
            <button type="button" id="cancelPaymentBtn" class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                Batal
            </button>
            <button type="button" id="submitPaymentBtn" class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-check mr-2"></i>Sudah Terbayar
            </button>
        </div>
    </div>
</div>

@endsection
