    @extends('karang-taruna.layouts.app')

    @section('title', $warga->nama . ' - SisaKu')

    @section('content')
    <div class="w-full min-h-screen px-3 sm:px-4 md:px-6 lg:px-12 py-4 sm:py-6 md:py-8">
        <div class="max-w-4xl mx-auto">

            <!-- Header -->
            <div class="mb-6 sm:mb-8 animate-page-load">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <a href="{{ route('karang-taruna.warga.index') }}" class="p-2.5 sm:p-3 hover:bg-white/50 rounded-lg sm:rounded-xl transition-colors flex-shrink-0 min-h-[48px] min-w-[48px] flex items-center justify-center">
                            <i class="fas fa-arrow-left text-gray-600 text-lg sm:text-xl"></i>
                        </a>
                        <div class="min-w-0 flex-1">
                            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-gray-900 leading-tight">{{ $warga->nama }}</h1>
                            <p class="text-gray-600 mt-1 text-xs sm:text-sm">Detail informasi warga</p>
                        </div>
                    </div>
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                        <a href="{{ route('karang-taruna.warga.edit', $warga) }}" class="inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm whitespace-nowrap min-h-[48px]">
                            <i class="fas fa-edit mr-2"></i><span class="hidden sm:inline">Edit</span><span class="sm:hidden">Edit</span>
                        </a>
                        <form method="POST" action="{{ route('karang-taruna.warga.destroy', $warga) }}" class="inline w-full sm:w-auto" onsubmit="return confirm('Yakin ingin menghapus warga ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-3 sm:px-4 py-2.5 sm:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg sm:rounded-xl shadow-modern hover:shadow-lg transition-all text-xs sm:text-sm min-h-[48px]">
                                <i class="fas fa-trash mr-2"></i><span class="hidden sm:inline">Hapus</span><span class="sm:hidden">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6 lg:gap-6 mb-6 md:mb-8">
                <!-- Profile Card -->
                <div class="glass-dark rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-modern border-modern animate-page-load scroll-reveal">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-200">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center shadow-soft">
                            <i class="fas fa-user text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Informasi Pribadi</h3>
                            <p class="text-xs text-gray-500">Data warga</p>
                        </div>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Nama Warga</p>
                            <p class="text-sm sm:text-base font-medium text-gray-900">{{ $warga->nama }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">Alamat</p>
                            <p class="text-sm sm:text-base font-medium text-gray-700">{{ $warga->alamat }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-500 mb-0.5 tracking-wide">No. Telepon</p>
                            <p class="text-sm sm:text-base font-medium text-gray-900">{{ $warga->no_telepon ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-1 gap-3 md:gap-4">
                    <!-- Total Transaksi -->
                    <div class="glass-dark rounded-2xl sm:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover scroll-reveal">
                        <div class="flex justify-between items-start gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 md:mb-2">Total Transaksi</p>
                                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="{{ $warga->transaksiSampah()->count() }}">{{ $warga->transaksiSampah()->count() }}</h3>
                                <p class="text-xs text-green-600 mt-1 md:mt-2 font-medium">transaksi</p>
                            </div>
                            <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-exchange-alt text-green-600 text-sm sm:text-lg md:text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Berat -->
                    <div class="glass-dark rounded-2xl sm:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover scroll-reveal" style="animation-delay: 0.1s;">
                        <div class="flex justify-between items-start gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 md:mb-2">Total Berat Sampah</p>
                                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-green-600 mt-1" data-value="{{ number_format($totalBerat, 1) }} kg">{{ number_format($totalBerat, 1) }} kg</h3>
                                <p class="text-xs text-gray-600 mt-1 md:mt-2 font-medium">kilogram</p>
                            </div>
                            <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-weight text-green-600 text-sm sm:text-lg md:text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Harga -->
                    <div class="glass-dark rounded-2xl sm:rounded-3xl p-3 sm:p-4 md:p-6 shadow-modern border-modern card-hover scroll-reveal" style="animation-delay: 0.2s;">
                        <div class="flex justify-between items-start gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs sm:text-sm font-semibold text-gray-700 tracking-wide mb-1 md:mb-2">Total Harga</p>
                                <h3 class="responsive-number text-xl sm:text-2xl md:text-3xl font-bold text-gray-900 mt-1" data-value="Rp {{ number_format($totalHarga, 0, ',', '.') }}">Rp {{ number_format($totalHarga, 0, ',', '.') }}</h3>
                                <p class="text-xs text-gray-600 mt-1 md:mt-2 font-medium">rupiah</p>
                            </div>
                            <div class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-100 to-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-money-bill-wave text-green-600 text-sm sm:text-lg md:text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="glass-dark rounded-2xl sm:rounded-3xl shadow-modern border-modern overflow-hidden animate-page-load" style="animation-delay: 0.1s;">
                <div class="p-3 sm:p-4 md:p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center shadow-soft">
                            <i class="fas fa-exchange-alt text-green-600 text-sm"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-900">Transaksi Terbaru</h3>
                            <p class="text-xs text-gray-500">Riwayat transaksi</p>
                        </div>
                    </div>
                </div>
                <div class="overflow-x-auto -mx-3 sm:-mx-4 md:mx-0 px-3 sm:px-4 md:px-0">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                                <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Tanggal</th>
                                <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Jenis Sampah</th>
                                <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Berat (kg)</th>
                                <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Harga</th>
                                <th class="text-left px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs font-semibold text-gray-600 tracking-wider whitespace-nowrap">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($transaksi as $t)
                            <tr class="border-b border-gray-100 hover:bg-green-50 transition-all duration-200">
                                <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-900 font-medium">{{ $t->tanggal_transaksi->format('d M Y • H:i') }}</td>
                                <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-600">{{ $t->items->pluck('kategoriSampah.nama_kategori')->unique()->join(', ') ?: '-' }}</td>
                                <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-900 font-semibold">{{ number_format((float)$t->items->sum('berat_kg'), 2) }}</td>
                                <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-900 font-semibold">Rp {{ number_format((float)$t->items->sum('total_harga'), 0, ',', '.') }}</td>
                                <td class="px-3 sm:px-4 md:px-6 py-3 sm:py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $t->status_penjualan === 'terjual' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($t->status_penjualan) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-3 sm:px-4 md:px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-4xl sm:text-5xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500 font-medium text-sm">Belum ada transaksi</p>
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

    @push('styles')
    <style>
        .card-hover {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.01);
        }
    </style>
    @endpush
