@extends('karang-taruna.layouts.app')

@section('title', 'Tambah Warga - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

<!-- Header -->
<div class="mb-8 animate-fade-in-up">
    <div class="flex items-center gap-3">
        <a href="{{ route('karang-taruna.warga.index') }}" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
            <i class="fas fa-arrow-left text-gray-700"></i>
        </a>
        <div>
            <h1 class="text-4xl font-black text-gray-900">Tambah Warga Baru</h1>
            <p class="text-gray-600 mt-1">Daftarkan warga baru ke Karang Taruna</p>
        </div>
    </div>
</div>

<!-- Form Card -->
<div class="bg-white rounded-3xl shadow-md border border-gray-200/50 p-8 animate-fade-in-up" style="animation-delay: 0.1s;">
    <form method="POST" action="{{ route('karang-taruna.warga.store') }}" class="space-y-6">
        @csrf

        <!-- Nama -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">Nama <span class="text-red-600">*</span></label>
            <input type="text" name="nama" value="{{ old('nama') }}" 
                class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition-all text-gray-900 placeholder-gray-400" 
                placeholder="Masukkan nama warga" required>
            @error('nama')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Alamat -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">Alamat <span class="text-red-600">*</span></label>
            <textarea name="alamat" rows="3" 
                class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition-all text-gray-900 placeholder-gray-400 resize-none" 
                placeholder="Masukkan alamat lengkap" required>{{ old('alamat') }}</textarea>
            @error('alamat')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Telepon -->
        <div>
            <label class="block text-sm font-semibold text-gray-900 mb-2">Nomor Telepon</label>
            <input type="tel" name="no_telepon" value="{{ old('no_telepon') }}" 
                class="w-full px-4 py-3 rounded-2xl border border-gray-300 focus:border-green-500 focus:ring-2 focus:ring-green-200 outline-none transition-all text-gray-900 placeholder-gray-400" 
                placeholder="Contoh: 081234567890">
            @error('no_telepon')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Buttons -->
        <div class="flex gap-4 pt-6 border-t border-gray-200">
            <a href="{{ route('karang-taruna.warga.index') }}" class="flex-1 px-6 py-3 bg-gray-200 text-gray-900 font-semibold rounded-2xl hover:bg-gray-300 transition-all duration-300 text-center">
                Batal
            </a>
            <button type="submit" class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl hover:from-green-600 hover:to-emerald-700 transform hover:-translate-y-1 transition-all duration-300">
                Simpan Warga
            </button>
        </div>
    </form>
</div>

</div>
</div>

@endsection
