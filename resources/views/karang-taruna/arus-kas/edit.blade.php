@extends('karang-taruna.layouts.app')

@section('title', 'Edit Transaksi Kas - SisaKu')

@section('content')
<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="mb-6 sm:mb-8 animate-page-load">
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('karang-taruna.arus-kas.index') }}"
                   class="p-2.5 sm:p-3 hover:bg-white/50 rounded-lg sm:rounded-xl transition-colors flex-shrink-0 min-h-[48px] min-w-[48px] flex items-center justify-center">
                    <i class="fas fa-arrow-left text-gray-600 text-lg sm:text-xl"></i>
                </a>
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">Edit Transaksi Kas</h1>
                    <p class="text-gray-600 mt-1 text-xs sm:text-sm">Ubah data transaksi kas</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-2xl md:rounded-3xl shadow-xl border border-white/20 p-4 sm:p-6 md:p-8 scroll-reveal">
            <form action="{{ route('karang-taruna.arus-kas.update', $arusKas) }}" method="POST" class="space-y-6 sm:space-y-8">
                @csrf
                @method('PUT')

                <!-- Jenis Transaksi (Read-only) -->
                <div>
                    <label for="jenis_transaksi" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2.5 sm:mb-3">
                        Jenis Transaksi
                    </label>
                    <div class="p-3 sm:p-4 bg-gray-100 rounded-lg sm:rounded-xl">
                        @if($arusKas->jenis_transaksi === 'masuk')
                        <span class="inline-block px-2 sm:px-3 py-0.5 sm:py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            <i class="fas fa-arrow-down mr-1"></i>Kas Masuk
                        </span>
                        @else
                        <span class="inline-block px-2 sm:px-3 py-0.5 sm:py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i>Kas Keluar
                        </span>
                        @endif
                    </div>
                    <input type="hidden" name="jenis_transaksi" value="{{ $arusKas->jenis_transaksi }}">
                </div>

                <!-- Kategori Keuangan -->
                <div>
                    <label for="kategori_keuangan_id" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2.5 sm:mb-3">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_keuangan_id" id="kategori_keuangan_id"
                            class="w-full px-3 sm:px-4 py-3 sm:py-4 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all bg-white text-sm sm:text-base min-h-[48px]"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriKeuangan as $kategori)
                        <option value="{{ $kategori->id }}" {{ $arusKas->kategori_keuangan_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    @error('kategori_keuangan_id')
                        <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2.5 sm:mb-3">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold text-sm sm:text-base">Rp</span>
                        <input type="number" name="jumlah" id="jumlah" step="0.01" min="0.01"
                               value="{{ old('jumlah', $arusKas->jumlah) }}"
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-3 sm:py-4 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base min-h-[48px]"
                               placeholder="0.00" required>
                    </div>
                    @error('jumlah')
                        <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="tanggal_transaksi" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2.5 sm:mb-3">
                        Tanggal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                           value="{{ old('tanggal_transaksi', $arusKas->tanggal_transaksi->format('Y-m-d')) }}"
                           class="w-full px-3 sm:px-4 py-3 sm:py-4 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm sm:text-base min-h-[48px]"
                           required>
                    @error('tanggal_transaksi')
                        <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2.5 sm:mb-3">
                        Deskripsi
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="w-full px-3 sm:px-4 py-3 sm:py-4 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all resize-none text-sm sm:text-base"
                              placeholder="Contoh: Pembayaran operasional bulanan...">{{ old('deskripsi', $arusKas->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 sm:pt-8 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.arus-kas.index') }}"
                       class="flex-1 px-6 py-3 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg sm:rounded-xl transition-colors text-center text-xs sm:text-sm md:text-base min-h-[48px] flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                            class="flex-1 px-6 py-3 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium rounded-lg sm:rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5 text-xs sm:text-sm md:text-base min-h-[48px] flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>Update Transaksi</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

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
