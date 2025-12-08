@extends('karang-taruna.layouts.app')

@section('title', 'Dashboard Karang Taruna - SisaKu')

@section('content')

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-float { animation: float 3s ease-in-out infinite; }
    
    .gradient-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    
    .card-interactive {
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
    }

    .card-interactive:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
    }

    .card-interactive::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
        transition: left 0.6s;
    }

    .card-interactive:hover::before {
        left: 100%;
    }

    .header-accent {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.08) 100%);
        border: 1px solid rgba(16, 185, 129, 0.15);
        backdrop-filter: blur(10px);
    }

    .metric-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 600;
        color: #059669;
    }

    .icon-box {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-interactive:hover .icon-box {
        transform: scale(1.1) rotate(5deg);
    }

    .scrollbar-thin::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .scrollbar-thin::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb {
        background: rgba(34, 197, 94, 0.3);
        border-radius: 10px;
        transition: background 0.3s;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(34, 197, 94, 0.6);
    }

    .chart-container-responsive {
        position: relative;
        height: 250px;
        width: 100%;
    }

    @media (min-width: 640px) {
        .chart-container-responsive {
            height: 300px;
        }
    }

    .chart-pie-container-responsive {
        position: relative;
        height: 180px;
        width: 180px;
        margin: 0 auto;
    }

    @media (min-width: 640px) {
        .chart-pie-container-responsive {
            height: 220px;
            width: 220px;
        }
    }

    @media (min-width: 768px) {
        .chart-pie-container-responsive {
            height: 240px;
            width: 240px;
        }
    }

</style>

<div class="w-full">

<!-- Header with Modern Layout -->
<div class="mb-8 md:mb-12 animate-fade-in-up">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div class="flex-1">
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold mb-1">
                <span class="text-green-700">SisaKu</span> <span class="text-gray-900">Dashboard</span>
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 font-medium">Pantau performa bank sampah komunitas secara real-time</p>
        </div>
        <div class="px-3 sm:px-4 py-2 sm:py-2.5 rounded-full bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 text-xs font-semibold flex items-center gap-2 whitespace-nowrap">
            <div class="w-2 h-2 rounded-full bg-green-600 animate-pulse"></div>
            Aktif Sekarang
        </div>
    </div>

    <!-- Welcome Card - Modern -->
    <div class="relative group mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-green-400 via-emerald-400 to-green-500 rounded-3xl blur-2xl opacity-10 group-hover:opacity-15 transition-opacity duration-300"></div>
        
        <div class="relative glass-dark rounded-2xl md:rounded-3xl p-8 md:p-10 shadow-lg border border-white/10 overflow-hidden header-accent">
            <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-green-200 to-emerald-200 rounded-full blur-3xl opacity-5 -mr-40 -mt-40"></div>
            
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-8 relative z-10">
                <!-- Greeting Section with Illustration -->
                <div class="flex-1">
                    <div class="flex items-start gap-4 md:gap-6">
                        <!-- Illustration Image -->
                        <div class="flex w-20 h-20 md:w-24 md:h-24 flex-shrink-0">
                            <img src="{{ asset('storage/images/green.png') }}" alt="Dashboard Illustration" class="w-full h-full object-cover rounded-2xl shadow-lg">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-600 font-medium mb-1">{{ $greeting }}</p>
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                                {{ Auth::user()->karangTaruna ? Auth::user()->karangTaruna->nama_lengkap : Auth::user()->name ?? 'User' }} 👋
                            </h2>
                            <p class="text-base text-gray-700 leading-relaxed">{{ $message }}</p>
                        </div>
                    </div>
                </div>

                <!-- Anorganik Info Card -->
                <div class="w-full md:w-96 bg-gradient-to-br from-green-50/90 to-emerald-50/90 backdrop-blur-sm rounded-2xl p-6 border border-green-200/50 shadow-lg">
                    <h3 class="text-xl font-bold text-gray-900 mb-3 flex items-center gap-2">
                        <i class="fas fa-recycle text-green-600"></i>Sampah Anorganik
                    </h3>
                    
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Sampah anorganik adalah limbah yang tidak dapat terurai secara alami (plastik, logam, kaca, kertas). Jenis sampah ini memiliki nilai ekonomi tinggi dan dapat didaur ulang untuk produk baru.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics Section -->
<div class="mb-8 md:mb-12 animate-fade-in-up" style="animation-delay: 0.1s;">
    <div class="flex items-start gap-4 mb-8">
        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-tachometer-alt text-green-600 text-lg"></i>
        </div>
        <div class="flex-1">
            <div class="mb-2">
                <h2 class="text-xl md:text-2xl font-bold text-gray-900">Metrik Utama</h2>
            </div>
            <p class="text-xs sm:text-sm text-gray-600 font-medium">Performa operasional bank sampah</p>
            <p class="text-xs text-gray-500 mt-1">📅 {{ now()->format('d F Y') }}</p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full whitespace-nowrap">
            <i class="fas fa-calendar-day"></i> Hari Ini
        </span>
    </div>

    <!-- Today's Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
        <!-- Waste Collected Today -->
        <div class="card-interactive glass-dark rounded-3xl p-5 sm:p-6 shadow-lg border border-green-200/30 group animate-scale-in hover:border-green-300/50 transition-all" style="animation-delay: 0s;">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-700 tracking-wide mb-2">Sampah Terkumpul</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">{{ $stats['sampah_hari_ini'] ?? 0 }}<span class="text-base sm:text-lg text-gray-500 font-semibold"> kg</span></h3>
                    <p class="text-xs text-gray-600 mt-2 font-medium">Hari ini</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-recycle text-green-600 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="card-interactive glass-dark rounded-3xl p-5 sm:p-6 shadow-lg border border-green-200/30 group animate-scale-in hover:border-green-300/50 transition-all" style="animation-delay: 0.05s;">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-700 tracking-wide mb-2">Pemasukan</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Rp{{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0) }}</h3>
                    <p class="text-xs text-gray-600 mt-2 font-medium">Hari ini</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-wallet text-green-600 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today's Transactions -->
        <div class="card-interactive glass-dark rounded-3xl p-5 sm:p-6 shadow-lg border border-green-200/30 group animate-scale-in hover:border-green-300/50 transition-all" style="animation-delay: 0.1s;">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-700 tracking-wide mb-2">Transaksi</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">{{ $stats['transaksi_hari_ini'] ?? 0 }}<span class="text-base sm:text-lg text-gray-500 font-semibold"> proses</span></h3>
                    <p class="text-xs text-gray-600 mt-2 font-medium">Hari ini</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exchange-alt text-green-600 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Active Members -->
        <div class="card-interactive glass-dark rounded-3xl p-5 sm:p-6 shadow-lg border border-green-200/30 group animate-scale-in hover:border-green-300/50 transition-all" style="animation-delay: 0.15s;">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-700 tracking-wide mb-2">Anggota Aktif</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">{{ $totalWarga ?? 0 }}<span class="text-base sm:text-lg text-gray-500 font-semibold"> orang</span></h3>
                    <p class="text-xs text-gray-600 mt-2 font-medium">Terdaftar</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-users text-green-600 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Today's Expenses -->
        <div class="card-interactive glass-dark rounded-3xl p-5 sm:p-6 shadow-lg border border-red-200/30 group animate-scale-in hover:border-red-300/50 transition-all" style="animation-delay: 0.2s;">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-700 tracking-wide mb-2">Pengeluaran</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Rp{{ number_format($stats['pengeluaran_hari_ini'] ?? 0, 0) }}</h3>
                    <p class="text-xs text-gray-600 mt-2 font-medium">Hari ini</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-red-100 to-orange-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-arrow-down text-red-600 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="card-interactive glass-dark rounded-3xl p-5 sm:p-6 shadow-lg border border-emerald-200/30 group animate-scale-in hover:border-emerald-300/50 transition-all" style="animation-delay: 0.25s;">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-700 tracking-wide mb-2">Laba Bersih</p>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Rp{{ number_format(($stats['pendapatan_hari_ini'] ?? 0) - ($stats['pengeluaran_hari_ini'] ?? 0), 0) }}</h3>
                    <p class="text-xs text-gray-600 mt-2 font-medium">Hari ini</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-100 to-green-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-chart-line text-emerald-600 text-lg sm:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Environmental Impact Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 mb-10 md:mb-12">
        <!-- CO2 Impact Card -->
        <div class="card-interactive glass-dark rounded-3xl p-6 sm:p-8 shadow-lg border border-green-200/30 group overflow-hidden animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-green-200 to-emerald-200 rounded-full blur-3xl opacity-5 -mr-32 -mt-32"></div>
            
            <div class="relative">
                <div class="flex items-start gap-3 mb-6">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-leaf text-green-600 text-lg sm:text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Dampak Lingkungan</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Total CO₂e Berkurang</h3>
                    </div>
                    <div class="px-3 py-1.5 bg-green-100/80 text-green-700 text-xs font-bold rounded-full border border-green-200 whitespace-nowrap">
                        <i class="fas fa-check-circle mr-1"></i>Aktif
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-4 sm:p-6 border border-green-200/50 mb-4">
                    <p class="text-4xl sm:text-5xl font-bold text-green-600 mb-2 leading-tight">{{ number_format($totalCO2 ?? 0, 2) }}<span class="text-lg sm:text-2xl text-gray-600"> kg CO₂e</span></p>
                    <p class="text-sm sm:text-base text-gray-700 mb-4">Setara dengan <span class="font-bold text-green-600">{{ round(($totalCO2 ?? 0) / 21) }}</span> pohon yang ditanam</p>
                    <div class="w-full h-3 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-400 to-emerald-600 transition-all duration-500" style="width: {{ min(100, ($stats['co2_bulan_ini'] ?? 0) / 12) }}%;"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-3">Target bulan: <span class="font-semibold">1200 kg CO₂e</span> ({{ min(100, ($stats['co2_bulan_ini'] ?? 0) / 12) }}% tercapai)</p>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:gap-4">
                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-3 sm:p-4 border border-green-200/30 hover:border-green-300/50 transition-all">
                        <p class="text-xs text-gray-600 mb-2 font-medium">CO₂e Bulan Ini</p>
                        <p class="text-lg sm:text-xl font-bold text-green-600">{{ number_format($stats['co2_bulan_ini'] ?? 0, 2) }}<span class="text-xs text-gray-500"> kg</span></p>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm rounded-xl p-3 sm:p-4 border border-green-200/30 hover:border-green-300/50 transition-all">
                        <p class="text-xs text-gray-600 mb-2 font-medium">Total Sampah Tahun</p>
                        <p class="text-lg sm:text-xl font-bold text-emerald-600">{{ number_format($totalSampah ?? 0, 2) }}<span class="text-xs text-gray-500"> kg</span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Summary Card -->
        <div class="card-interactive glass-dark rounded-3xl p-6 sm:p-8 shadow-lg border border-green-200/30 group overflow-hidden animate-fade-in-up" style="animation-delay: 0.25s;">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-green-200 to-emerald-200 rounded-full blur-3xl opacity-5 -mr-32 -mt-32"></div>
            
            <div class="relative">
                <div class="flex items-start gap-3 mb-6">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-pie text-green-600 text-lg sm:text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm text-gray-600 font-medium">Ringkasan Bulanan</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Performa {{ now()->format('F Y') }}</h3>
                    </div>
                    <div class="px-3 py-1.5 bg-green-100/80 text-green-700 text-xs font-bold rounded-full border border-green-200 whitespace-nowrap">
                        <i class="fas fa-calendar mr-1"></i>Bulan Ini
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-100 to-green-100 flex items-center justify-center text-green-600">
                                <i class="fas fa-weight"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Total Sampah</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-xl font-bold text-green-600">{{ number_format($stats['sampah_bulan_ini'] ?? 0, 2) }} kg</p>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-100 to-green-100 flex items-center justify-center text-green-600">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Total Pendapatan</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-xl font-bold text-green-600">Rp {{ number_format($stats['pendapatan_bulan_ini'] ?? 0, 0) }}</p>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-green-100 to-green-100 flex items-center justify-center text-green-600">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Total Transaksi</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-xl font-bold text-green-600">{{ $stats['transaksi_bulan_ini'] ?? 0 }}</p>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-red-50 to-orange-100 rounded-xl border border-red-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-red-100 to-orange-100 flex items-center justify-center text-red-600">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Total Pengeluaran</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-xl font-bold text-red-600">Rp {{ number_format($stats['pengeluaran_bulan_ini'] ?? 0, 0) }}</p>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl border border-emerald-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-emerald-100 to-green-100 flex items-center justify-center text-emerald-600">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Laba Bersih</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-xl font-bold text-emerald-600">Rp {{ number_format(($stats['pendapatan_bulan_ini'] ?? 0) - ($stats['pengeluaran_bulan_ini'] ?? 0), 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts Section -->
<div class="mb-8 md:mb-12 animate-fade-in-up" style="animation-delay: 0.3s;">
    <div class="flex items-start gap-4 mb-8">
        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center flex-shrink-0">
            <i class="fas fa-chart-line text-green-600 text-lg"></i>
        </div>
        <div class="flex-1">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900">Analisis Data</h2>
            <p class="text-xs sm:text-sm text-gray-600 font-medium mt-1">Visualisasi tren dan komposisi sampah</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
        <!-- Trend Chart -->
        <div class="glass-dark rounded-3xl p-6 sm:p-8 shadow-lg border border-green-200/30 overflow-hidden group animate-fade-in-up" style="animation-delay: 0.35s;">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium mb-2">Tren 6 Bulan Terakhir</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Pengumpulan Bulanan</h3>
                    </div>
                    <div class="px-3 py-1.5 bg-green-100/80 text-green-700 text-xs font-bold rounded-full border border-green-200 whitespace-nowrap">
                        <i class="fas fa-chart-line mr-1"></i>Real-time
                    </div>
                </div>

                @if(!empty($sampahTrend) && count($sampahTrend) > 0)
                    <div class="chart-container-responsive mb-6">
                        <canvas id="sampahTrendChart"></canvas>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                        <div class="p-4 rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200/50 hover:border-green-300/70 transition-all">
                            <p class="text-xs font-bold text-gray-600 mb-1 uppercase tracking-widest">Total Terkumpul</p>
                            <p class="text-2xl sm:text-3xl font-bold text-green-600 leading-tight">{{ number_format(array_sum($sampahTrend), 1) }}<span class="text-sm text-gray-500"> kg</span></p>
                            <p class="text-xs text-gray-500 mt-2">6 bulan terakhir</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-green-50 border border-emerald-200/50 hover:border-emerald-300/70 transition-all">
                            <p class="text-xs font-bold text-gray-600 mb-1 uppercase tracking-widest">Rata-rata</p>
                            <p class="text-2xl sm:text-3xl font-bold text-emerald-600 leading-tight">{{ number_format(array_sum($sampahTrend) / count($sampahTrend), 1) }}<span class="text-sm text-gray-500"> kg</span></p>
                            <p class="text-xs text-gray-500 mt-2">per bulan</p>
                        </div>
                    </div>
                @else
                    <div class="h-80 flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <i class="fas fa-inbox text-5xl mb-3 opacity-50"></i>
                            <p class="text-sm">Belum ada data 6 bulan terakhir</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="glass-dark rounded-3xl p-6 sm:p-8 shadow-lg border border-green-200/30 overflow-hidden group animate-fade-in-up" style="animation-delay: 0.4s;">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-600 font-medium mb-2">Komposisi Sampah</p>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Distribusi per Kategori</h3>
                    </div>
                    <div class="px-3 py-1.5 bg-green-100/80 text-green-700 text-xs font-bold rounded-full border border-green-200 whitespace-nowrap">
                        <i class="fas fa-chart-pie mr-1"></i>{{ count($sampahByKategori ?? []) }} Tipe
                    </div>
                </div>

                @if(!empty($sampahByKategori) && count($sampahByKategori) > 0)
                    <div class="flex flex-col items-center mb-6">
                        <div class="chart-pie-container-responsive">
                            <canvas id="sampahPieChart"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="bg-white/95 backdrop-blur-sm rounded-full p-3 sm:p-4 flex flex-col items-center justify-center">
                                    <div class="text-xl sm:text-2xl font-bold text-green-600 leading-tight">{{ number_format(array_sum(array_column($sampahByKategori, 'total_kg')), 1) }}</div>
                                    <div class="text-xs text-gray-500 font-medium">kg Total</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 max-h-48 sm:max-h-56 overflow-y-auto scrollbar-thin" id="pieChartLegend"></div>
                @else
                    <div class="h-80 flex items-center justify-center text-gray-400">
                        <div class="text-center">
                            <i class="fas fa-inbox text-5xl mb-3 opacity-50"></i>
                            <p class="text-sm">Belum ada data komposisi</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions Enhanced -->
@if(isset($recentTransactions) && $recentTransactions->count() > 0)
<div class="mb-8 animate-fade-in-up" style="animation-delay: 0.25s;">
    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 mb-6">
        <div class="flex items-center gap-3 flex-1">
            <i class="fas fa-history text-green-600 text-lg sm:text-xl"></i>
            <div>
                <h2 class="text-lg sm:text-xl md:text-2xl font-bold text-gray-900">Aktivitas Terbaru</h2>
                <p class="text-xs sm:text-sm text-gray-600 mt-0.5">{{ $recentTransactions->count() }} transaksi hari ini</p>
            </div>
        </div>
        <a href="{{ route('karang-taruna.transaksi.index') }}" class="px-4 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white text-xs font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center gap-2 whitespace-nowrap">
            <i class="fas fa-arrow-right"></i>
            Lihat Semua
        </a>
    </div>

    <div class="glass-dark rounded-3xl overflow-hidden shadow-lg border border-green-200/30 animate-fade-in-up" style="animation-delay: 0.45s;">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-green-200/30">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-700 tracking-wider">Warga</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-700 tracking-wider hidden sm:table-cell">Kategori</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-700 tracking-wider">Berat</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-700 tracking-wider hidden md:table-cell">Total Harga</th>
                        <th class="px-4 sm:px-6 py-3 sm:py-4 text-left text-xs font-bold text-gray-700 tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-green-200/20">
                    @foreach($recentTransactions->take(8) as $transaksi)
                    @if($transaksi->warga && $transaksi->items->count() > 0)
                        @foreach($transaksi->items as $item)
                        <tr class="hover:bg-gradient-to-r hover:from-green-50/50 hover:to-emerald-50/50 transition-all duration-300 group">
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg gradient-primary flex items-center justify-center text-white font-bold text-xs sm:text-sm shadow-lg transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                        {{ substr($transaksi->warga->nama ?? '', 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs sm:text-sm font-bold text-gray-900 truncate">{{ $transaksi->warga->nama ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $transaksi->warga->nomor_identitas ?? 'ID' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 hidden sm:table-cell">
                                <span class="px-2 sm:px-3 py-1 sm:py-1.5 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                                    {{ $item->kategoriSampah->nama_kategori ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                <p class="text-xs sm:text-sm font-bold text-gray-900">{{ number_format($item->berat_kg, 2) }}<span class="text-xs text-gray-500 font-medium"> kg</span></p>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4 hidden md:table-cell">
                                <p class="text-xs sm:text-sm font-bold text-green-600">Rp {{ number_format($item->total_harga ?? 0, 0) }}</p>
                            </td>
                            <td class="px-4 sm:px-6 py-3 sm:py-4">
                                @php
                                    $status_label = $transaksi->status_penjualan === 'sudah_terjual' ? 'Terjual' : 'Belum Terjual';
                                    $status_color = $transaksi->status_penjualan === 'sudah_terjual' ? 'green' : 'amber';
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 bg-{{ $status_color }}-100 text-{{ $status_color }}-700 text-xs font-semibold rounded-full">
                                    @if($transaksi->status_penjualan === 'sudah_terjual')
                                        <i class="fas fa-check-circle mr-1"></i>
                                    @else
                                        <i class="fas fa-hourglass-half mr-1"></i>
                                    @endif
                                    {{ $status_label }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="mb-8 animate-fade-in-up" style="animation-delay: 0.45s;">
    <div class="glass-dark rounded-3xl p-8 sm:p-12 text-center shadow-lg border border-green-200/30">
        <div class="mb-4">
            <i class="fas fa-inbox text-5xl sm:text-6xl text-gray-300 mb-4"></i>
        </div>
        <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">Belum ada transaksi hari ini</h3>
        <p class="text-sm sm:text-base text-gray-600 mb-6">Mulai dengan membuat transaksi pertama untuk melihat analisis data.</p>
        <a href="{{ route('karang-taruna.transaksi.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white text-sm font-bold rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300">
            <i class="fas fa-plus mr-2"></i>Buat Transaksi Pertama
        </a>
    </div>
</div>
@endif

</div>

@endsection

@push('scripts')
u <script>
const chartConfig = {
    tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.95)', titleColor: '#ffffff', bodyColor: '#ffffff', borderColor: 'rgba(255, 255, 255, 0.2)', cornerRadius: 16, padding: 12, displayColors: false },
    animation: { duration: 1500, easing: 'easeInOutCubic' }
};

if (document.getElementById('sampahTrendChart')) {
    const data = @json($sampahTrend ?? []);
    
    if (data && Object.keys(data).length > 0) {
        const ctx = document.getElementById('sampahTrendChart').getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 280);
        gradient.addColorStop(0, 'rgba(34, 197, 94, 0.4)');
        gradient.addColorStop(0.5, 'rgba(34, 197, 94, 0.15)');
        gradient.addColorStop(1, 'rgba(34, 197, 94, 0)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: Object.keys(data),
                datasets: [{
                    data: Object.values(data),
                    borderColor: '#16a34a',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.45,
                    pointRadius: 5,
                    pointHoverRadius: 10,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: chartConfig.animation,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        ...chartConfig.tooltip,
                        callbacks: {
                            title: (c) => c[0].label + ' 2024',
                            label: (c) => c.parsed.y.toLocaleString('id-ID') + ' kg'
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6b7280' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.06)' },
                        ticks: {
                            color: '#9ca3af',
                            callback: (v) => v >= 1000 ? (v / 1000).toFixed(1) + 'K' : v
                        }
                    }
                }
            }
        });
    }
}

if (document.getElementById('sampahPieChart')) {
    const pieData = @json($sampahByKategori ?? []);
    
    if (pieData && Array.isArray(pieData) && pieData.length > 0) {
        const ctx = document.getElementById('sampahPieChart').getContext('2d');
        const totalKg = pieData.reduce((s, i) => s + (i.total_kg || 0), 0);
        const colors = ['#16A34A', '#15803D', '#166534', '#10B981', '#059669', '#047857', '#065F46', '#34D399', '#6EE7B7', '#A7F3D0'];
        
        const chartData = pieData.map((item, i) => ({
            ...item,
            percentage: totalKg > 0 ? ((item.total_kg / totalKg) * 100).toFixed(1) : 0,
            color: colors[i % colors.length]
        }));
        
        const gradients = chartData.map((item) => {
            const g = ctx.createLinearGradient(0, 0, 256, 256);
            g.addColorStop(0, item.color);
            g.addColorStop(1, item.color + '66');
            return g;
        });
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: chartData.map(i => i.nama_kategori),
                datasets: [{
                    data: chartData.map(i => i.total_kg),
                    backgroundColor: gradients,
                    borderColor: '#ffffff',
                    borderWidth: 3,
                    borderRadius: 12
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                animation: chartConfig.animation,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        ...chartConfig.tooltip,
                        callbacks: {
                            label: (c) => {
                                const i = chartData[c.dataIndex];
                                return i.total_kg.toLocaleString('id-ID') + ' kg • ' + i.percentage + '%';
                            }
                        }
                    }
                }
            }
        });

        const legendContainer = document.getElementById('pieChartLegend');
        if (legendContainer) {
            chartData.forEach((item) => {
                const div = document.createElement('div');
                div.className = 'flex items-center justify-between px-4 py-3 rounded-2xl bg-gradient-to-r from-gray-50/50 to-gray-100/30 hover:from-gray-100/50 hover:to-gray-200/30 transition-all cursor-pointer border border-gray-100/50';
                div.innerHTML = `<div class="flex items-center gap-3"><div class="w-3 h-3 rounded-full shadow-md" style="background: linear-gradient(135deg, ${item.color}, ${item.color}66)"></div><span class="text-sm font-semibold text-gray-900">${item.nama_kategori}</span></div><div class="text-right"><div class="text-sm font-bold text-green-600">${item.percentage}%</div><div class="text-xs text-gray-500">${item.total_kg.toLocaleString('id-ID')} kg</div></div>`;
                legendContainer.appendChild(div);
            });
        }
    }
}
</script>
@endpush
