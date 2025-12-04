@extends('karang-taruna.layouts.app')

@section('title', 'Dashboard Karang Taruna - SisaKu')

@section('content')

<style>
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    @keyframes pulse-glow {
        0%, 100% { box-shadow: 0 0 20px rgba(16, 185, 129, 0.3); }
        50% { box-shadow: 0 0 30px rgba(16, 185, 129, 0.5); }
    }

    @keyframes bounce-soft {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    @keyframes shimmer {
        0% { background-position: -1000px 0; }
        100% { background-position: 1000px 0; }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-slide-in-right { animation: slideInRight 0.5s ease-out forwards; }
    .animate-slide-in-left { animation: slideInLeft 0.5s ease-out forwards; }
    .animate-pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
    .animate-bounce-soft { animation: bounce-soft 2s ease-in-out infinite; }
    .animate-float { animation: float 3s ease-in-out infinite; }
    
    .gradient-primary { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .gradient-accent { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
    .gradient-warning { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .gradient-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    .gradient-purple { background: linear-gradient(135deg, #a855f7 0%, #9333ea 100%); }
    .gradient-pink { background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); }
    .gradient-cyan { background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%); }
    
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

    .stat-value {
        position: relative;
        display: inline-block;
    }

    .header-accent {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(59, 130, 246, 0.08) 100%);
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

    .progress-ring {
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }

    .progress-ring-circle {
        transition: stroke-dashoffset 0.5s ease-out;
        stroke-dasharray: 345.575;
        stroke-dashoffset: 0;
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
        background: rgba(168, 85, 247, 0.3);
        border-radius: 10px;
        transition: background 0.3s;
    }

    .scrollbar-thin::-webkit-scrollbar-thumb:hover {
        background: rgba(168, 85, 247, 0.6);
    }

    .chart-container-responsive {
        position: relative;
        height: 300px;
    }

    .chart-pie-container-responsive {
        position: relative;
        height: 200px;
        width: 200px;
        margin: 0 auto;
    }

    @media (min-width: 768px) {
        .chart-pie-container-responsive {
            height: 220px;
            width: 220px;
        }
    }

    .stat-card {
        background: linear-gradient(to bottom right, rgba(34, 197, 94, 0.08), rgba(34, 197, 94, 0.08));
        border-radius: 0.75rem;
        padding: 0.75rem;
        border: 1px solid rgba(34, 197, 94, 0.3);
        transition: all 0.3s;
    }

    .stat-card:hover {
        border-color: rgba(34, 197, 94, 0.5);
    }

    @media (min-width: 768px) {
        .stat-card {
            border-radius: 1rem;
            padding: 1rem;
        }
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

<!-- Header with Modern Layout -->
<div class="mb-8 md:mb-12 animate-fade-in-up">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-1">
                SisaKu Dashboard
            </h1>
            <p class="text-base text-gray-600 font-medium flex items-center gap-2">
                <i class="fas fa-chart-line text-green-500"></i>
                Pantau performa bank sampah komunitas secara real-time
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-4 py-2.5 rounded-full bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 text-xs font-semibold flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                Aktif Sekarang
            </div>
            <div class="text-right text-sm">
                <p class="text-gray-500 text-xs mb-1">Waktu Update</p>
                <p class="font-bold text-gray-900" id="currentTime">--:--</p>
            </div>
        </div>
    </div>

    <!-- Welcome Card - Modern -->
    <div class="relative group mb-8">
        <div class="absolute inset-0 bg-gradient-to-r from-green-400 via-blue-400 to-cyan-400 rounded-3xl blur-2xl opacity-10 group-hover:opacity-15 transition-opacity duration-300"></div>
        
        <div class="relative glass-dark rounded-2xl md:rounded-3xl p-8 md:p-10 shadow-lg border border-white/10 overflow-hidden header-accent">
            <div class="absolute top-0 right-0 w-80 h-80 bg-gradient-to-br from-green-200 to-blue-200 rounded-full blur-3xl opacity-5 -mr-40 -mt-40"></div>
            
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-8 relative z-10">
                <!-- Greeting Section -->
                <div class="flex-1">
                    <div class="flex items-start gap-4 md:gap-6">
                        <div class="w-16 h-16 md:w-20 md:h-20 bg-gradient-to-br from-green-400 to-emerald-500 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0 animate-float">
                            <i class="fas fa-chart-line text-white text-2xl md:text-3xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-600 font-medium mb-1">{{ $greeting }}</p>
                            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                                {{ Auth::user()->name ?? 'User' }} 👋
                            </h2>
                            <p class="text-base text-gray-700 leading-relaxed">{{ $message }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats Sidebar -->
                <div class="grid grid-cols-2 md:flex md:flex-col gap-4 md:gap-4 w-full md:w-auto">
                    <div class="md:text-right bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <p class="text-xs text-gray-600 mb-2 font-medium">Sampah Hari Ini</p>
                        <p class="text-2xl md:text-3xl font-bold text-green-600">{{ $stats['sampah_hari_ini'] ?? 0 }}<span class="text-sm text-gray-500"> kg</span></p>
                    </div>
                    <div class="md:text-right bg-white/50 backdrop-blur-sm rounded-xl p-4 border border-white/20">
                        <p class="text-xs text-gray-600 mb-2 font-medium">Pemasukan Hari Ini</p>
                        <p class="text-2xl md:text-3xl font-bold text-blue-600">Rp {{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Key Metrics Section -->
<div class="mb-8 md:mb-12 animate-fade-in-up" style="animation-delay: 0.1s;">
    <div class="flex items-center gap-3 mb-8">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-2">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-3">
                    <div class="w-2 h-8 bg-gradient-to-b from-green-500 to-cyan-500 rounded-full"></div>
                    Metrik Utama
                </h2>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                    <i class="fas fa-calendar-day"></i> HARI INI
                </span>
            </div>
            <p class="text-gray-600 mt-2">📅 {{ now()->format('d F Y') }} - Performa operasional bank sampah hari ini</p>
        </div>
    </div>

    <!-- Today's Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <!-- Waste Collected Today -->
        <div class="card-interactive glass-dark rounded-2xl p-6 shadow-lg border border-white/10 group animate-scale-in" style="animation-delay: 0s;">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs text-green-600 font-bold uppercase tracking-wider mb-1">Hari Ini</p>
                    <p class="text-sm text-gray-600 font-medium mb-1">Sampah Terkumpul</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $stats['sampah_hari_ini'] ?? 0 }}<span class="text-lg text-gray-500"> kg</span></h3>
                </div>
                <div class="icon-box gradient-primary">
                    <i class="fas fa-recycle text-white"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-200/30">
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-green-600 bg-green-100 px-2.5 py-1 rounded-full">
                    <i class="fas fa-arrow-up"></i> Aktif
                </span>
                <span class="text-xs text-gray-600">Target: 50 kg</span>
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="card-interactive glass-dark rounded-2xl p-6 shadow-lg border border-white/10 group animate-scale-in" style="animation-delay: 0.05s;">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs text-blue-600 font-bold uppercase tracking-wider mb-1">Hari Ini</p>
                    <p class="text-sm text-gray-600 font-medium mb-1">Pemasukan</p>
                    <h3 class="text-4xl font-bold text-gray-900">Rp{{ number_format($stats['pendapatan_hari_ini'] ?? 0, 0) }}</h3>
                </div>
                <div class="icon-box gradient-accent">
                    <i class="fas fa-coins text-white"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-200/30">
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-blue-600 bg-blue-100 px-2.5 py-1 rounded-full">
                    <i class="fas fa-chart-line"></i> Naik
                </span>
                <span class="text-xs text-gray-600">+12% dari kemarin</span>
            </div>
        </div>

        <!-- Today's Transactions -->
        <div class="card-interactive glass-dark rounded-2xl p-6 shadow-lg border border-white/10 group animate-scale-in" style="animation-delay: 0.1s;">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-xs text-amber-600 font-bold uppercase tracking-wider mb-1">Hari Ini</p>
                    <p class="text-sm text-gray-600 font-medium mb-1">Transaksi</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $stats['transaksi_hari_ini'] ?? 0 }}<span class="text-lg text-gray-500"> proses</span></h3>
                </div>
                <div class="icon-box gradient-warning">
                    <i class="fas fa-exchange-alt text-white"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-200/30">
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-amber-600 bg-amber-100 px-2.5 py-1 rounded-full">
                    <i class="fas fa-bolt"></i> Sedang
                </span>
                <span class="text-xs text-gray-600">Rata-rata 5/hari</span>
            </div>
        </div>

        <!-- Active Members -->
        <div class="card-interactive glass-dark rounded-2xl p-6 shadow-lg border border-white/10 group animate-scale-in" style="animation-delay: 0.15s;">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 font-medium mb-1">Anggota Aktif</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $totalWarga ?? 0 }}<span class="text-lg text-gray-500"> orang</span></h3>
                </div>
                <div class="icon-box gradient-purple">
                    <i class="fas fa-users text-white"></i>
                </div>
            </div>
            <div class="flex items-center gap-2 pt-4 border-t border-gray-200/30">
                <span class="inline-flex items-center gap-1 text-xs font-semibold text-purple-600 bg-purple-100 px-2.5 py-1 rounded-full">
                    <i class="fas fa-user-check"></i> Terdaftar
                </span>
                <span class="text-xs text-gray-600">100% partisipasi</span>
            </div>
        </div>
    </div>

    <!-- Environmental Impact Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- CO2 Impact Card -->
        <div class="card-interactive glass-dark rounded-2xl p-8 shadow-lg border border-white/10 group overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-green-200 to-emerald-200 rounded-full blur-3xl opacity-5 -mr-32 -mt-32"></div>
            
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-2">Dampak Lingkungan</p>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-leaf text-green-500 text-2xl"></i>
                            Total CO₂e Berkurang
                        </h3>
                    </div>
                    <div class="px-3 py-1.5 bg-green-100/80 text-green-700 text-xs font-bold rounded-lg border border-green-200">
                        <i class="fas fa-check-circle mr-1"></i>Aktif
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200/50">
                    <p class="text-5xl font-bold text-green-600 mb-2">{{ number_format($totalCO2 ?? 0, 2) }}<span class="text-2xl text-gray-600"> kg CO₂e</span></p>
                    <p class="text-gray-700 text-sm mb-4">Setara dengan {{ round(($totalCO2 ?? 0) / 21) }} pohon yang ditanam<span class="text-xs text-gray-500"> (@ 21 kg CO₂e/pohon/tahun)</span></p>
                    <div class="w-full h-2.5 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-green-400 to-emerald-600" style="width: {{ min(100, ($stats['co2_bulan_ini'] ?? 0) / 12) }}%;"></div>
                    </div>
                    <p class="text-xs text-gray-600 mt-3">Target bulan: 1200 kg CO₂e ({{ min(100, ($stats['co2_bulan_ini'] ?? 0) / 12) }}% tercapai)</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mt-6">
                    <div class="bg-white/50 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                        <p class="text-xs text-gray-600 mb-1">CO₂e Bulan Ini</p>
                        <p class="text-xl font-bold text-green-600">{{ number_format($stats['co2_bulan_ini'] ?? 0, 2) }} kg CO₂e</p>
                    </div>
                    <div class="bg-white/50 backdrop-blur-sm rounded-lg p-3 border border-white/20">
                        <p class="text-xs text-gray-600 mb-1">Total Sampah Tahun Ini</p>
                        <p class="text-xl font-bold text-emerald-600">{{ number_format($totalSampah ?? 0, 2) }} kg</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Summary Card -->
        <div class="card-interactive glass-dark rounded-2xl p-8 shadow-lg border border-white/10 group overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-200 to-cyan-200 rounded-full blur-3xl opacity-5 -mr-32 -mt-32"></div>
            
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <p class="text-sm text-gray-600 font-medium mb-2">Ringkasan Bulanan</p>
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <i class="fas fa-chart-pie text-blue-500 text-2xl"></i>
                            Performa {{ now()->format('F Y') }}
                        </h3>
                    </div>
                    <div class="px-3 py-1.5 bg-blue-100/80 text-blue-700 text-xs font-bold rounded-lg border border-blue-200">
                        <i class="fas fa-calendar mr-1"></i>Bulan Ini
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-500 flex items-center justify-center text-white">
                                <i class="fas fa-weight"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Total Sampah</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-blue-600">{{ number_format($stats['sampah_bulan_ini'] ?? 0, 2) }} kg</p>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-500 flex items-center justify-center text-white">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Total Pendapatan</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-green-600">Rp {{ number_format($stats['pendapatan_bulan_ini'] ?? 0, 0) }}</p>
                    </div>

                    <div class="flex items-center justify-between p-4 bg-gradient-to-r from-amber-50 to-amber-100 rounded-xl border border-amber-200/50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-amber-500 flex items-center justify-center text-white">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Total Transaksi</p>
                                <p class="text-xs text-gray-600">Bulan ini</p>
                            </div>
                        </div>
                        <p class="text-2xl font-bold text-amber-600">{{ $stats['transaksi_bulan_ini'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts Section -->
<div class="mb-8 md:mb-12 animate-fade-in-up" style="animation-delay: 0.2s;">
    <div class="flex items-center gap-3 mb-8">
        <div class="flex-1">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900 flex items-center gap-3">
                <div class="w-2 h-8 bg-gradient-to-b from-green-500 to-emerald-500 rounded-full"></div>
                Analisis Data
            </h2>
            <p class="text-gray-600 mt-2">Visualisasi tren dan komposisi sampah</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Trend Chart -->
        <div class="glass-dark rounded-2xl p-6 shadow-lg border border-white/10 overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-emerald-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-3 h-3 rounded-full bg-gradient-to-r from-green-500 to-emerald-500"></div>
                            <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Tren 6 Bulan</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Pengumpulan Bulanan</h3>
                    </div>
                    <div class="px-3 py-1.5 bg-green-100/80 text-green-700 text-xs font-bold rounded-lg">
                        <i class="fas fa-chart-line mr-1"></i>Real-time
                    </div>
                </div>

                @if(!empty($sampahTrend) && count($sampahTrend) > 0)
                    <div style="position: relative; height: 300px; margin-bottom: 1.5rem;">
                        <canvas id="sampahTrendChart"></canvas>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-gradient-to-br from-green-50 to-emerald-50 border border-green-200/50">
                            <p class="text-xs font-bold text-gray-600 mb-1 uppercase tracking-widest">Total Terkumpul</p>
                            <p class="text-2xl font-bold text-green-600">{{ number_format(array_sum($sampahTrend), 1) }}<span class="text-sm text-gray-500"> kg</span></p>
                            <p class="text-xs text-gray-500 mt-1">6 bulan</p>
                        </div>
                        <div class="p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-green-50 border border-emerald-200/50">
                            <p class="text-xs font-bold text-gray-600 mb-1 uppercase tracking-widest">Rata-rata</p>
                            <p class="text-2xl font-bold text-emerald-600">{{ number_format(array_sum($sampahTrend) / count($sampahTrend), 1) }}<span class="text-sm text-gray-500"> kg</span></p>
                            <p class="text-xs text-gray-500 mt-1">per bulan</p>
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
        <div class="glass-dark rounded-2xl p-6 shadow-lg border border-white/10 overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-green-500/5 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            
            <div class="relative">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-3 h-3 rounded-full bg-gradient-to-r from-emerald-500 to-green-500"></div>
                            <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">Komposisi</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Distribusi Sampah</h3>
                    </div>
                    <div class="px-3 py-1.5 bg-emerald-100/80 text-emerald-700 text-xs font-bold rounded-lg">
                        <i class="fas fa-chart-pie mr-1"></i>{{ count($sampahByKategori ?? []) }} Tipe
                    </div>
                </div>

                @if(!empty($sampahByKategori) && count($sampahByKategori) > 0)
                    <div class="flex flex-col items-center mb-6">
                        <div style="position: relative; height: 200px; width: 200px;">
                            <canvas id="sampahPieChart"></canvas>
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                <div class="bg-white/95 backdrop-blur-sm rounded-full p-4 flex flex-col items-center justify-center">
                                    <div class="text-2xl font-bold text-green-600">{{ number_format(array_sum(array_column($sampahByKategori, 'total_kg')), 1) }}</div>
                                    <div class="text-xs text-gray-500 font-medium">kg Total</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2 max-h-48 overflow-y-auto scrollbar-thin" id="pieChartLegend"></div>
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
    <div class="flex items-center gap-3 mb-6">
        <i class="fas fa-history text-amber-500 text-xl"></i>
        <div class="flex-1">
            <h2 class="text-xl md:text-2xl font-bold text-gray-900">Aktivitas Terbaru</h2>
            <p class="text-sm text-gray-600 mt-1">{{ $recentTransactions->count() }} transaksi hari ini</p>
        </div>
        <a href="{{ route('karang-taruna.transaksi.index') }}" class="px-4 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
            <i class="fas fa-arrow-right"></i>
            Lihat Semua
        </a>
    </div>

    <div class="glass-dark rounded-xl overflow-hidden shadow-modern border-modern">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Warga</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Berat</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Status Penjualan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50">
                    @foreach($recentTransactions->take(8) as $transaksi)
                    @if($transaksi->warga && $transaksi->items->count() > 0)
                        @foreach($transaksi->items as $item)
                        <tr class="hover:bg-gradient-to-r hover:from-green-50 hover:to-blue-50 transition-all duration-300 group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg gradient-primary flex items-center justify-center text-white font-bold text-sm shadow-lg transform group-hover:scale-110 transition-transform duration-300">
                                        {{ substr($transaksi->warga->nama ?? '', 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $transaksi->warga->nama ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $transaksi->warga->nomor_identitas ?? 'ID' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">
                                    {{ $item->kategoriSampah->nama_kategori ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-900">{{ number_format($item->berat_kg, 2) }}<span class="text-xs text-gray-500 font-medium"> kg</span></p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-green-600">Rp {{ number_format($item->total_harga ?? 0, 0) }}</p>
                            </td>
                            <td class="px-6 py-4">
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
<div class="mb-8 animate-fade-in-up" style="animation-delay: 0.25s;">
    <div class="glass-dark rounded-xl p-12 text-center shadow-modern border-modern">
        <div class="mb-4">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
        </div>
        <h3 class="text-lg font-bold text-gray-900 mb-2">Belum ada transaksi hari ini</h3>
        <p class="text-gray-600 mb-6">Mulai dengan membuat transaksi pertama untuk melihat analisis data.</p>
        <a href="{{ route('karang-taruna.transaksi.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white text-sm font-bold rounded-lg hover:shadow-lg transform hover:scale-105 transition-all duration-300">
            <i class="fas fa-plus mr-2"></i>Buat Transaksi Pertama
        </a>
    </div>
</div>
@endif

</div>
</div>

@endsection

@push('scripts')
<script>
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
