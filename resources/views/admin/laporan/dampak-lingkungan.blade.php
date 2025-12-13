@extends('admin.layouts.app')

@section('title', 'Laporan Dampak Lingkungan - SisaKu')

@section('content')

<div class="w-full min-h-screen px-2 sm:px-3 md:px-4 lg:px-6 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-4 sm:mb-6 md:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4 md:mb-6">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-1 sm:mb-2">Laporan Dampak Lingkungan</h1>
        <p class="text-xs sm:text-sm text-gray-500 font-medium">Pantau hasil pengelolaan sampah dan dampak positif lingkungan</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 md:gap-6 mb-4 sm:mb-6 md:mb-8">
    <!-- Total Sampah -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-5 md:p-6 shadow-modern border-modern card-hover animate-scale-in">
        <div class="flex justify-between items-start gap-3">
            <div class="min-w-0">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total Sampah Terkumpul</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format($totalSampah, 2) }}">{{ number_format($totalSampah, 2) }} <span class="text-sm sm:text-base md:text-lg text-gray-500">kg</span></h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Dari seluruh transaksi sampah</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-recycle text-green-600 text-lg sm:text-xl md:text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Total CO2 Tersimpan -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-5 md:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.05s;">
        <div class="flex justify-between items-start gap-3">
            <div class="min-w-0">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Total CO₂e Berkurang</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format($totalCO2, 2) }}">{{ number_format($totalCO2, 2) }} <span class="text-sm sm:text-base md:text-lg text-gray-500">kg CO₂e</span></h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Emisi karbon yang berhasil berkurang</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0">
                <i class="fas fa-leaf text-green-600 text-lg sm:text-xl md:text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Dampak per Karang Taruna with Filter -->
<div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden">
    <!-- Filter Section -->
    <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
        <form method="GET" action="{{ route('admin.laporan.dampak-lingkungan') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Filter RW</label>
                <div class="relative">
                    <select name="karang_taruna_id" class="w-full px-3 sm:px-4 py-2 sm:py-3 pl-8 sm:pl-10 border border-gray-200 rounded-lg sm:rounded-xl focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600 text-gray-900 bg-white appearance-none cursor-pointer hover:border-gray-300 transition-colors text-sm">
                        <option value="all" {{ request('karang_taruna_id') === 'all' || !request('karang_taruna_id') ? 'selected' : '' }}>Semua RW</option>
                        @foreach($karangTarunas as $kt)
                        <option value="{{ $kt->id }}" {{ request('karang_taruna_id') == $kt->id ? 'selected' : '' }}>
                            RW {{ $kt->rw }}
                        </option>
                        @endforeach
                    </select>
                    <i class="fas fa-building absolute left-2.5 sm:left-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs sm:text-sm"></i>
                    <i class="fas fa-chevron-down absolute right-2.5 sm:right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
                </div>
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600 transition-colors text-sm">
            </div>

            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                       class="w-full px-3 sm:px-4 py-2 sm:py-3 border border-gray-200 rounded-lg sm:rounded-xl focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600 transition-colors text-sm">
            </div>

            <div class="flex items-end gap-1.5 sm:gap-2">
                <button type="submit" class="flex-1 px-3 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all flex items-center justify-center gap-1 sm:gap-2 shadow-modern text-xs sm:text-sm">
                    <i class="fas fa-filter"></i>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <a href="{{ route('admin.laporan.dampak-lingkungan') }}" class="px-2.5 sm:px-4 py-2 sm:py-3 bg-gradient-to-br from-gray-50 to-white hover:from-gray-100 hover:to-gray-50 text-gray-700 rounded-lg sm:rounded-xl font-medium transition-all border border-gray-200 hover:border-gray-300 shadow-soft">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="p-3 sm:p-4 md:p-6">
        <div class="mb-3 sm:mb-4 md:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
            <div>
                <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-green-600"></i>
                    <span class="truncate">Dampak per Karang Taruna</span>
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-0.5 sm:mt-1">Kontribusi lingkungan dari setiap unit Karang Taruna</p>
            </div>
            <a href="{{ route('admin.laporan.dampak-lingkungan.export-pdf', request()->query()) }}" class="w-full sm:w-auto px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg sm:rounded-xl text-xs sm:text-sm font-semibold transition-all flex items-center justify-center gap-2 shadow-soft">
                <i class="fas fa-file-pdf"></i> <span class="hidden sm:inline">Export PDF</span><span class="sm:hidden">PDF</span>
            </a>
        </div>

        <div class="overflow-x-auto -mx-3 sm:-mx-4 md:mx-0 px-3 sm:px-4 md:px-0">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm font-semibold text-gray-700 whitespace-nowrap">Karang Taruna</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm font-semibold text-gray-700 whitespace-nowrap">Transaksi</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm font-semibold text-gray-700 whitespace-nowrap">Total Sampah</th>
                    <th class="text-center py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm font-semibold text-gray-700 whitespace-nowrap">CO₂e Berkurang</th>
                    <th class="text-left py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-xs sm:text-sm font-semibold text-gray-700 whitespace-nowrap">Dampak</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($dampakPerRW as $index => $item)
                    <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200">
                        <!-- Karang Taruna Name -->
                        <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6">
                            <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 whitespace-nowrap">
                                RW {{ $item->karangTaruna->rw }}
                            </span>
                        </td>

                        <!-- Total Transaksi -->
                        <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-center">
                            <div class="text-xs sm:text-sm font-semibold text-gray-900">
                                {{ $item->total_transaksi }}
                            </div>
                        </td>

                        <!-- Total Sampah -->
                        <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-center">
                            <div class="text-xs sm:text-sm font-semibold text-green-600 whitespace-nowrap">
                                {{ number_format($item->total_sampah, 2) }} kg
                            </div>
                        </td>

                        <!-- Total CO2 -->
                        <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6 text-center">
                            <div class="text-xs sm:text-sm font-semibold text-green-700 whitespace-nowrap">
                                {{ number_format($item->total_co2, 2) }} kg CO₂e
                            </div>
                        </td>

                        <!-- Impact Bar -->
                        <td class="py-3 sm:py-4 px-3 sm:px-4 md:px-6">
                            <div class="flex items-center gap-2 sm:gap-3">
                                <div class="flex-1 bg-gray-200 rounded-full h-1.5 sm:h-2">
                                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-1.5 sm:h-2 rounded-full"
                                         style="width: {{ $dampakPerRW->first() && $dampakPerRW->first()->total_sampah > 0 ? min(100, ($item->total_sampah / $dampakPerRW->first()->total_sampah) * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-xs font-medium text-gray-600 min-w-max whitespace-nowrap">
                                    {{ $dampakPerRW->first() && $dampakPerRW->first()->total_sampah > 0 ? round(($item->total_sampah / $dampakPerRW->first()->total_sampah) * 100, 0) : 0 }}%
                                </span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 sm:py-12 px-3 sm:px-4 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-4xl sm:text-5xl text-gray-300 mb-2 sm:mb-4"></i>
                                <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-1">Belum Ada Data</h3>
                                <p class="text-gray-500 text-xs sm:text-sm">Tidak ada transaksi sampah sesuai filter yang dipilih</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
@endsection
