@extends('karang-taruna.layouts.app')

@section('title', 'Tambah Transaksi Sampah - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center gap-4">
                <a href="{{ route('karang-taruna.transaksi.index') }}"
                   class="p-3 hover:bg-white/50 rounded-xl transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Transaksi Baru</h1>
                    <p class="text-gray-600 mt-1">Catat sampah dari warga dengan multiple items</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 animate-scale-in">
            <form id="transaksiForm" action="{{ route('karang-taruna.transaksi.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Warga Selection -->
                <div>
                    <label for="warga_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Pilih Warga <span class="text-red-500">*</span>
                    </label>
                    @if($warga->count() > 0)
                    <select name="warga_id" id="warga_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white"
                            required>
                        <option value="">-- Pilih Warga --</option>
                        @foreach($warga as $w)
                        <option value="{{ $w->id }}">{{ $w->nama }}</option>
                        @endforeach
                    </select>
                    @else
                    <div class="w-full px-4 py-3 border border-red-300 bg-red-50 rounded-xl text-red-700">
                        <p class="text-sm"><i class="fas fa-exclamation-circle mr-2"></i>Belum ada data warga. <a href="{{ route('karang-taruna.warga.create') }}" class="font-semibold hover:underline">Tambah warga terlebih dahulu</a></p>
                    </div>
                    @endif
                    @error('warga_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Transaksi -->
                <div>
                    <label for="tanggal_transaksi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                           value="{{ date('Y-m-d') }}" required>
                    @error('tanggal_transaksi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Items Section -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-box mr-2 text-green-600"></i>
                            Item Sampah <span class="text-red-500">*</span>
                        </label>
                        <button type="button" id="addItemBtn"
                                class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-plus mr-1"></i>
                            Tambah Item
                        </button>
                    </div>

                    <!-- Items Table -->
                    <div class="overflow-x-auto border border-gray-200 rounded-xl">
                        <table class="w-full">
                            <thead class="bg-gray-100 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Kategori</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Berat (kg)</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Harga/kg</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-700">Total</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody" class="divide-y divide-gray-200">
                                <!-- Items akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>

                    <div id="itemsError" class="mt-2 text-sm text-red-600 hidden">
                        Minimal tambahkan 1 item sampah
                    </div>

                    @error('items')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Summary Card -->
                <div class="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6 border border-green-200">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Berat</p>
                            <p class="text-2xl font-bold text-gray-900"><span id="totalBerat">0</span> kg</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Harga</p>
                            <p class="text-2xl font-bold text-green-600">Rp <span id="totalHarga">0</span></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Jumlah Item</p>
                            <p class="text-2xl font-bold text-blue-600"><span id="itemCount">0</span></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.transaksi.index') }}"
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Transaksi
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
        const row = document.createElement('tr');
        const index = itemIndex++;

        const kategoriOptions = Object.values(kategoriSampahData).map(k => 
            `<option value="${k.id}" data-harga="${k.harga}">${k.nama}</option>`
        ).join('');

        row.innerHTML = `
            <td class="px-4 py-3">
                <select name="items[${index}][kategori_sampah_id]" class="kategori-select w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" required data-index="${index}">
                    <option value="">-- Pilih Kategori --</option>
                    ${kategoriOptions}
                </select>
            </td>
            <td class="px-4 py-3">
                <input type="number" name="items[${index}][berat_kg]" class="berat-input w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" step="0.01" min="0.1" placeholder="0.00" required data-index="${index}">
            </td>
            <td class="px-4 py-3">
                <div class="text-sm font-medium text-gray-900">Rp <span class="harga-display">${data?.harga || 0}</span></div>
            </td>
            <td class="px-4 py-3">
                <div class="text-sm font-semibold text-green-600">Rp <span class="total-display">0</span></div>
            </td>
            <td class="px-4 py-3 text-center">
                <button type="button" class="remove-btn px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors text-sm" data-index="${index}">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;

        itemsTableBody.appendChild(row);

        const kategoriSelect = row.querySelector('.kategori-select');
        const beratInput = row.querySelector('.berat-input');
        const removeBtn = row.querySelector('.remove-btn');

        kategoriSelect.addEventListener('change', function() {
            updateItemTotal(row);
        });

        beratInput.addEventListener('input', function() {
            updateItemTotal(row);
        });

        removeBtn.addEventListener('click', function() {
            row.remove();
            updateSummary();
        });

        if (data) {
            kategoriSelect.value = data.kategori_sampah_id;
            beratInput.value = data.berat_kg;
            updateItemTotal(row);
        }
    }

    function updateItemTotal(row) {
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
