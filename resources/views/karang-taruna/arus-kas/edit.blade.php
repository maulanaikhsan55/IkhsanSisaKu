@extends('karang-taruna.layouts.app')

@section('title', 'Edit Transaksi Kas - SisaKu')

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
                    <h1 class="text-3xl font-bold text-gray-900">Edit Transaksi Kas</h1>
                    <p class="text-gray-600 mt-1">Ubah data transaksi kas</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 animate-scale-in">
            <form action="{{ route('karang-taruna.arus-kas.update', $arusKas) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Jenis Transaksi (Read-only) -->
                <div>
                    <label for="jenis_transaksi" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jenis Transaksi
                    </label>
                    <div class="p-4 bg-gray-100 rounded-xl">
                        @if($arusKas->jenis_transaksi === 'masuk')
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                            <i class="fas fa-arrow-down mr-1"></i>Kas Masuk
                        </span>
                        @else
                        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                            <i class="fas fa-arrow-up mr-1"></i>Kas Keluar
                        </span>
                        @endif
                    </div>
                    <input type="hidden" name="jenis_transaksi" value="{{ $arusKas->jenis_transaksi }}">
                </div>

                <!-- Kategori Keuangan -->
                <div>
                    <label for="kategori_keuangan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori_keuangan_id" id="kategori_keuangan_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all bg-white"
                            required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoriKeuangan as $kategori)
                        <option value="{{ $kategori->id }}" {{ $arusKas->kategori_keuangan_id == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
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
                               value="{{ old('jumlah', $arusKas->jumlah) }}"
                               class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
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
                           value="{{ old('tanggal_transaksi', $arusKas->tanggal_transaksi->format('Y-m-d')) }}"
                           class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
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
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                              placeholder="Contoh: Pembayaran operasional bulanan...">{{ old('deskripsi', $arusKas->deskripsi) }}</textarea>
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
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        <i class="fas fa-save mr-2"></i>Update Transaksi
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
