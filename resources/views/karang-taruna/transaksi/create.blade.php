@extends('karang-taruna.layouts.app')

@section('title', 'Tambah Transaksi Sampah - SisaKu')

@section('content')
<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="mb-6 sm:mb-8 animate-page-load">
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('karang-taruna.transaksi.index') }}"
                   class="p-2.5 sm:p-3 hover:bg-white/50 rounded-lg sm:rounded-xl transition-colors flex-shrink-0 min-h-[48px] min-w-[48px] flex items-center justify-center">
                    <i class="fas fa-arrow-left text-gray-600 text-lg sm:text-xl"></i>
                </a>
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">Tambah Transaksi Baru</h1>
                    <p class="text-gray-600 mt-1 text-xs sm:text-sm">Catat sampah dari warga dengan multiple items</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl sm:rounded-3xl shadow-xl border border-white/20 p-4 sm:p-6 md:p-8 scroll-reveal">
            <form id="transaksiForm" action="{{ route('karang-taruna.transaksi.store') }}" method="POST" class="space-y-6 sm:space-y-8">
                @csrf

                <!-- Warga Selection -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2.5 sm:mb-3">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Pilih Warga <span class="text-red-500">*</span>
                    </label>
                    @if($warga->count() > 0)
                    <select name="warga_id" id="warga_id"
                            class="w-full px-3 sm:px-4 py-3 sm:py-4 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white text-sm sm:text-base min-h-[48px]"
                            required>
                        <option value="">-- Pilih Warga --</option>
                        @foreach($warga as $w)
                        <option value="{{ $w->id }}">{{ $w->nama }}</option>
                        @endforeach
                    </select>
                    @else
                    <div class="w-full px-3 sm:px-4 py-3 sm:py-4 border border-red-300 bg-red-50 rounded-lg sm:rounded-xl text-red-700 text-xs sm:text-sm">
                        <p><i class="fas fa-exclamation-circle mr-2"></i>Belum ada data warga. <a href="{{ route('karang-taruna.warga.create') }}" class="font-semibold hover:underline">Tambah warga terlebih dahulu</a></p>
                    </div>
                    @endif
                    @error('warga_id')
                        <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2.5 sm:mb-3">
                        <i class="fas fa-calendar mr-2 text-green-600"></i>
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                           class="w-full px-3 sm:px-4 py-3 sm:py-4 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base min-h-[48px]"
                           value="{{ date('Y-m-d') }}" required>
                    @error('tanggal_transaksi')
                        <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Items Section -->
                <div>
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 mb-4">
                        <label class="block text-xs sm:text-sm font-semibold text-gray-700">
                            <i class="fas fa-box mr-2 text-green-600"></i>
                            Item Sampah <span class="text-red-500">*</span>
                        </label>
                        <button type="button" id="addItemBtn"
                                class="w-full sm:w-auto px-4 py-3 sm:py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs sm:text-sm font-medium rounded-lg sm:rounded-xl transition-colors min-h-[48px] sm:min-h-[44px] flex items-center justify-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span class="hidden sm:inline">Tambah Item</span>
                            <span class="sm:hidden">Tambah Item</span>
                        </button>
                    </div>

                    <!-- Items Table - Desktop View -->
                    <div class="hidden sm:block border border-gray-200 rounded-lg sm:rounded-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gray-100 border-b border-gray-200">
                                    <tr>
                                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700">Kategori</th>
                                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700">Berat (kg)</th>
                                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700">Harga/kg</th>
                                        <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-700">Total</th>
                                        <th class="px-3 sm:px-4 py-3 text-center text-xs font-semibold text-gray-700">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="itemsTableBody" class="divide-y divide-gray-200">
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Items Cards - Mobile View -->
                    <div id="itemsCardBody" class="sm:hidden space-y-3 mb-4">
                    </div>

                    <div id="itemsError" class="mt-3 text-xs sm:text-sm text-red-600 hidden flex items-center gap-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>Minimal tambahkan 1 item sampah</span>
                    </div>

                    @error('items')
                        <p class="mt-3 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Summary Card -->
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-green-200">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                        <div class="text-center sm:text-left">
                            <p class="text-xs sm:text-sm text-gray-600 mb-2">Total Berat</p>
                            <p class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900"><span id="totalBerat">0</span> <span class="text-xs sm:text-sm">kg</span></p>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="text-xs sm:text-sm text-gray-600 mb-2">Total Harga</p>
                            <p class="text-xl sm:text-2xl md:text-3xl font-bold text-green-600">Rp <span id="totalHarga">0</span></p>
                        </div>
                        <div class="text-center sm:text-left">
                            <p class="text-xs sm:text-sm text-gray-600 mb-2">Jumlah Item</p>
                            <p class="text-xl sm:text-2xl md:text-3xl font-bold text-blue-600"><span id="itemCount">0</span></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 sm:pt-8 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.transaksi.index') }}"
                       class="flex-1 px-6 py-3 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg sm:rounded-xl transition-colors text-center text-sm sm:text-base min-h-[48px] flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 px-6 py-3 sm:py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 text-sm sm:text-base min-h-[48px] flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Simpan Transaksi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addItemBtn = document.getElementById('addItemBtn');
    const itemsTableBody = document.getElementById('itemsTableBody');
    const transaksiForm = document.getElementById('transaksiForm');
    const kategoriSampahData = @json($kategoriSampah->keyBy('id')->map(function($k) { return ['id' => $k->id, 'nama' => $k->nama_kategori, 'harga' => (float)$k->harga_per_kg]; })->toArray());

    let itemIndex = 0;

    addItemBtn.addEventListener('click', function() {
        addItemRow();
    });

    function addItemRow(data = null) {
        const index = itemIndex++;
        const kategoriOptions = Object.values(kategoriSampahData).map(k =>
            `<option value="${k.id}" data-harga="${k.harga}">${k.nama}</option>`
        ).join('');

        const row = document.createElement('tr');
        row.innerHTML = `
            <td class="px-2 sm:px-3 md:px-4 py-3">
                <select name="items[${index}][kategori_sampah_id]" class="kategori-select w-full px-2 sm:px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm min-h-[40px]" required data-index="${index}">
                    <option value="">-- Pilih Kategori --</option>
                    ${kategoriOptions}
                </select>
            </td>
            <td class="px-2 sm:px-3 md:px-4 py-3">
                <input type="number" name="items[${index}][berat_kg]" class="berat-input w-full px-2 sm:px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm min-h-[40px]" step="0.01" min="0.1" placeholder="0.00" required data-index="${index}">
            </td>
            <td class="px-2 sm:px-3 md:px-4 py-3">
                <div class="text-xs sm:text-sm font-medium text-gray-900">Rp <span class="harga-display">${data?.harga || 0}</span></div>
            </td>
            <td class="px-2 sm:px-3 md:px-4 py-3">
                <div class="text-xs sm:text-sm font-semibold text-green-600">Rp <span class="total-display">0</span></div>
            </td>
            <td class="px-2 sm:px-3 md:px-4 py-3 text-center">
                <button type="button" class="remove-btn px-2 sm:px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors min-h-[40px] min-w-[40px] flex items-center justify-center" data-index="${index}">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </td>
        `;
        itemsTableBody.appendChild(row);

        const card = document.createElement('div');
        card.className = 'bg-white border border-gray-200 rounded-lg p-4 space-y-3';
        card.innerHTML = `
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700">Item #<span class="item-number">1</span></span>
                <button type="button" class="remove-btn-card px-2 py-1 bg-red-100 hover:bg-red-200 text-red-600 rounded text-xs" data-index="${index}">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1.5">Kategori Sampah</label>
                <select name="items[${index}][kategori_sampah_id]" class="kategori-select-mobile w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 text-xs" required data-index="${index}">
                    <option value="">-- Pilih Kategori --</option>
                    ${kategoriOptions}
                </select>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Berat (kg)</label>
                    <input type="number" name="items[${index}][berat_kg]" class="berat-input-mobile w-full px-3 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 text-xs" step="0.01" min="0.1" placeholder="0.00" required data-index="${index}">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Harga/kg</label>
                    <div class="px-3 py-2.5 bg-gray-50 rounded-lg text-xs font-medium">Rp <span class="harga-display-mobile">0</span></div>
                </div>
            </div>
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                <p class="text-xs text-blue-600 font-semibold mb-1">Total Item</p>
                <p class="text-lg font-bold text-blue-700">Rp <span class="total-display-mobile">0</span></p>
            </div>
        `;
        document.getElementById('itemsCardBody').appendChild(card);

        const kategoriSelect = row.querySelector('.kategori-select');
        const beratInput = row.querySelector('.berat-input');
        const removeBtn = row.querySelector('.remove-btn');

        const kategoriSelectMobile = card.querySelector('.kategori-select-mobile');
        const beratInputMobile = card.querySelector('.berat-input-mobile');
        const removeBtnCard = card.querySelector('.remove-btn-card');

        const syncInputs = () => {
            kategoriSelectMobile.value = kategoriSelect.value;
            beratInputMobile.value = beratInput.value;
        };

        const updateBothRows = () => {
            updateItemTotal(row, card);
            updateCardItemNumbers();
        };

        kategoriSelect.addEventListener('change', function() {
            syncInputs();
            updateBothRows();
        });

        beratInput.addEventListener('input', function() {
            syncInputs();
            updateBothRows();
        });

        kategoriSelectMobile.addEventListener('change', function() {
            kategoriSelect.value = this.value;
            updateBothRows();
        });

        beratInputMobile.addEventListener('input', function() {
            beratInput.value = this.value;
            updateBothRows();
        });

        const removeRow = () => {
            row.remove();
            card.remove();
            updateSummary();
            updateCardItemNumbers();
        };

        removeBtn.addEventListener('click', removeRow);
        removeBtnCard.addEventListener('click', removeRow);

        if (data) {
            kategoriSelect.value = data.kategori_sampah_id;
            beratInput.value = data.berat_kg;
            syncInputs();
            updateBothRows();
        }

        updateCardItemNumbers();
    }

    function updateCardItemNumbers() {
        const cards = document.querySelectorAll('#itemsCardBody > div');
        cards.forEach((card, index) => {
            const numberSpan = card.querySelector('.item-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
        });
    }

    function updateItemTotal(row, card = null) {
        const kategoriSelect = row.querySelector('.kategori-select');
        const beratInput = row.querySelector('.berat-input');
        const hargaDisplay = row.querySelector('.harga-display');
        const totalDisplay = row.querySelector('.total-display');

        const kategoriId = kategoriSelect.value;
        const berat = parseFloat(beratInput.value) || 0;

        if (kategoriId) {
            const kategori = kategoriSampahData[kategoriId];
            if (kategori) {
                const harga = kategori.harga;
                const total = harga * berat;

                hargaDisplay.textContent = harga.toLocaleString('id-ID');
                totalDisplay.textContent = total.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});

                if (card) {
                    const hargaDisplayMobile = card.querySelector('.harga-display-mobile');
                    const totalDisplayMobile = card.querySelector('.total-display-mobile');
                    if (hargaDisplayMobile) hargaDisplayMobile.textContent = harga.toLocaleString('id-ID');
                    if (totalDisplayMobile) totalDisplayMobile.textContent = total.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
                }
            }
        }

        updateSummary();
    }

    function updateSummary() {
        let totalBerat = 0;
        let totalHarga = 0;
        let itemCount = 0;

        document.querySelectorAll('#itemsTableBody tr').forEach(row => {
            const kategoriSelect = row.querySelector('.kategori-select');
            const beratInput = row.querySelector('.berat-input');

            if (kategoriSelect.value) {
                itemCount++;
                const berat = parseFloat(beratInput.value) || 0;
                totalBerat += berat;

                const kategori = kategoriSampahData[kategoriSelect.value];
                if (kategori) {
                    totalHarga += kategori.harga * berat;
                }
            }
        });

        document.getElementById('totalBerat').textContent = totalBerat.toFixed(2);
        document.getElementById('totalHarga').textContent = totalHarga.toLocaleString('id-ID', {minimumFractionDigits: 0, maximumFractionDigits: 0});
        document.getElementById('itemCount').textContent = itemCount;

        const itemsError = document.getElementById('itemsError');
        if (itemCount === 0) {
            itemsError.classList.remove('hidden');
        } else {
            itemsError.classList.add('hidden');
        }
    }

    transaksiForm.addEventListener('submit', function(e) {
        if (document.querySelectorAll('#itemsTableBody tr').length === 0) {
            e.preventDefault();
            document.getElementById('itemsError').classList.remove('hidden');
            return false;
        }

        let hasValidItems = false;
        document.querySelectorAll('#itemsTableBody tr').forEach(row => {
            if (row.querySelector('.kategori-select').value) {
                hasValidItems = true;
            }
        });

        if (!hasValidItems) {
            e.preventDefault();
            document.getElementById('itemsError').classList.remove('hidden');
            return false;
        }
    });

    addItemRow();
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
