@extends('admin.layouts.app')
@section('title', 'Dashboard - SisaKu')
@section('content')

<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-6 sm:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4">
        <div class="flex items-center gap-2 flex-wrap">
            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 leading-tight">Dashboard</h1>
            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">
                <i class="fas fa-infinity"></i> Keseluruhan
            </span>
        </div>
        <p class="text-xs sm:text-sm text-gray-500 font-medium">📊 Monitoring seluruh Karang Taruna - Data kumulatif sejak awal</p>
    </div>

  <div class="relative mt-3 sm:mt-4 md:mt-5">
    <div class="glass-dark rounded-lg sm:rounded-xl md:rounded-2xl lg:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern relative overflow-visible" style="min-height: 120px;">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 relative z-20">
            <!-- Greeting -->
            <div class="flex-1 w-full">
                <div class="flex items-start gap-2 sm:gap-3">
                    @php
                        $hour = date('H');
                        if ($hour < 12) {
                            $greeting = 'Good Morning';
                            $message = 'Have a productive day ahead';
                            $icon = 'fa-sun';
                            $bgColor = 'bg-gradient-to-br from-yellow-400 to-yellow-500';
                        } elseif ($hour < 15) {
                            $greeting = 'Good Afternoon';
                            $message = 'Your day is going well';
                            $icon = 'fa-cloud-sun';
                            $bgColor = 'bg-gradient-to-br from-blue-400 to-blue-500';
                        } elseif ($hour < 18) {
                            $greeting = 'Good Evening';
                            $message = 'Hope you had a productive day';
                            $icon = 'fa-sun';
                            $bgColor = 'bg-gradient-to-br from-orange-400 to-orange-500';
                        } else {
                            $greeting = 'Good Night';
                            $message = 'Get some good rest';
                            $icon = 'fa-moon';
                            $bgColor = 'bg-gradient-to-br from-indigo-600 to-purple-600';
                        }
                    @endphp
                    <div class="w-8 sm:w-10 md:w-12 lg:w-16 h-8 sm:h-10 md:h-12 lg:h-16 {{ $bgColor }} rounded-lg sm:rounded-xl md:rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <i class="fas {{ $icon }} text-white text-sm sm:text-base md:text-lg lg:text-2xl"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs sm:text-sm md:text-base text-gray-500 font-medium truncate mb-0.5" id="greetingText"></p>
                        <p class="text-sm sm:text-base md:text-lg font-bold text-gray-900 truncate mb-1 sm:mb-2" id="messageText"></p>
                        <div class="flex items-center gap-1 text-xs sm:text-sm text-gray-500">
                            <i class="fas fa-calendar-alt text-gray-400"></i>
                            <span class="hidden sm:inline">{{ date('d M Y') }}</span>
                            <span class="sm:hidden">{{ date('d M') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Icon - Breakout Element -->
            <div class="absolute right-2 sm:right-3 md:right-4 -bottom-2 sm:-bottom-3 md:-bottom-4 z-10 icon-breakout">
                <img src="{{ asset('build/assets/icon.png') }}" alt="Dashboard Illustration" class="h-full w-auto object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-300">
            </div>
        </div>
    </div>
</div>
</div>

<!-- Stats Cards -->
<div class="space-y-3 sm:space-y-4 mb-6 sm:mb-8">
    <!-- First Row: 3 Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
        <!-- Total Karang Taruna -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0s;">
            <div class="flex justify-between items-start">
                <div class="min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Karang Taruna</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">{{ $totalKarangTaruna }}</h3>
                    <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Unit</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                    <i class="fas fa-building text-green-600 text-base sm:text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Sampah -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.05s;">
            <div class="flex justify-between items-start">
                <div class="min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Sampah</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">{{ number_format($totalSampahKg, 2) }}<span class="text-xs sm:text-sm text-gray-500"> kg</span></h3>
                    <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Sampah Terkumpul</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                    <i class="fas fa-weight text-green-600 text-base sm:text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- CO2 Dikurangi -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
            <div class="flex justify-between items-start">
                <div class="min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">CO₂e Berkurang</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">{{ number_format($totalCO2, 2) }}<span class="text-xs sm:text-sm text-gray-500"> kg CO₂e</span></h3>
                    <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Emisi Karbon</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                    <i class="fas fa-leaf text-green-600 text-base sm:text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: 3 Cards (Financial) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-4 md:gap-6">
        <!-- Kas Masuk -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.15s;">
            <div class="flex justify-between items-start">
                <div class="min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Masuk</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">Rp {{ number_format($totalKasMasuk, 0) }}</h3>
                    <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Pemasukan</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                    <i class="fas fa-arrow-trend-up text-green-600 text-base sm:text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Kas Keluar -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.2s;">
            <div class="flex justify-between items-start">
                <div class="min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Keluar</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">Rp {{ number_format($totalKasKeluar, 0) }}</h3>
                    <p class="text-xs text-red-600 mt-1 sm:mt-2 font-medium">Pengeluaran</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-red-100 to-red-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                    <i class="fas fa-arrow-trend-down text-red-600 text-base sm:text-lg md:text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Saldo Bersih -->
        <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.25s;">
            <div class="flex justify-between items-start">
                <div class="min-w-0 flex-1">
                    <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Saldo Bersih</p>
                    <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">Rp {{ number_format($totalKasBersih, 0) }}</h3>
                    <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Saldo</p>
                </div>
                <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                    <i class="fas fa-wallet text-green-600 text-base sm:text-lg md:text-xl"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions & Top Performers Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Quick Actions -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern animate-fade-in-up">
        <div class="flex items-center gap-2 mb-3">
            <i class="fas fa-zap text-yellow-500 text-sm"></i>
            <h4 class="text-xs sm:text-sm font-bold text-gray-900">Quick Actions</h4>
        </div>
        <div class="grid grid-cols-3 gap-2">
            <a href="{{ route('admin.karang-taruna.create') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg hover:bg-green-50 transition-colors group text-center">
                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-plus text-white text-xs"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700 line-clamp-1">Tambah KT</span>
            </a>
            <a href="{{ route('admin.karang-taruna.index') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg hover:bg-green-50 transition-colors group text-center">
                <div class="w-8 h-8 bg-gradient-to-br from-green-600 to-green-700 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-building text-white text-xs"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700 line-clamp-1">Kelola KT</span>
            </a>
            <a href="{{ route('admin.laporan.arus-kas') }}" class="flex flex-col items-center gap-1 p-2 rounded-lg hover:bg-green-50 transition-colors group text-center">
                <div class="w-8 h-8 bg-gradient-to-br from-green-700 to-green-800 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-line text-white text-xs"></i>
                </div>
                <span class="text-xs font-semibold text-gray-700 line-clamp-1">Laporan</span>
            </a>
        </div>
    </div>

    <!-- Top Performers Mini -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern animate-fade-in-up">
        <div class="flex items-center gap-2 mb-2">
            <i class="fas fa-crown text-yellow-500 text-sm"></i>
            <h4 class="text-xs sm:text-sm font-bold text-gray-900">Top Performers</h4>
        </div>
        <div class="space-y-1.5">
            @forelse($topPerformers as $performer)
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-gradient-to-r {{ $performer['rank'] == 1 ? 'from-yellow-50/80 to-yellow-50/40' : ($performer['rank'] == 2 ? 'from-gray-50/80 to-gray-50/40' : 'from-orange-50/80 to-orange-50/40') }} hover:shadow-sm transition-all">
                    <span class="text-xs font-bold text-gray-600 w-5">{{ $performer['rank'] == 1 ? '🥇' : ($performer['rank'] == 2 ? '🥈' : '🥉') }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-semibold text-gray-800 truncate">{{ $performer['nama_karang_taruna'] }}</p>
                        <p class="text-xs text-gray-500">RW {{ $performer['rw'] }}</p>
                    </div>
                    <p class="text-xs font-bold text-green-600 whitespace-nowrap">{{ number_format($performer['total_sampah'], 2) }}kg</p>
                </div>
            @empty
                <p class="text-xs text-gray-500 py-2 text-center">Belum ada data</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
    <!-- Trend Chart -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 md:p-8 shadow-modern border-modern animate-fade-in-up">
        <div class="flex items-start sm:items-center gap-2 sm:gap-3 mb-3 sm:mb-4 pb-2 sm:pb-3 border-b border-gray-200">
            <div class="w-8 sm:w-9 h-8 sm:h-9 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-soft flex-shrink-0">
                <i class="fas fa-chart-line text-green-600 font-bold text-xs sm:text-sm"></i>
            </div>
            <div class="min-w-0">
                <h4 class="text-xs sm:text-base md:text-lg font-bold text-gray-900 truncate">Tren Sampah</h4>
                <p class="text-xs text-gray-500 font-medium">6 bulan terakhir</p>
            </div>
        </div>
        
        <div class="chart-container-responsive">
            @if(!empty($sampahTrend) && count($sampahTrend) > 0)
                <canvas id="sampahTrendChart"></canvas>
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <i class="fas fa-inbox text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm">Belum ada data 6 bulan terakhir</p>
                    </div>
                </div>
            @endif
        </div>

        <div class="grid grid-cols-2 gap-2 sm:gap-3">
            <div class="stat-card">
                <p class="text-xs font-bold text-gray-500 mb-1 tracking-widest">Total Terkumpul</p>
                <p class="text-base sm:text-lg md:text-xl font-bold text-green-700 truncate">{{ number_format($totalSampahKg, 2) }}</p>
                <p class="text-xs text-gray-500 mt-1">kg</p>
            </div>
            <div class="stat-card">
                <p class="text-xs font-bold text-gray-500 mb-1 tracking-widest">Rata-rata</p>
                <p class="text-base sm:text-lg md:text-xl font-bold text-green-700 truncate">{{ isset($sampahTrend) && !empty($sampahTrend) ? number_format(array_sum((array)$sampahTrend) / count((array)$sampahTrend), 2) : '0' }}</p>
                <p class="text-xs text-gray-500 mt-1">kg/bln</p>
            </div>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern animate-fade-in-up">
        <div class="flex items-start sm:items-center gap-2 sm:gap-3 mb-3 sm:mb-4 pb-2 sm:pb-3 border-b border-gray-200">
            <div class="w-8 sm:w-9 h-8 sm:h-9 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center shadow-soft flex-shrink-0">
                <i class="fas fa-chart-pie text-green-600 text-xs sm:text-sm"></i>
            </div>
            <div class="min-w-0">
                <h4 class="text-xs sm:text-base md:text-lg font-bold text-gray-900 truncate">Distribusi Sampah</h4>
                <p class="text-xs text-gray-500 font-medium">Per kategori</p>
            </div>
        </div>

        <div class="flex flex-col items-center mb-3 sm:mb-4">
            <div class="chart-pie-container-responsive">
                @if(!empty($sampahByKategori) && count($sampahByKategori) > 0)
                    <canvas id="sampahPieChart"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <div class="bg-white/95 backdrop-blur-xl rounded-lg sm:rounded-2xl px-2 sm:px-4 py-2 sm:py-3 flex flex-col items-center justify-center shadow-xl border border-white/40">
                            <div class="text-lg sm:text-2xl font-bold text-green-600">{{ number_format($totalSampahKg, 2) }}</div>
                            <div class="text-xs text-gray-500 font-semibold mt-0.5">kg Total</div>
                        </div>
                    </div>
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-500">
                        <div class="text-center">
                            <i class="fas fa-inbox text-4xl text-gray-300"></i>
                            <p class="text-xs mt-2">Belum ada data</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="space-y-1.5 sm:space-y-2 max-h-24 sm:max-h-32 overflow-y-auto scrollbar-thin mb-3" id="pieChartLegend"></div>

        @if(!empty($sampahByKategori) && count($sampahByKategori) > 0)
        <div class="mt-2 sm:mt-3 p-2 sm:p-3 bg-gradient-to-br from-green-50/80 to-green-50/80 rounded-lg sm:rounded-xl border border-green-100/50">
            <div class="flex items-center justify-between gap-2">
                <div class="flex items-center gap-1.5 sm:gap-2 min-w-0">
                    <div class="w-7 sm:w-8 h-7 sm:h-8 rounded-lg bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center shadow-md flex-shrink-0">
                        <i class="fas fa-trophy text-white text-xs"></i>
                    </div>
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-gray-500 tracking-widest">Top</div>
                        <div class="text-xs sm:text-sm font-bold text-gray-900 truncate">{{ $sampahByKategori[0]['nama_kategori'] ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="text-right flex-shrink-0">
                    <div class="text-sm sm:text-base font-bold text-green-700">{{ number_format($sampahByKategori[0]['total_kg'] ?? 0, 2) }}</div>
                    <div class="text-xs text-gray-500 font-medium">kg</div>
                </div>
            </div>
        </div>
        @endif
    </div>
    </div>
</div>

<style>
@keyframes fade-in-up {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes scale-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.glass-dark { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
.shadow-modern { box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); }
.shadow-soft { box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06); }
.border-modern { border: 1px solid rgba(255, 255, 255, 0.5); }
.animate-fade-in-up { animation: fade-in-up 0.6s ease-out; }
.animate-scale-in { animation: scale-in 0.5s ease-out forwards; opacity: 0; }

.card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
.card-hover:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12); }

.icon-breakout {
    height: 100px;
    opacity: 0.8;
}

@media (min-width: 640px) {
    .icon-breakout { height: 140px; opacity: 0.85; }
}

@media (min-width: 768px) {
    .icon-breakout { height: 180px; opacity: 0.9; }
}

@media (min-width: 1024px) {
    .icon-breakout { height: 220px; opacity: 0.95; }
}

@media (min-width: 1280px) {
    .icon-breakout { height: 260px; opacity: 1; }
}

.chart-container-responsive { 
    position: relative; 
    height: 160px; 
    margin-bottom: 1rem;
}

@media (min-width: 640px) {
    .chart-container-responsive { height: 180px; margin-bottom: 1.25rem; }
}

@media (min-width: 768px) {
    .chart-container-responsive { height: 200px; }
}

@media (min-width: 1024px) {
    .chart-container-responsive { height: 240px; }
}

.chart-pie-container-responsive { 
    position: relative; 
    height: 150px; 
    width: 150px; 
    margin-bottom: 0.5rem;
}

@media (min-width: 640px) {
    .chart-pie-container-responsive { height: 160px; width: 160px; }
}

@media (min-width: 768px) {
    .chart-pie-container-responsive { height: 180px; width: 180px; }
}

@media (min-width: 1024px) {
    .chart-pie-container-responsive { height: 220px; width: 220px; }
}

.stat-card { 
    background: linear-gradient(to bottom right, rgba(34, 197, 94, 0.08), rgba(34, 197, 94, 0.08)); 
    border-radius: 0.75rem; 
    padding: 0.75rem; 
    border: 1px solid rgba(34, 197, 94, 0.3); 
    transition: all 0.3s;
}

@media (min-width: 768px) {
    .stat-card { border-radius: 1rem; padding: 1rem; }
}

.stat-card:hover { border-color: rgba(34, 197, 94, 0.5); }

.scrollbar-thin::-webkit-scrollbar { width: 4px; }
.scrollbar-thin::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
.scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>

@endsection

@push('scripts')
<script>
function typeWriterSequential(elements, texts, speed = 50) {
    let elementIndex = 0;
    
    function typeNextElement() {
        if (elementIndex >= elements.length) return;
        
        const element = elements[elementIndex];
        const text = texts[elementIndex];
        let charIndex = 0;
        element.textContent = '';
        
        function type() {
            if (charIndex < text.length) {
                element.textContent += text.charAt(charIndex);
                charIndex++;
                setTimeout(type, speed);
            } else {
                elementIndex++;
                setTimeout(typeNextElement, 300);
            }
        }
        
        type();
    }
    
    typeNextElement();
}

document.addEventListener('DOMContentLoaded', () => {
    const greetingText = document.getElementById('greetingText');
    const messageText = document.getElementById('messageText');
    
    if (greetingText && messageText) {
        const greeting = '{{ $greeting }}';
        const message = '{{ $message }}';
        
        typeWriterSequential([greetingText, messageText], [greeting, message], 50);
    }
});

const chartConfig = {
    tooltip: { backgroundColor: 'rgba(15, 23, 42, 0.95)', titleColor: '#ffffff', bodyColor: '#ffffff', borderColor: 'rgba(255, 255, 255, 0.2)', cornerRadius: 16, padding: 12, displayColors: false },
    animation: { duration: 1500, easing: 'easeInOutCubic' }
};

// Trend Chart
if (document.getElementById('sampahTrendChart')) {
    const data = @json($sampahTrend);
    
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
                datasets: [{ data: Object.values(data), borderColor: '#16a34a', backgroundColor: gradient, borderWidth: 3, fill: true, tension: 0.45, pointRadius: 5, pointHoverRadius: 10, pointBackgroundColor: '#10b981', pointBorderColor: '#ffffff', pointBorderWidth: 3 }]
            },
            options: {
                responsive: true, maintainAspectRatio: false, animation: chartConfig.animation,
                plugins: { legend: { display: false }, tooltip: { ...chartConfig.tooltip, callbacks: { title: (c) => c[0].label + ' 2024', label: (c) => c.parsed.y.toLocaleString('id-ID') + ' kg' } } },
                scales: { x: { grid: { display: false }, ticks: { color: '#6b7280' } }, y: { beginAtZero: true, grid: { color: 'rgba(0, 0, 0, 0.06)' }, ticks: { color: '#9ca3af', callback: (v) => v >= 1000 ? (v / 1000).toFixed(1) + 'K' : v } } }
            }
        });
    }
}

// Pie Chart
if (document.getElementById('sampahPieChart')) {
    const pieData = @json($sampahByKategori);
    
    if (pieData && Array.isArray(pieData) && pieData.length > 0) {
        const ctx = document.getElementById('sampahPieChart').getContext('2d');
        const totalKg = pieData.reduce((s, i) => s + (i.total_kg || 0), 0);
        const colors = ['#16A34A', '#15803D', '#166534', '#10B981', '#059669', '#047857', '#065F46', '#34D399', '#6EE7B7', '#A7F3D0'];
        
        const chartData = pieData.map((item, i) => ({ ...item, percentage: totalKg > 0 ? ((item.total_kg / totalKg) * 100).toFixed(1) : 0, color: colors[i % colors.length] }));
        const gradients = chartData.map((item) => { const g = ctx.createLinearGradient(0, 0, 256, 256); g.addColorStop(0, item.color); g.addColorStop(1, item.color + '66'); return g; });
        
        new Chart(ctx, {
            type: 'doughnut',
            data: { labels: chartData.map(i => i.nama_kategori), datasets: [{ data: chartData.map(i => i.total_kg), backgroundColor: gradients, borderColor: '#ffffff', borderWidth: 3, borderRadius: 12 }] },
            options: { responsive: true, maintainAspectRatio: false, cutout: '65%', animation: chartConfig.animation, plugins: { legend: { display: false }, tooltip: { ...chartConfig.tooltip, callbacks: { label: (c) => { const i = chartData[c.dataIndex]; return i.total_kg.toLocaleString('id-ID') + ' kg • ' + i.percentage + '%'; } } } } }
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
