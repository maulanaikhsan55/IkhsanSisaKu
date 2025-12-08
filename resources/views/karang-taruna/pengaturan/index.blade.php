@extends('karang-taruna.layouts.app')

@section('title', 'Pengaturan - SisaKu')

@section('content')
<div class="w-full px-4 md:px-6 lg:px-12">

        <!-- Header - Clean & Modern -->
        <div class="mb-8 animate-fade-in-up">
            <div class="glass-dark rounded-3xl p-8 shadow-modern border-modern">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pengaturan Akun</h1>
                        <p class="text-gray-500 font-medium">Kelola profil dan keamanan akun Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl animate-fade-in-up">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl animate-fade-in-up">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Sidebar -->
            <div class="lg:col-span-1">
                <div class="glass-dark rounded-3xl shadow-modern border-modern p-8 animate-fade-in-up">
                    <div class="text-center mb-6 pb-6 border-b border-gray-100">
                        <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4 shadow-soft">
                            {{ substr(auth()->user()->karangTaruna->nama_lengkap ?? auth()->user()->name, 0, 1) }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">{{ auth()->user()->karangTaruna->nama_lengkap ?? auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email }}</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Username</span>
                            <span class="text-sm font-bold text-gray-900">{{ auth()->user()->username }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Status</span>
                            <span class="inline-flex px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">
                                Aktif
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Unit</span>
                            <span class="text-sm font-bold text-gray-900">{{ auth()->user()->karangTaruna->nama_unit ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-semibold text-gray-700">Bergabung</span>
                            <span class="text-sm font-bold text-gray-900">{{ auth()->user()->created_at ? auth()->user()->created_at->format('d M Y') : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Edit Profile Card -->
                <div class="glass-dark rounded-3xl shadow-modern border-modern p-8 animate-fade-in-up">
                    <div class="flex items-center mb-8">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-4 shadow-soft">
                            <i class="fas fa-user text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Edit Profil</h2>
                            <p class="text-gray-500 font-medium">Perbarui data profil Anda</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('karang-taruna.pengaturan.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', auth()->user()->karangTaruna->nama_lengkap ?? auth()->user()->name) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                @error('nama_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Username</label>
                                <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                @error('username')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Email (harus @gmail.com)</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="nama@gmail.com">
                                @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">No. Telepon</label>
                                <input type="text" name="no_telp" value="{{ old('no_telp', auth()->user()->karangTaruna->no_telp) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white">
                                @error('no_telp')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-2xl font-semibold transition-all shadow-modern">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>

                <!-- Change Password Card -->
                <div class="glass-dark rounded-3xl shadow-modern border-modern p-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="flex items-center mb-8">
                        <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-pink-600 rounded-2xl flex items-center justify-center mr-4 shadow-soft">
                            <i class="fas fa-lock text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Ubah Password</h2>
                            <p class="text-gray-500 font-medium">Perbarui password untuk keamanan akun</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('karang-taruna.pengaturan.update') }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="change_password" value="1">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                            <input type="password" name="current_password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Masukkan password lama">
                            @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Masukkan password baru (min. 8 karakter)">
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all duration-200 bg-gray-50 focus:bg-white"
                                placeholder="Konfirmasi password baru">
                            @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-2xl font-semibold transition-all shadow-modern">
                            <i class="fas fa-key mr-2"></i>Ubah Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
