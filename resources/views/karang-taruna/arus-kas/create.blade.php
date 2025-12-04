@extends('karang-taruna.layouts.app')

@section('title', 'Tambah Transaksi Kas - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center gap-4">
                <a href="{{ route('karang-taruna.arus-kas.index') }}"
                   class="p-3 hover:bg-white/50 rounded-xl transition-colors">
                    <i class="fas fa-arrow-left text-gray-600"></i>
                </a>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Transaksi Kas</h1>
                    <p class="text-gray-600 mt-1">Catat transaksi kas masuk atau keluar</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 animate-scale-in">
            <form action="{{ route('karang-taruna.arus-kas.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Jenis Transaksi -->
                <div>
                    <label for="jenis_transaksi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Transaksi <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-green-500 transition-colors"
                               onclick="updateKategori('masuk')">
                            <input type="radio" name="jenis_transaksi" value="masuk" id="jenis_masuk" 
                                   class="w-4 h-4 text-green-600 cursor-pointer" required>
                            <div class="ml-3">
                                <i class="fas fa-arrow-down text-green-600 text-lg mb-1"></i>
                                <p class="font-semibold text-gray-900">Kas Masuk</p>
                                <p class="text-xs text-gray-500 mt-1">Penjualan, hibah, donasi</p>
                            </div>
                        </label>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-red-500 transition-colors"
                               onclick="updateKategori('keluar')">
                            <input type="radio" name="jenis_transaksi" value="keluar" id="jenis_keluar"
                                   class="w-4 h-4 text-red-600 cursor-pointer" required>
                            <div class="ml-3">
                                <i class="fas fa-arrow-up text-red-600 text-lg mb-1"></i>
                                <p class="font-semibold text-gray-900">Kas Keluar</p>
                                <p class="text-xs text-gray-500 mt-1">Operasional, kegiatan</p>
                            </div>
                        </label>
                    </div>
                    @error('jenis_transaksi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori Keuangan -->
                <div>
                    <label for="kategori_keuangan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_keuangan_id" id="kategori_keuangan_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                    </select>
                    @error('kategori_keuangan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" step="0.01" min="0.01"
                               value="{{ old('jumlah') }}"
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                               placeholder="0.00" required>
                    </div>
                    @error('jumlah')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="tanggal_transaksi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                           value="{{ old('tanggal_transaksi', date('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                           required>
                    @error('tanggal_transaksi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none"
                              placeholder="Contoh: Pembayaran operasional bulanan...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.arus-kas.index') }}"
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl transition-colors text-center">
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
const kategoriData = {
    masuk: @json($kategoriMasuk ?? []),
    keluar: @json($kategoriKeluar ?? [])
};

function updateKategori(jenis) {
    const select = document.getElementById('kategori_keuangan_id');
    select.innerHTML = '<option value="">-- Pilih Kategori --</option>';
    
    const kategori = kategoriData[jenis];
    if (kategori && kategori.length > 0) {
        kategori.forEach(k => {
            const option = document.createElement('option');
            option.value = k.id;
            option.textContent = k.nama_kategori;
            select.appendChild(option);
        });
    }
}
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
