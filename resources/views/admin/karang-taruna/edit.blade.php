@extends('admin.layouts.app')

@section('title', 'Edit Karang Taruna - SisaKu')

@section('content')

<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-4 sm:mb-6 md:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4 md:mb-6 flex items-center gap-2 sm:gap-4">
        <a href="{{ route('admin.karang-taruna.index') }}" class="p-2 sm:p-3 hover:bg-gray-100 rounded-lg sm:rounded-2xl transition-colors flex-shrink-0">
            <i class="fas fa-arrow-left text-gray-600 text-sm sm:text-base"></i>
        </a>
        <div class="min-w-0">
            <h1 class="text-xl sm:text-2xl md:text-4xl font-bold text-gray-900 truncate">Edit Karang Taruna</h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium truncate">Update data Karang Taruna RW {{ $karangTaruna->rw }}</p>
        </div>
    </div>
</div>

<!-- Error Messages -->
@if($errors->any())
<div class="bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 mb-4 sm:mb-6 rounded-lg sm:rounded-xl animate-scale-in">
    <div class="flex items-start gap-2 sm:gap-3">
        <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
        <div class="flex-1 min-w-0">
            <p class="text-red-800 font-semibold mb-2 text-sm sm:text-base">Terdapat kesalahan pada form:</p>
            <ul class="list-disc list-inside text-red-700 text-xs sm:text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endif

<form action="{{ route('admin.karang-taruna.update', $karangTaruna->id) }}" method="POST" class="space-y-4 sm:space-y-5 md:space-y-6">
    @csrf
    @method('PUT')

    <!-- User Account Info -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern animate-scale-in">
        <div class="flex items-start gap-2 sm:gap-3 mb-3 sm:mb-4">
            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                <i class="fas fa-info-circle text-green-600 text-xs sm:text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-xs sm:text-sm font-bold text-gray-900">Informasi Akun Login</h3>
                <p class="text-xs text-gray-500 mt-0.5">Data akun tidak dapat diubah dari halaman ini</p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 bg-green-50 p-2 rounded-lg border border-green-100">
            <div>
                <p class="text-xs font-semibold text-green-700 mb-0.5 tracking-wide">Username</p>
                <p class="text-xs font-medium text-gray-900">{{ $karangTaruna->user->username }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-green-700 mb-0.5 tracking-wide">Email</p>
                <p class="text-xs font-medium text-gray-900">{{ $karangTaruna->user->email }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-green-700 mb-0.5 tracking-wide">Nama Pengguna</p>
                <p class="text-xs font-medium text-gray-900">{{ $karangTaruna->user->name }}</p>
            </div>
        </div>
    </div>

    <!-- Karang Taruna Data Section -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern animate-scale-in" style="animation-delay: 0.1s;">
        <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4 pb-2 sm:pb-3 border-b border-gray-200">
            <div class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                <i class="fas fa-building text-green-600 text-xs sm:text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <h3 class="text-xs sm:text-sm font-bold text-gray-900">Data Karang Taruna</h3>
                <p class="text-xs text-gray-500 mt-0.5">Informasi unit bank sampah</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 md:gap-5">
            <!-- Nama Karang Taruna -->
            <div class="md:col-span-2">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Nama Karang Taruna <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nama_karang_taruna"
                    value="{{ old('nama_karang_taruna', $karangTaruna->nama_karang_taruna) }}"
                    placeholder="Contoh: Karang Taruna Sejahtera RW 01"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('nama_karang_taruna') border-red-500 @enderror"
                    required
                >
                @error('nama_karang_taruna')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nama Lengkap -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Nama Lengkap
                </label>
                <input
                    type="text"
                    name="nama_lengkap"
                    value="{{ old('nama_lengkap', $karangTaruna->nama_lengkap) }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('nama_lengkap') border-red-500 @enderror"
                >
                @error('nama_lengkap')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- No Telp -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    No. Telepon
                </label>
                <input
                    type="text"
                    name="no_telp"
                    value="{{ old('no_telp', $karangTaruna->no_telp) }}"
                    placeholder="Contoh: 081234567890"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('no_telp') border-red-500 @enderror"
                >
                @error('no_telp')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- RW -->
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    RW <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="rw"
                    value="{{ old('rw', $karangTaruna->rw) }}"
                    placeholder="Contoh: 01"
                    class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all text-sm @error('rw') border-red-500 @enderror"
                    required
                >
                @error('rw')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="md:col-span-2">
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <div class="flex gap-4">
                    <!-- Aktif Option -->
                    <label class="flex-1 cursor-pointer">
                        <input 
                            type="radio" 
                            name="status" 
                            value="aktif"
                            {{ old('status', $karangTaruna->status) == 'aktif' ? 'checked' : '' }}
                            class="sr-only peer"
                            required
                        >
                        <div class="p-2.5 sm:p-4 border-2 rounded-lg sm:rounded-xl transition-all {{ old('status', $karangTaruna->status) == 'aktif' ? 'border-green-500 bg-green-50' : 'border-gray-200' }} hover:border-gray-300">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-5 h-5 rounded-full border-2 {{ old('status', $karangTaruna->status) == 'aktif' ? 'border-green-500' : 'border-gray-300' }} flex items-center justify-center flex-shrink-0">
                                    @if(old('status', $karangTaruna->status) == 'aktif')
                                    <div class="w-3 h-3 rounded-full bg-green-500"></div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-900">Aktif</p>
                                    <p class="text-xs text-gray-500">Dapat login</p>
                                </div>
                            </div>
                        </div>
                    </label>

                    <!-- Nonaktif Option -->
                    <label class="flex-1 cursor-pointer">
                        <input 
                            type="radio" 
                            name="status" 
                            value="nonaktif"
                            {{ old('status', $karangTaruna->status) == 'nonaktif' ? 'checked' : '' }}
                            class="sr-only peer"
                        >
                        <div class="p-2.5 sm:p-4 border-2 rounded-lg sm:rounded-xl transition-all {{ old('status', $karangTaruna->status) == 'nonaktif' ? 'border-red-500 bg-red-50' : 'border-gray-200' }} hover:border-gray-300">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="w-5 h-5 rounded-full border-2 {{ old('status', $karangTaruna->status) == 'nonaktif' ? 'border-red-500' : 'border-gray-300' }} flex items-center justify-center flex-shrink-0">
                                    @if(old('status', $karangTaruna->status) == 'nonaktif')
                                    <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs sm:text-sm font-semibold text-gray-900">Nonaktif</p>
                                    <p class="text-xs text-gray-500">Tidak dapat login</p>
                                </div>
                            </div>
                        </div>
                    </label>
                </div>
                @error('status')
                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <!-- Submit Buttons -->
    <div class="flex gap-4 animate-fade-in-up" style="animation-delay: 0.2s;">
        <a href="{{ route('admin.karang-taruna.index') }}" class="flex-1 px-6 py-4 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-2xl font-semibold text-center transition-all shadow-soft transform hover:scale-105">
            <i class="fas fa-times mr-2"></i>
            Batal
        </a>
        <button type="submit" class="flex-1 px-6 py-4 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 hover:shadow-lg text-white rounded-2xl font-semibold transition-all shadow-modern transform hover:scale-105">
            <i class="fas fa-check-circle mr-2"></i>
            Update Data
        </button>
    </div>
</form>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const radios = document.querySelectorAll('input[name="status"]');
    
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            // Reset semua
            radios.forEach(r => {
                const label = r.closest('label');
                const container = label.querySelector('div[class*="p-2"]');
                const circle = label.querySelector('div[class*="w-5"]');
                const dot = label.querySelector('div[class*="w-3"]');
                
                // Reset ke default
                container.className = container.className
                    .replace(/border-green-500|bg-green-50|border-red-500|bg-red-50/g, '')
                    .replace(/border-gray-200/g, '') + ' border-gray-200';
                circle.className = circle.className
                    .replace(/border-green-500|border-red-500/g, '')
                    .replace(/border-gray-300/g, '') + ' border-gray-300';
                if (dot) dot.remove();
            });
            
            // Set yang dipilih
            const label = this.closest('label');
            const container = label.querySelector('div[class*="p-2"]');
            const circle = label.querySelector('div[class*="w-5"]');
            
            if (this.value === 'aktif') {
                container.className = container.className.replace('border-gray-200', 'border-green-500 bg-green-50');
                circle.className = circle.className.replace('border-gray-300', 'border-green-500');
                circle.innerHTML = '<div class="w-3 h-3 rounded-full bg-green-500"></div>';
            } else {
                container.className = container.className.replace('border-gray-200', 'border-red-500 bg-red-50');
                circle.className = circle.className.replace('border-gray-300', 'border-red-500');
                circle.innerHTML = '<div class="w-3 h-3 rounded-full bg-red-500"></div>';
            }
        });
    });
});
</script>
@endpush