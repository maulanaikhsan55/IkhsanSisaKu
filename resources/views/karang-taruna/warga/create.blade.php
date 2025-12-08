@extends('karang-taruna.layouts.app')

@section('title', 'Tambah Warga - SisaKu')

@section('content')
<div class="w-full px-4 md:px-6 lg:px-12">
    <div class="max-w-3xl mx-auto py-6">

        <!-- Header -->
        <div class="mb-8 animate-fade-in-up">
            <div class="flex items-center gap-3">
                <a href="{{ route('karang-taruna.warga.index') }}" class="p-2 md:p-3 hover:bg-white/50 rounded-lg md:rounded-xl transition-colors flex-shrink-0">
                    <i class="fas fa-arrow-left text-gray-600 text-lg md:text-xl"></i>
                </a>
                <div class="min-w-0">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">Tambah Warga Baru</h1>
                    <p class="text-gray-600 mt-1 text-sm md:text-base">Daftarkan warga baru ke Karang Taruna</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="glass-dark rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-modern border-modern animate-fade-in-up" style="animation-delay: 0.1s;">
            <form method="POST" action="{{ route('karang-taruna.warga.store') }}" class="space-y-6">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}" 
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm text-gray-900 placeholder-gray-400" 
                        placeholder="Masukkan nama warga" required>
                    @error('nama')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3" 
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm text-gray-900 placeholder-gray-400 resize-none" 
                        placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" 
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm text-gray-900 placeholder-gray-400" 
                        placeholder="Contoh: 081234567890">
                    @error('no_telepon')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex flex-col md:flex-row gap-2 sm:gap-3 md:gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.warga.index') }}" class="flex-1 px-4 md:px-6 py-2 md:py-3 bg-gradient-to-br from-gray-50 to-white hover:from-gray-100 hover:to-gray-50 text-gray-700 font-medium rounded-lg md:rounded-xl transition-all border border-gray-200 hover:border-gray-300 shadow-soft text-xs md:text-sm text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-4 md:px-6 py-2 md:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-medium rounded-lg md:rounded-xl shadow-modern transition-all text-xs md:text-sm">
                        Simpan Warga
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
