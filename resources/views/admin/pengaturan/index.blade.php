@extends('admin.layouts.app')

@section('title', 'Pengaturan Akun - SisaKu')

@section('content')

<div class="w-full min-h-screen px-2 sm:px-3 md:px-4 lg:px-6 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-6 sm:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4 md:mb-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 sm:mb-2 leading-tight">Pengaturan Akun</h1>
        <p class="text-xs sm:text-sm text-gray-500 font-medium">Kelola informasi profil dan keamanan akun Anda</p>
    </div>
</div>

<!-- Success/Error Messages -->
@if(session('success'))
<div class="mb-4 sm:mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-4 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl animate-fade-in-up text-xs sm:text-sm">
    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="mb-4 sm:mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-4 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl animate-fade-in-up text-xs sm:text-sm">
    <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8 mb-6 sm:mb-8">

    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-4 sm:space-y-6">

        <!-- Profile Card -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-fade-in-up">
            <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6 md:mb-8">
                <div class="w-10 sm:w-12 md:w-14 h-10 sm:h-12 md:h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center shadow-soft flex-shrink-0">
                    <i class="fas fa-user text-white text-sm sm:text-base md:text-lg"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Informasi Profil</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Perbarui data profil Anda</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-4 sm:space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Nama</label>
                    <input type="text" name="name" id="name"
                           value="{{ old('name', auth()->user()->name) }}"
                           class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl outline-none transition-all duration-200 bg-gray-50 focus:bg-white focus:ring-2 focus:ring-green-500 focus:border-transparent text-sm min-h-[44px]"
                           placeholder="Masukkan nama">
                    @error('name')
                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" id="email"
                           value="{{ old('email', auth()->user()->email) }}"
                           class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm min-h-[44px]"
                           placeholder="nama@gmail.com">
                    @error('email')
                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern text-xs sm:text-sm min-h-[48px] flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>Simpan Perubahan
                </button>
            </form>
        </div>

        <!-- Password Card -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="flex items-center gap-3 sm:gap-4 mb-4 sm:mb-6 md:mb-8">
                <div class="w-10 sm:w-12 md:w-14 h-10 sm:h-12 md:h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center shadow-soft flex-shrink-0">
                    <i class="fas fa-lock text-white text-sm sm:text-base md:text-lg"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Ubah Password</h2>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Perbarui password untuk keamanan akun</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.pengaturan.update') }}" class="space-y-3 sm:space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" name="change_password" value="1">

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Password Lama</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm pr-10 sm:pr-12"
                               placeholder="Masukkan password lama">
                        <button type="button" onclick="togglePassword('current_password')" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 text-sm">
                            <i class="fas fa-eye" id="eyeIcon_current_password"></i>
                        </button>
                    </div>
                    @error('current_password')
                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Password Baru</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-green-600 text-sm"></i>
                        <input type="password" name="password" id="password"
                               class="w-full pl-10 sm:pl-12 pr-10 sm:pr-12 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm"
                               placeholder="Masukkan password baru (min. 8 karakter)">
                        <button type="button" onclick="togglePassword('password')" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 text-sm">
                            <i class="fas fa-eye" id="eyeIcon_password"></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-1.5 sm:mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm pr-10 sm:pr-12"
                               placeholder="Konfirmasi password baru">
                        <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 text-sm">
                            <i class="fas fa-eye" id="eyeIcon_password_confirmation"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full px-4 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-xl md:rounded-2xl font-semibold transition-all shadow-modern text-sm sm:text-base">
                    <i class="fas fa-key mr-2"></i>Ubah Password
                </button>
            </form>
        </div>
    </div>

    <!-- Account Info Sidebar -->
    <div class="lg:col-span-1">
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="flex items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-soft">
                    <i class="fas fa-user-shield text-white text-base sm:text-lg md:text-xl"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Ringkasan Akun</h3>
                    <p class="text-xs sm:text-sm text-gray-500 font-medium">Informasi akun Anda</p>
                </div>
            </div>
            <div class="space-y-2 sm:space-y-3">
                <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-100 gap-2">
                    <span class="text-xs sm:text-sm font-semibold text-gray-700">Role</span>
                    <span class="text-xs sm:text-sm font-bold text-gray-900 text-right">{{ auth()->user()->role->nama_role ?? 'Admin' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-100 gap-2">
                    <span class="text-xs sm:text-sm font-semibold text-gray-700">Login Terakhir</span>
                    <span class="text-xs sm:text-sm font-bold text-gray-900 text-right">{{ auth()->user()->last_login ? auth()->user()->last_login->format('d/m/Y') : 'Belum' }}</span>
                </div>
                <div class="flex justify-between items-center py-2 sm:py-3 gap-2">
                    <span class="text-xs sm:text-sm font-semibold text-gray-700">Status</span>
                    <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-bold flex-shrink-0 {{ auth()->user()->status_akun == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ ucfirst(auth()->user()->status_akun ?? 'aktif') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
