@extends('admin.layouts.app')

@section('title', 'Detail Karang Taruna - SisaKu')

@section('content')

<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-8 animate-fade-in-up">
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.karang-taruna.index') }}" class="p-3 hover:bg-gray-100 rounded-2xl transition-colors">
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-4xl font-bold text-gray-900">{{ $karangTaruna->nama_karang_taruna }}</h1>
            <p class="text-gray-500 font-medium">Detail informasi dan statistik</p>
        </div>
    </div>
</div>

<!-- Info Cards -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    
    <!-- Profile Card -->
    <div class="glass-dark rounded-3xl p-5 shadow-modern border-modern card-hover animate-scale-in">
        <div class="flex items-center gap-3 mb-3 pb-2 border-b border-gray-200">
            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center text-white text-lg font-bold shadow-lg">
                {{ $karangTaruna->rw }}
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">RW {{ $karangTaruna->rw }}</h3>
                <p class="text-xs text-gray-500">{{ $karangTaruna->nama_karang_taruna }}</p>
            </div>
        </div>

        <div class="space-y-2">
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Nama Lengkap</p>
                <p class="text-sm font-medium text-gray-900">{{ $karangTaruna->nama_lengkap ?: '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">No. Telepon</p>
                <p class="text-sm font-medium text-gray-900">{{ $karangTaruna->no_telp ?: '-' }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Status</p>
                @if($karangTaruna->status == 'aktif')
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                    <i class="fas fa-check-circle mr-1"></i> Aktif
                </span>
                @else
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">
                    <i class="fas fa-times-circle mr-1"></i> Nonaktif
                </span>
                @endif
            </div>
        </div>
    </div>

    <!-- User Account Card -->
    <div class="glass-dark rounded-3xl p-5 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.05s;">
        <div class="flex items-center gap-3 mb-3 pb-2 border-b border-gray-200">
            <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center shadow-soft">
                <i class="fas fa-user text-green-600 text-sm"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-gray-900">Data Akun</h3>
                <p class="text-xs text-gray-500">Informasi login</p>
            </div>
        </div>

        <div class="space-y-2">
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Nama Lengkap</p>
                <p class="text-sm font-medium text-gray-900">{{ $karangTaruna->user->name }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Username</p>
                <p class="text-sm font-medium text-gray-900">{{ $karangTaruna->user->username }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Email</p>
                <p class="text-sm font-medium text-gray-900">{{ $karangTaruna->user->email }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="space-y-2">
        <div class="glass-dark rounded-3xl p-4 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
            <div class="flex items-start justify-between mb-1">
                <div class="w-9 h-9 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center shadow-soft">
                    <i class="fas fa-users text-green-600 text-xs"></i>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Total Warga</p>
            <p class="text-xl font-bold text-gray-900">{{ $stats['total_warga'] }}</p>
            <p class="text-xs text-green-600 mt-0.5 font-medium">Terdaftar</p>
        </div>

        <div class="glass-dark rounded-3xl p-4 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.15s;">
            <div class="flex items-start justify-between mb-1">
                <div class="w-9 h-9 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center shadow-soft">
                    <i class="fas fa-trash-alt text-green-600 text-xs"></i>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Total Sampah</p>
            <p class="text-xl font-bold text-green-600">{{ number_format($stats['total_sampah'], 0) }} kg</p>
            <p class="text-xs text-gray-500 mt-0.5">Terkumpul</p>
        </div>
    </div>
</div>

<!-- Financial Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="glass-dark rounded-3xl p-4 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.2s;">
        <div class="flex items-start justify-between mb-1">
            <div class="w-9 h-9 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center shadow-soft">
                <i class="fas fa-money-bill-wave text-green-600 text-xs"></i>
            </div>
        </div>
        <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Total Penjualan</p>
        <p class="text-base font-bold text-gray-900">Rp {{ number_format($stats['total_penjualan'], 0, ',', '.') }}</p>
        <p class="text-xs text-gray-500 mt-0.5">Sampah terjual</p>
    </div>

    <div class="glass-dark rounded-3xl p-4 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.25s;">
        <div class="flex items-start justify-between mb-1">
            <div class="w-9 h-9 bg-gradient-to-br from-green-100 to-emerald-100 rounded-xl flex items-center justify-center shadow-soft">
                <i class="fas fa-arrow-trend-up text-green-600 text-xs"></i>
            </div>
        </div>
        <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Kas Masuk</p>
        <p class="text-base font-bold text-green-600">Rp {{ number_format($stats['kas_masuk'], 0, ',', '.') }}</p>
        <p class="text-xs text-green-600 mt-0.5 font-medium">Pemasukan</p>
    </div>

    <div class="glass-dark rounded-3xl p-4 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.3s;">
        <div class="flex items-start justify-between mb-1">
            <div class="w-9 h-9 bg-gradient-to-br from-red-100 to-orange-100 rounded-xl flex items-center justify-center shadow-soft">
                <i class="fas fa-arrow-trend-down text-red-600 text-xs"></i>
            </div>
        </div>
        <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Kas Keluar</p>
        <p class="text-base font-bold text-red-600">Rp {{ number_format($stats['kas_keluar'], 0, ',', '.') }}</p>
        <p class="text-xs text-red-600 mt-0.5 font-medium">Pengeluaran</p>
    </div>
</div>
</div>

@endsection
