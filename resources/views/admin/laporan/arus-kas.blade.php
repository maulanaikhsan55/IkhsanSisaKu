@extends('admin.layouts.app')

@section('title', 'Laporan Arus Kas - SisaKu')

@section('content')

<div class="w-full min-h-screen px-2 sm:px-3 md:px-4 lg:px-6 py-4 sm:py-6 md:py-8">

<!-- Header -->
<div class="mb-6 sm:mb-8 animate-fade-in-up">
    <div class="mb-3 sm:mb-4 md:mb-6">
        <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 mb-1 sm:mb-2 leading-tight">Laporan Arus Kas</h1>
        <p class="text-xs sm:text-sm text-gray-500 font-medium">Pantau arus kas dan laporan keuangan dari seluruh RW</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 md:gap-6 mb-6 sm:mb-8">
    <!-- Total Pemasukan -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in">
        <div class="flex justify-between items-start">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Masuk</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format($totalMasuk, 0) }}">Rp {{ number_format($totalMasuk, 0) }}</h3>
                <p class="text-xs text-green-600 mt-1 sm:mt-2 font-medium">Pemasukan</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-green-100 to-emerald-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                <i class="fas fa-arrow-trend-up text-green-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Total Pengeluaran -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.1s;">
        <div class="flex justify-between items-start">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Kas Keluar</p>
                <h3 class="text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1 truncate">Rp {{ number_format($totalKeluar, 0) }}</h3>
                <p class="text-xs text-red-600 mt-1 sm:mt-2 font-medium">Pengeluaran</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-red-100 to-orange-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                <i class="fas fa-arrow-trend-down text-red-500 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Saldo Bersih -->
    <div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl p-4 sm:p-6 shadow-modern border-modern card-hover animate-scale-in" style="animation-delay: 0.2s;">
        <div class="flex justify-between items-start">
            <div class="min-w-0 flex-1">
                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 sm:mb-2">Saldo Bersih</p>
                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ number_format(($totalMasuk - $totalKeluar), 0) }}">Rp {{ number_format(($totalMasuk - $totalKeluar), 0) }}</h3>
                <p class="text-xs text-emerald-600 mt-1 sm:mt-2 font-medium">Saldo</p>
            </div>
            <div class="w-10 sm:w-11 md:w-12 h-10 sm:h-11 md:h-12 bg-gradient-to-br from-emerald-100 to-teal-100 rounded-lg sm:rounded-xl flex items-center justify-center flex-shrink-0 shadow-soft">
                <i class="fas fa-wallet text-emerald-600 text-base sm:text-lg md:text-xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Data Table with Filter -->
<div class="glass-dark rounded-lg sm:rounded-2xl md:rounded-3xl shadow-modern border-modern animate-fade-in-up overflow-hidden mb-6 sm:mb-8">
    <!-- Filter Section -->
    <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
        <form method="GET" action="{{ route('admin.laporan.arus-kas') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-3 md:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Filter RW</label>
                <div class="relative">
                    <select name="karang_taruna_id" class="w-full px-3 sm:px-4 py-2 sm:py-3 pl-9 sm:pl-10 border border-gray-200 rounded-lg sm:rounded-xl focus:outline-none focus:border-green-600 focus:ring-2 focus:ring-green-600 text-gray-900 bg-white appearance-none cursor-pointer hover:border-gray-300 transition-colors text-sm">
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
                <button type="submit" class="flex-1 px-3 sm:px-6 py-2 sm:py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white rounded-lg sm:rounded-xl font-semibold transition-all shadow-modern flex items-center justify-center gap-1 sm:gap-2 text-xs sm:text-sm md:text-base">
                    <i class="fas fa-filter"></i>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <a href="{{ route('admin.laporan.arus-kas') }}" class="px-2.5 sm:px-4 py-2 sm:py-3 bg-gradient-to-br from-gray-50 to-white hover:from-gray-100 hover:to-gray-50 text-gray-700 rounded-lg sm:rounded-xl font-medium transition-all border border-gray-200 hover:border-gray-300 shadow-soft text-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Table Section -->
    <div class="p-3 sm:p-4 md:p-6">
        <div class="mb-4 sm:mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-4">
            <h2 class="text-base sm:text-lg md:text-xl font-bold text-gray-900">Daftar Transaksi Keuangan</h2>
            <a href="{{ route('admin.laporan.arus-kas.export-pdf', request()->query()) }}" class="w-full sm:w-auto px-3 sm:px-4 py-2 sm:py-2.5 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg text-xs sm:text-sm font-semibold transition-all flex items-center justify-center gap-2 shadow-soft">
                <i class="fas fa-file-pdf"></i> <span class="hidden sm:inline">Export PDF</span><span class="sm:hidden">PDF</span>
            </a>
        </div>
        <div class="overflow-x-auto -mx-3 sm:-mx-4 md:mx-0 px-3 sm:px-4 md:px-0">
            <table class="w-full text-sm">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Tanggal</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">RW</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Kategori</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-left text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Deskripsi</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-center text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Jenis</th>
                    <th class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-right text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Jumlah</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($arusKas as $kas)
                <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200">
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-medium text-gray-900">
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <i class="fas fa-calendar-alt text-gray-400 text-xs sm:text-sm hidden sm:inline"></i>
                            {{ \Carbon\Carbon::parse($kas->tanggal_transaksi)->format('d M') }}
                        </div>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm">
                        <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            RW {{ $kas->karangTaruna->rw ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm">
                        <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold {{ $kas->kategoriKeuangan->jenis === 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $kas->kategoriKeuangan->nama_kategori ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-700 whitespace-nowrap">
                        {{ $kas->deskripsi ?? '-' }}
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-2 sm:px-3 py-0.5 sm:py-1 rounded-full text-xs font-semibold {{ $kas->jenis_transaksi === 'masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            @if($kas->jenis_transaksi === 'masuk')
                                <i class="fas fa-arrow-down mr-0.5 sm:mr-1"></i> <span class="hidden sm:inline">Masuk</span><span class="sm:hidden">+</span>
                            @else
                                <i class="fas fa-arrow-up mr-0.5 sm:mr-1"></i> <span class="hidden sm:inline">Keluar</span><span class="sm:hidden">-</span>
                            @endif
                        </span>
                    </td>
                    <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 whitespace-nowrap text-right text-xs sm:text-sm font-bold {{ $kas->jenis_transaksi === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $kas->jenis_transaksi === 'masuk' ? '+' : '-' }} {{ number_format($kas->jumlah, 0) }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada data arus kas</h3>
                            <p class="text-gray-500">Belum ada transaksi keuangan yang sesuai dengan filter yang dipilih.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($arusKas->hasPages())
        <div class="bg-gray-50 px-0 py-4 border-t border-gray-200">
            {{ $arusKas->appends(request()->query())->links('pagination.custom') }}
        </div>
        @endif
    </div>
</div>
@endsection
