@extends('karang-taruna.layouts.app')

@section('title', 'Catat Penjualan Massal - SisaKu')

@section('content')
<div class="w-full px-4 md:px-6 lg:px-12">
    <div class="max-w-4xl mx-auto py-6">

        <!-- Header -->
        <div class="mb-6 animate-page-load">
            <div class="flex items-center gap-3 md:gap-4">
                <a href="{{ route('karang-taruna.transaksi.index') }}"
                   class="p-2 md:p-3 hover:bg-white/50 rounded-lg md:rounded-xl transition-colors flex-shrink-0">
                    <i class="fas fa-arrow-left text-gray-600 text-lg md:text-xl"></i>
                </a>
                <div class="min-w-0">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Catat Penjualan Massal</h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Catat penjualan sampah untuk beberapa transaksi sekaligus</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-6 md:p-8 animate-scale-in">
            <form action="{{ route('karang-taruna.transaksi.bulkProcessPayment') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Date Range Section -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                        <i class="fas fa-calendar mr-2 text-green-600"></i>
                        Rentang Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_dari" class="block text-xs font-medium text-gray-600 mb-2">
                                Dari Tanggal
                            </label>
                            <input type="date" name="tanggal_dari" id="tanggal_dari"
                                   value="{{ old('tanggal_dari', now()->subMonth()->toDateString()) }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   required>
                            @error('tanggal_dari')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_sampai" class="block text-xs font-medium text-gray-600 mb-2">
                                Sampai Tanggal
                            </label>
                            <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                                   value="{{ old('tanggal_sampai', now()->toDateString()) }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                                   required>
                            @error('tanggal_sampai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="button" id="filter-btn" class="mt-4 w-full md:w-auto px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-xl transition-colors">
                        <i class="fas fa-filter mr-2"></i>Tampilkan Transaksi
                    </button>
                </div>

                <!-- Transaksi List Section -->
                <div id="transaksi-section" class="hidden">
                    <label class="block text-sm font-semibold text-gray-700 mb-4">
                        <i class="fas fa-list mr-2 text-green-600"></i>
                        Pilih Transaksi yang akan Diproses
                    </label>

                    <div id="transaksi-list" class="border border-gray-200 rounded-xl p-4 max-h-80 overflow-y-auto">
                        <p class="text-gray-500 text-sm">Memuat data transaksi...</p>
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-green-600 rounded">
                        <label for="select-all" class="text-sm font-medium text-gray-700">
                            Pilih Semua Transaksi
                        </label>
                    </div>
                </div>

                <!-- Summary Card -->
                <div id="summary-section" class="hidden bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border border-green-200">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Jumlah Transaksi</p>
                            <p class="text-2xl font-bold text-gray-900"><span id="summary-count">0</span></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Penjualan</p>
                            <p class="text-2xl font-bold text-green-600">Rp <span id="summary-total">0</span></p>
                        </div>
                    </div>
                    <div class="mt-4 p-3 bg-green-100 border border-green-200 rounded-lg">
                        <p class="text-xs text-green-800">
                            <i class="fas fa-info-circle mr-2"></i>
                            Penjualan akan dicatat menggunakan total harga masing-masing transaksi secara otomatis untuk desa.
                        </p>
                        <input type="hidden" name="harga_pembayaran" id="harga_pembayaran" value="0">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.transaksi.index') }}"
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn" disabled
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-check-circle mr-2"></i>
                        Catat Penjualan Massal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterBtn = document.getElementById('filter-btn');
    const tanggalDari = document.getElementById('tanggal_dari');
    const tanggalSampai = document.getElementById('tanggal_sampai');
    const transaksiSection = document.getElementById('transaksi-section');
    const transaksiList = document.getElementById('transaksi-list');
    const selectAllCheckbox = document.getElementById('select-all');
    const summarySection = document.getElementById('summary-section');
    const submitBtn = document.getElementById('submit-btn');
    const hargaInput = document.getElementById('harga_pembayaran');
    let transaksiData = {};

    filterBtn.addEventListener('click', async function() {
        const dari = tanggalDari.value;
        const sampai = tanggalSampai.value;

        if (!dari || !sampai) {
            alert('Silakan pilih rentang tanggal terlebih dahulu');
            return;
        }

        // Show loading state
        filterBtn.disabled = true;
        filterBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memuat...';
        transaksiList.innerHTML = '<p class="text-gray-500 text-sm"><i class="fas fa-spinner fa-spin mr-2"></i>Memuat data transaksi...</p>';

        try {
            const response = await fetch(`{{ route('karang-taruna.transaksi.filter') }}?dari=${dari}&sampai=${sampai}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                if (data.transaksi && data.transaksi.length > 0) {
                    transaksiList.innerHTML = '';
                    transaksiData = {};

                    data.transaksi.forEach(transaksi => {
                        transaksiData[transaksi.id] = parseFloat(transaksi.total_harga);

                        const checkbox = document.createElement('label');
                        checkbox.className = 'flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer transition-colors';
                        checkbox.innerHTML = `
                            <input type="checkbox" name="transaksi_ids[]" value="${transaksi.id}" class="transaksi-checkbox w-4 h-4 text-blue-600 rounded">
                            <div class="flex-1">
                                <div class="font-semibold text-gray-900">${transaksi.warga_nama}</div>
                                <div class="text-xs text-gray-600">${transaksi.kategori_nama} • ${parseFloat(transaksi.berat_kg).toFixed(2)} kg • Rp ${parseInt(transaksi.total_harga).toLocaleString('id-ID')}</div>
                            </div>
                        `;
                        transaksiList.appendChild(checkbox);
                    });

                    transaksiSection.classList.remove('hidden');
                    summarySection.classList.add('hidden');
                    submitBtn.disabled = true;
                    selectAllCheckbox.checked = false;
                } else {
                    transaksiList.innerHTML = '<p class="text-gray-500 text-sm"><i class="fas fa-info-circle mr-2"></i>Tidak ada transaksi yang belum terjual pada rentang tanggal ini</p>';
                    transaksiSection.classList.remove('hidden');
                    pembayaranSection.classList.add('hidden');
                    summarySection.classList.add('hidden');
                }
            } else {
                // Handle API error response
                const errorMessage = data.message || 'Terjadi kesalahan saat memuat data transaksi';
                transaksiList.innerHTML = `<p class="text-red-500 text-sm"><i class="fas fa-exclamation-triangle mr-2"></i>${errorMessage}</p>`;
                transaksiSection.classList.remove('hidden');
                summarySection.classList.add('hidden');
                alert(errorMessage);
            }
        } catch (error) {
            transaksiList.innerHTML = '<p class="text-red-500 text-sm"><i class="fas fa-exclamation-triangle mr-2"></i>Terjadi kesalahan saat memuat data transaksi. Silakan coba lagi.</p>';
            transaksiSection.classList.remove('hidden');
            pembayaranSection.classList.add('hidden');
            summarySection.classList.add('hidden');
            alert('Terjadi kesalahan saat memuat data transaksi. Silakan periksa koneksi internet dan coba lagi.');
        } finally {
            // Reset button state
            filterBtn.disabled = false;
            filterBtn.innerHTML = '<i class="fas fa-filter mr-2"></i>Tampilkan Transaksi';
        }
    });

    selectAllCheckbox.addEventListener('change', function() {
        document.querySelectorAll('.transaksi-checkbox').forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateSummary();
    });

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('transaksi-checkbox')) {
            updateSummary();
        }
    });

    function updateSummary() {
        const checkedBoxes = document.querySelectorAll('.transaksi-checkbox:checked');
        const count = checkedBoxes.length;
        let total = 0;

        checkedBoxes.forEach(checkbox => {
            const transaksiId = parseInt(checkbox.value);
            total += transaksiData[transaksiId] || 0;
        });

        if (count > 0) {
            summarySection.classList.remove('hidden');

            document.getElementById('summary-count').textContent = count;
            document.getElementById('summary-total').textContent = `Rp ${total.toLocaleString('id-ID')}`;

            hargaInput.value = total > 0 ? total : 0;
            submitBtn.disabled = count === 0 || total <= 0;
        } else {
            summarySection.classList.add('hidden');
            submitBtn.disabled = true;
        }
    }
});
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
