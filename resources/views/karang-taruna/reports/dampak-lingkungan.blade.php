@extends('karang-taruna.layouts.app')

@section('title', 'Laporan Dampak Lingkungan - SisaKu')

@section('content')
<div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">
    <!-- Header -->
    <div class="mb-6 sm:mb-8 md:mb-12 animate-fade-in-up">
        <div class="flex items-center gap-3 sm:gap-4 mb-6 sm:mb-8">
            <div class="flex-1">
                <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold mb-1 text-gray-900 leading-tight">
                    Laporan Dampak Lingkungan
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 font-medium">Monitor kontribusi lingkungan komunitas</p>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Berat Sampah</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ number_format($summary['total_berat'], 2) }}<span class="text-base sm:text-lg text-gray-500 font-semibold"> kg</span></h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Sampah yang dikelola</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-trash text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.05s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Pengurangan CO₂e</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ number_format($summary['total_co2'], 2) }}<span class="text-base sm:text-lg text-gray-500 font-semibold"> kg</span></h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Dampak positif lingkungan</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-leaf text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Jumlah Transaksi</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $summary['jumlah_transaksi'] }}</h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Total transaksi sampah</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exchange-alt text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.15s;">
                <div class="flex justify-between items-start">
                    <div class="min-w-0">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Warga Partisipan</p>
                        <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1">{{ $summary['jumlah_warga'] }}</h3>
                        <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Warga yang aktif</p>
                    </div>
                    <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-users text-green-600 text-base sm:text-lg md:text-xl"></i>
                    </div>
                </div>
            </div>
        </div>



        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6 sm:mb-8">
            <!-- Line Chart: Daily Trend -->
            <div class="lg:col-span-2 glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex items-start gap-3 mb-4 sm:mb-6">
                    <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-lg sm:rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-line text-blue-600 text-xs sm:text-lg"></i>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-sm sm:text-lg md:text-xl font-bold text-gray-900">Trend Harian</h2>
                        <p class="text-xs text-gray-600 font-medium mt-1">Pergerakan berat sampah & pengurangan CO₂e per hari</p>
                    </div>
                </div>
                <div style="position: relative; height: 250px sm:height-300px;">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>

            <!-- Bar Chart: Category Breakdown -->
            <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern p-4 sm:p-6 md:p-8 animate-fade-in-up" style="animation-delay: 0.25s;">
                <div class="flex items-start gap-3 mb-4 sm:mb-6">
                    <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-lg sm:rounded-2xl bg-gradient-to-br from-cyan-100 to-blue-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-bars text-cyan-600 text-xs sm:text-lg"></i>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-sm sm:text-lg md:text-xl font-bold text-gray-900">Per Kategori</h2>
                        <p class="text-xs text-gray-600 font-medium mt-1">Berat sampah per kategori</p>
                    </div>
                </div>
                <div style="position: relative; height: 250px sm:height-300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Breakdown Per Kategori -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden mb-6 sm:mb-8" style="animation-delay: 0.2s;">
        <!-- Table Header -->
        <div class="p-3 sm:p-4 md:p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4 mb-4 sm:mb-6">
                <div class="flex items-start gap-2 sm:gap-3">
                    <div class="w-8 sm:w-10 h-8 sm:h-10 rounded-lg sm:rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-chart-pie text-green-600 text-xs sm:text-lg"></i>
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-sm sm:text-lg md:text-xl font-bold text-gray-900">Per Kategori Sampah</h2>
                        <p class="text-xs text-gray-600 font-medium mt-1">Breakdown dampak per kategori</p>
                    </div>
                </div>
                <a href="{{ route('karang-taruna.laporan.dampak-lingkungan.export-pdf', request()->query()) }}" class="w-full sm:w-auto px-3 py-2 sm:py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg sm:rounded-xl text-xs font-bold transition-all flex items-center justify-center gap-2 hover:shadow-lg transform hover:scale-105 min-h-[40px] sm:min-h-[44px]">
                    <i class="fas fa-file-pdf"></i> <span class="hidden sm:inline">Export PDF</span><span class="sm:hidden">PDF</span>
                </a>
            </div>

            @if($byCategory->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-xs sm:text-sm">
                    <thead>
                        <tr class="border-b-2 border-gray-200 bg-gray-50">
                            <th class="text-left py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Kategori</th>
                            <th class="text-right py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Berat (kg)</th>
                            <th class="text-right py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">CO₂e (kg)</th>
                            <th class="text-center py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-xs font-semibold text-gray-700 tracking-wider whitespace-nowrap">Trans</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byCategory as $cat)
                        <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200 kategori-row">
                            <td class="py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-xs sm:text-sm font-semibold text-gray-900">
                                <div class="flex items-center gap-2">
                                    <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-500 flex-shrink-0"></span>
                                    <span class="truncate">{{ $cat['kategori'] }}</span>
                                </div>
                            </td>
                            <td class="py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-xs sm:text-sm text-right text-gray-600 font-medium whitespace-nowrap">
                                {{ number_format($cat['total_berat'], 2) }}
                            </td>
                            <td class="py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-xs sm:text-sm text-right font-bold text-emerald-600 whitespace-nowrap">
                                {{ number_format($cat['total_co2'], 2) }}
                            </td>
                            <td class="py-2.5 sm:py-3 md:py-4 px-2.5 sm:px-3 md:px-4 lg:px-6 text-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-green-100 text-green-700 rounded-full">
                                    {{ $cat['jumlah_transaksi'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @else
            <div class="text-center py-8 sm:py-12">
                <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto mb-3 sm:mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-inbox text-gray-400 text-lg sm:text-2xl"></i>
                </div>
                <p class="text-gray-600 font-medium text-sm sm:text-base">Tidak ada data kategori</p>
                <p class="text-xs sm:text-sm text-gray-500 mt-1">Silakan tambah transaksi terlebih dahulu</p>
            </div>
            @endif
        </div>
    </div>


</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dailyTrendData = @json($dailyTrendData);
    const categoryData = @json($categoryChartData);

    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: dailyTrendData.labels,
            datasets: [
                {
                    label: 'Berat Sampah (kg)',
                    data: dailyTrendData.berat,
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22, 163, 74, 0.05)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#16a34a',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    yAxisID: 'y'
                },
                {
                    label: 'CO₂e Berkurang (kg)',
                    data: dailyTrendData.co2,
                    borderColor: '#0891b2',
                    backgroundColor: 'rgba(8, 145, 178, 0.05)',
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointBackgroundColor: '#0891b2',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, weight: '600' }
                    }
                }
            },
            scales: {
                y: {
                    type: 'linear',
                    position: 'left',
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 12 }, color: '#16a34a' }
                },
                y1: {
                    type: 'linear',
                    position: 'right',
                    beginAtZero: true,
                    grid: { drawOnChartArea: false },
                    ticks: { font: { size: 12 }, color: '#0891b2' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    const categoryCtx = document.getElementById('categoryChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: categoryData.labels,
            datasets: [
                {
                    label: 'Berat (kg)',
                    data: categoryData.berat,
                    backgroundColor: 'rgba(16, 185, 129, 0.8)',
                    borderColor: '#10b981',
                    borderWidth: 1.5,
                    borderRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: categoryData.labels.length > 5 ? 'y' : 'x',
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, weight: '600' }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { font: { size: 11 } }
                },
                y: {
                    grid: categoryData.labels.length > 5 ? { color: 'rgba(0, 0, 0, 0.05)' } : { display: false },
                    ticks: { font: { size: 11 } }
                }
            }
        }
    });
});
</script>
@endpush

@push('styles')
<style>
.animate-fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.kategori-row {
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.kategori-row:hover {
    background-color: rgba(59, 130, 246, 0.05);
    transform: translateX(4px);
}
</style>
@endpush

@endsection
