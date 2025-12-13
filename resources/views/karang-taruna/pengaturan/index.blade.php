@extends('karang-taruna.layouts.app')

@section('title', 'Pengaturan - SisaKu')

@section('content')
<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">

        <!-- Header -->
        <div class="mb-6 sm:mb-8 animate-page-load scroll-reveal">
            <div class="min-w-0 flex-1">
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 leading-tight scroll-float">Pengaturan Akun</h1>
                <p class="text-xs sm:text-sm text-gray-500 font-medium scroll-wave">Kelola profil dan keamanan akun Anda</p>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-4 sm:mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-3 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl text-xs sm:text-sm animate-page-load">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mb-4 sm:mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-3 sm:px-6 py-3 sm:py-4 rounded-lg sm:rounded-xl animate-page-load">
            <ul class="list-disc list-inside text-xs sm:text-sm space-y-1">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            <!-- Profile Sidebar -->
            <div class="lg:col-span-1">
                <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-page-load scroll-reveal">
                    <div class="text-center mb-4 sm:mb-6 pb-4 sm:pb-6 border-b border-gray-100">
                        <div class="w-16 sm:w-20 h-16 sm:h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg sm:rounded-2xl flex items-center justify-center text-white text-lg sm:text-2xl font-bold mx-auto mb-3 sm:mb-4 shadow-soft">
                            {{ substr(auth()->user()->karangTaruna->nama_lengkap ?? auth()->user()->name, 0, 1) }}
                        </div>
                        <h3 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">{{ auth()->user()->karangTaruna->nama_lengkap ?? auth()->user()->name }}</h3>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-100">
                            <span class="text-xs sm:text-sm font-semibold text-gray-700">Username</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 text-right">{{ auth()->user()->username }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-100">
                            <span class="text-xs sm:text-sm font-semibold text-gray-700">Status</span>
                            <span class="inline-flex px-2 sm:px-3 py-0.5 sm:py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                Aktif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 sm:py-3 border-b border-gray-100 gap-2">
                            <span class="text-xs sm:text-sm font-semibold text-gray-700">Unit</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 text-right truncate">{{ auth()->user()->karangTaruna->nama_unit ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 sm:py-3 gap-2">
                            <span class="text-xs sm:text-sm font-semibold text-gray-700">Bergabung</span>
                            <span class="text-xs sm:text-sm font-bold text-gray-900 text-right">{{ auth()->user()->created_at ? auth()->user()->created_at->format('d/m/Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-6">

                <!-- Edit Profile Card -->
                <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-page-load scroll-reveal" style="animation-delay: 0.2s;">
                    <div class="flex items-center gap-2 sm:gap-4 mb-4 sm:mb-6 md:mb-8">
                        <div class="w-10 sm:w-14 h-10 sm:h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg sm:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-soft">
                            <i class="fas fa-user text-white text-sm sm:text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">Edit Profil</h2>
                            <p class="text-xs sm:text-sm text-gray-500 font-medium">Perbarui data profil Anda</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('karang-taruna.pengaturan.update') }}" class="space-y-3 sm:space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->karangTaruna->nama_lengkap ?? auth()->user()->name) }}"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm min-h-[44px]">
                                @error('nama_lengkap')
                                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Username</label>
                                <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm min-h-[44px]">
                                @error('username')
                                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Email (harus @gmail.com)</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm min-h-[44px]"
                                    placeholder="nama@gmail.com">
                                @error('email')
                                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp', auth()->user()->karangTaruna->no_telp) }}"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm min-h-[44px]">
                                @error('no_telp')
                                <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-2xl font-semibold transition-all shadow-modern text-sm sm:text-base min-h-[44px] flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i><span>Simpan Perubahan</span>
                        </button>
                    </form>
                </div>

                <!-- Change Password Card -->
                <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-page-load scroll-reveal" style="animation-delay: 0.1s;">
                    <div class="flex items-center gap-2 sm:gap-4 mb-4 sm:mb-6 md:mb-8">
                        <div class="w-10 sm:w-14 h-10 sm:h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-lg sm:rounded-2xl flex items-center justify-center flex-shrink-0 shadow-soft">
                            <i class="fas fa-lock text-white text-sm sm:text-xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h2 class="text-base sm:text-lg md:text-2xl font-bold text-gray-900">Ubah Password</h2>
                            <p class="text-xs sm:text-sm text-gray-500 font-medium">Perbarui password untuk keamanan akun</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('karang-taruna.pengaturan.update') }}" class="space-y-3 sm:space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="change_password" value="1">

                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm pr-10 sm:pr-12 min-h-[44px]"
                                    placeholder="Masukkan password lama">
                                <button type="button" onclick="togglePassword('current_password')" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 text-sm">
                                    <i class="fas fa-eye" id="eyeIcon_current_password"></i>
                                </button>
                            </div>
                            @error('current_password')
                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm pr-10 sm:pr-12 min-h-[44px]"
                                    placeholder="Masukkan password baru (min. 8 karakter)">
                                <button type="button" onclick="togglePassword('password')" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 text-sm">
                                    <i class="fas fa-eye" id="eyeIcon_password"></i>
                                </button>
                            </div>
                            @error('password')
                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border border-gray-300 rounded-lg sm:rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white text-sm pr-10 sm:pr-12 min-h-[44px]"
                                    placeholder="Konfirmasi password baru">
                                <button type="button" onclick="togglePassword('password_confirmation')" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 text-sm">
                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                            @error('password_confirmation')
                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-lg sm:rounded-2xl font-semibold transition-all shadow-modern text-sm sm:text-base min-h-[44px] flex items-center justify-center gap-2">
                            <i class="fas fa-key"></i><span>Ubah Password</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
