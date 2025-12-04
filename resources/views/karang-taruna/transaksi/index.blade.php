@extends('karang-taruna.layouts.app')

@section('title', 'Kelola Transaksi Sampah - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kelola Transaksi Sampah</h1>
                    <p class="text-gray-600 mt-1">Pantau dan kelola semua transaksi sampah dari warga</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('karang-taruna.transaksi.showBulkPayment') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-money-check mr-2"></i>
                        Catat Penjualan Massal
                    </a>
                    <a href="{{ route('karang-taruna.transaksi.create') }}"
                       class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Transaksi
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl border border-white/30 p-6 hover:shadow-3xl hover:scale-105 transition-all duration-500 ease-out animate-fade-in-up-delay-0">
                <div class="flex items-center">
                    <div class="p-4 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl shadow-lg">
                        <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Total Item Sampah</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ $statistics->total_count }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl border border-white/30 p-6 hover:shadow-3xl hover:scale-105 transition-all duration-500 ease-out animate-fade-in-up-delay-1">
                <div class="flex items-center">
                    <div class="p-4 bg-gradient-to-br from-green-100 to-green-200 rounded-2xl shadow-lg">
                        <i class="fas fa-weight-hanging text-green-600 text-2xl"></i>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Total Berat</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($statistics->total_berat, 2) }} kg</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl border border-white/30 p-6 hover:shadow-3xl hover:scale-105 transition-all duration-500 ease-out animate-fade-in-up-delay-2">
                <div class="flex items-center">
                    <div class="p-4 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl shadow-lg">
                        <i class="fas fa-money-bill-wave text-purple-600 text-2xl"></i>
                    </div>
                    <div class="ml-5">
                        <p class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Total Nilai</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1">Rp {{ number_format($statistics->total_nilai, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="bg-yellow-50 border-l-4 border-yellow-600 rounded-lg p-4 mb-8">
            <div class="flex gap-3">
                <i class="fas fa-info-circle text-yellow-600 text-lg mt-0.5 flex-shrink-0"></i>
                <div>
                    <h3 class="text-sm font-semibold text-yellow-900">Catatan tentang Status Transaksi</h3>
                    <p class="text-sm text-yellow-800 mt-1">
                        <strong>Belum Disetor:</strong> Sampah telah dikumpulkan dari warga namun belum diserahkan/dijual.
                        <br><strong>Sudah Disetor:</strong> Sampah telah diserahkan/dijual dan transaksi penjualan sudah dicatat.
                        <br>Setelah status berubah menjadi "Sudah Disetor", transaksi terkunci dan tidak dapat diedit.
                    </p>
                </div>
            </div>
        </div>

        <!-- Transactions Table -->
        <div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden">
            <!-- Filter Section -->
            <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3 md:gap-4">
                    <!-- Search -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Cari Transaksi</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-400 text-xs sm:text-sm"></i>
                            <input
                                type="text"
                                id="search-input"
                                placeholder="Cari nama warga..."
                                class="w-full pl-9 sm:pl-12 pr-3 sm:pr-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm"
                            >
                        </div>
                    </div>

                    <!-- Filter Status -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Status Transaksi</label>
                        <select id="status-filter" class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl text-gray-900 outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition-colors text-sm">
                            <option value="">Semua Status</option>
                            <option value="belum_terjual">Belum Disetor</option>
                            <option value="sudah_terjual">Sudah Disetor</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-end gap-1.5 sm:gap-2">
                        <button type="button" onclick="resetFilters()" class="flex-1 px-3 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm">
                            <i class="fas fa-redo"></i>
                            <span class="hidden sm:inline">Segarkan</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table Header -->
            <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200">
                <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Daftar Transaksi</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Warga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Berat</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="transactions-table-body">
                        @forelse($transaksi as $transaction)
                        <tr class="hover:bg-gray-50/50 transition-colors transaction-row" data-status="{{ $transaction->status_penjualan }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2.5 py-1 text-xs font-semibold bg-indigo-100 text-indigo-800 rounded-full">
                                    #{{ $transaction->id }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->tanggal_transaksi->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $transaction->warga?->nama ?? 'N/A' }}</div>
                                @if($transaction->warga)
                                <p class="text-xs text-gray-500">{{ $transaction->warga->nomor_identitas }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ number_format($transaction->getTotalBeratAttribute(), 2) }} kg
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                                Rp {{ number_format($transaction->getTotalHargaFromItemsAttribute(), 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                    {{ $transaction->status_penjualan == 'sudah_terjual' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $transaction->status_penjualan == 'sudah_terjual' ? 'Sudah Disetor' : 'Belum Disetor' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-blue-100 text-blue-800 rounded-full">
                                    {{ $transaction->items->count() }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @if($transaction->status_penjualan === 'belum_terjual')
                                    <button onclick="openPaymentModal({{ $transaction->id }}, '{{ $transaction->warga?->nama ?? 'N/A' }}', {{ $transaction->getTotalHargaFromItemsAttribute() }})"
                                            class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Sudah Terbayar">
                                        <i class="fas fa-check-circle"></i>
                                    </button>
                                    <a href="{{ route('karang-taruna.transaksi.edit', $transaction) }}"
                                       class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('karang-taruna.transaksi.destroy', $transaction) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="p-2 text-gray-400 cursor-not-allowed" title="Terkunci">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    @endif
                                    <a href="{{ route('karang-taruna.transaksi.show', $transaction) }}"
                                       class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada transaksi</h3>
                                    <p class="text-gray-500 mb-4">Mulai catat transaksi sampah dari warga</p>
                                    <a href="{{ route('karang-taruna.transaksi.create') }}"
                                       class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Transaksi Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transaksi->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50/50">
                {{ $transaksi->links() }}
            </div>
            @endif
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
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const statusFilter = document.getElementById('status-filter');
    const tableBody = document.getElementById('transactions-table-body');
    const rows = tableBody.querySelectorAll('.transaction-row');

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
            location.reload();
        } else {
            alert('Error: ' + data.message);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Sudah Terbayar';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
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
            <button onclick="closePaymentModal()" class="text-gray-500 hover:text-gray-700">
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
            <button onclick="closePaymentModal()" class="flex-1 px-4 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                Batal
            </button>
            <button id="submitPaymentBtn" onclick="processQuickPayment()" class="flex-1 px-4 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class="fas fa-check mr-2"></i>Sudah Terbayar
            </button>
        </div>
    </div>
</div>

@endsection
