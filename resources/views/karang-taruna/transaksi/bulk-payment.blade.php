@extends('karang-taruna.layouts.app')

@section('title', 'Catat Penjualan Massal - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center gap-4">
                <a href="{{ route('karang-taruna.transaksi.index') }}"
                   class="p-3 hover:bg-white/50 rounded-xl transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Catat Penjualan Massal</h1>
                    <p class="text-gray-600 mt-1">Catat penjualan sampah untuk beberapa transaksi sekaligus</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 animate-scale-in">
            
            <form action="{{ route('karang-taruna.transaksi.bulkProcessPayment') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Filter Section -->
                <div class="border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">1. Tentukan Rentang Tanggal</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tanggal_dari" class="block text-sm font-semibold text-gray-700 mb-2">
                                Dari Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_dari" id="tanggal_dari"
                                   value="{{ old('tanggal_dari', now()->subMonth()->toDateString()) }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                   required>
                            @error('tanggal_dari')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="tanggal_sampai" class="block text-sm font-semibold text-gray-700 mb-2">
                                Sampai Tanggal <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_sampai" id="tanggal_sampai"
                                   value="{{ old('tanggal_sampai', now()->toDateString()) }}"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                   required>
                            @error('tanggal_sampai')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="button" id="filter-btn" class="mt-4 px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-medium rounded-lg transition-colors">
                        <i class="fas fa-filter mr-2"></i>Tampilkan Transaksi
                    </button>
                </div>

                <!-- Transaksi List Section -->
                <div id="transaksi-section" class="hidden border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">2. Pilih Transaksi yang akan Diproses</h3>
                    
                    <div id="transaksi-list" class="space-y-2 max-h-96 overflow-y-auto border border-gray-200 rounded-xl p-4">
                        <p class="text-gray-500 text-sm">Memuat data transaksi...</p>
                    </div>

                    <div class="mt-4 flex items-center gap-4">
                        <input type="checkbox" id="select-all" class="w-4 h-4 text-blue-600 rounded">
                        <label for="select-all" class="text-sm font-medium text-gray-700">
                            Pilih Semua Transaksi
                        </label>
                    </div>
                </div>

                <!-- Sales Info Section -->
                <div id="pembayaran-section" class="hidden border-b border-gray-200 pb-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">3. Informasi Penjualan</h3>
                    <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <p class="text-sm text-blue-800 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>
                            Penjualan akan dicatat menggunakan total harga masing-masing transaksi secara otomatis untuk desa.
                        </p>
                        <input type="hidden" name="harga_pembayaran" id="harga_pembayaran" value="0">
                    </div>
                </div>

                <!-- Summary Section -->
                <div id="summary-section" class="hidden p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                    <h4 class="font-semibold text-gray-900 mb-3">Ringkasan Pencatatan</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Transaksi:</span>
                            <span id="summary-count" class="font-semibold text-blue-600">0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Penjualan:</span>
                            <span id="summary-total" class="font-semibold text-blue-600">Rp 0</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.transaksi.index') }}"
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit" id="submit-btn" disabled
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
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
    const pembayaranSection = document.getElementById('pembayaran-section');
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

        try {
            const response = await fetch(`/karang-taruna/transaksi/filter?dari=${dari}&sampai=${sampai}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            });

            const data = await response.json();

            if (data.success && data.transaksi.length > 0) {
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
                pembayaranSection.classList.add('hidden');
                summarySection.classList.add('hidden');
                submitBtn.disabled = true;
                selectAllCheckbox.checked = false;
            } else {
                transaksiList.innerHTML = '<p class="text-gray-500 text-sm">Tidak ada transaksi yang belum terjual pada rentang tanggal ini</p>';
                transaksiSection.classList.remove('hidden');
                pembayaranSection.classList.add('hidden');
                summarySection.classList.add('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat data transaksi');
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
            pembayaranSection.classList.remove('hidden');
            summarySection.classList.remove('hidden');

            document.getElementById('summary-count').textContent = count;
            document.getElementById('summary-total').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            
            hargaInput.value = total > 0 ? total : 0;
            submitBtn.disabled = count === 0 || total <= 0;
        } else {
            pembayaranSection.classList.add('hidden');
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
