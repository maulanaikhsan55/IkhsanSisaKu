@extends('karang-taruna.layouts.app')

@section('title', 'Tambah Warga - SisaKu')

@section('content')
<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">
    <div class="max-w-3xl mx-auto">

        <!-- Header -->
        <div class="mb-6 sm:mb-8 animate-fade-in-up">
            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('karang-taruna.warga.index') }}" class="p-2.5 sm:p-3 hover:bg-white/50 rounded-lg sm:rounded-xl transition-colors flex-shrink-0 min-h-[48px] min-w-[48px] flex items-center justify-center">
                    <i class="fas fa-arrow-left text-gray-600 text-lg sm:text-xl"></i>
                </a>
                <div class="min-w-0 flex-1">
                    <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">Tambah Warga Baru</h1>
                    <p class="text-gray-600 mt-1 text-xs sm:text-sm">Daftarkan warga baru ke Karang Taruna</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white/80 backdrop-blur-sm rounded-lg sm:rounded-2xl md:rounded-3xl shadow-xl border border-white/20 p-4 sm:p-6 md:p-8 animate-fade-in-up">
            <form method="POST" action="{{ route('karang-taruna.warga.store') }}" class="space-y-6 sm:space-y-8">
                @csrf

                <!-- Nama -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama') }}"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm text-gray-900 placeholder-gray-400 min-h-[44px]"
                        placeholder="Masukkan nama warga" required>
                    @error('nama')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Alamat <span class="text-red-500">*</span></label>
                    <textarea name="alamat" rows="3"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm text-gray-900 placeholder-gray-400 resize-none min-h-[88px]"
                        placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                    <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}"
                        class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl outline-none transition-all focus:ring-2 focus:ring-green-600 focus:border-green-600 text-sm text-gray-900 placeholder-gray-400 min-h-[44px]"
                        placeholder="Contoh: 081234567890">
                    @error('no_telepon')
                        <p class="text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 pt-6 sm:pt-8 border-t border-gray-100">
                    <a href="{{ route('karang-taruna.warga.index') }}" class="flex-1 px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-br from-gray-50 to-white hover:from-gray-100 hover:to-gray-50 text-gray-700 font-semibold rounded-lg sm:rounded-xl transition-all border border-gray-200 hover:border-gray-300 shadow-soft text-xs sm:text-sm text-center min-h-[48px] flex items-center justify-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" class="flex-1 px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm min-h-[48px] flex items-center justify-center">
                        <i class="fas fa-save mr-2"></i>Simpan Warga
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>

@endsection
