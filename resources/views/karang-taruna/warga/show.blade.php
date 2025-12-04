@extends('karang-taruna.layouts.app')

@section('title', $warga->nama . ' - SisaKu')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50 to-green-50">
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

<!-- Header -->
<div class="mb-8 animate-fade-in-up">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('karang-taruna.warga.index') }}" class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition-colors">
                <i class="fas fa-arrow-left text-gray-700"></i>
            </a>
            <div>
                <h1 class="text-4xl font-black text-gray-900">{{ $warga->nama }}</h1>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('karang-taruna.warga.edit', $warga) }}" class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-2xl hover:bg-yellow-600 transition-all flex items-center gap-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form method="POST" action="{{ route('karang-taruna.warga.destroy', $warga) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus warga ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white font-semibold rounded-2xl hover:bg-red-600 transition-all flex items-center gap-2">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Info Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
    <!-- Profile Card -->
    <div class="bg-white rounded-3xl shadow-md border border-gray-200/50 p-8 animate-fade-in-up">
        <h3 class="text-xl font-black text-gray-900 mb-6">Informasi Pribadi</h3>
        <div class="space-y-5">
            <div class="flex justify-between items-start pb-4 border-b border-gray-200">
                <span class="text-gray-600 font-medium">Nama</span>
                <span class="text-gray-900 font-semibold">{{ $warga->nama }}</span>
            </div>
            <div class="flex justify-between items-start pb-4 border-b border-gray-200">
                <span class="text-gray-600 font-medium">Alamat</span>
                <span class="text-gray-900 font-semibold text-right max-w-xs">{{ $warga->alamat }}</span>
            </div>
            <div class="flex justify-between items-start">
                <span class="text-gray-600 font-medium">Telepon</span>
                <span class="text-gray-900 font-semibold">{{ $warga->no_telepon ?? '-' }}</span>
            </div>
        </div>
    </div>

    <!-- Statistics Card -->
    <div class="space-y-6">
        <!-- Total Transaksi -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-green-200 via-emerald-200 to-green-200/50 rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative bg-white rounded-3xl p-8 shadow-md hover:shadow-xl card-hover border border-gray-200/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-green-600 uppercase tracking-widest mb-2">Total Transaksi</p>
                        <h3 class="text-4xl font-black text-gray-900">{{ $warga->transaksiSampah()->count() }}</h3>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-emerald-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-exchange-alt text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Berat -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-blue-200 via-cyan-200 to-blue-200/50 rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative bg-white rounded-3xl p-8 shadow-md hover:shadow-xl card-hover border border-gray-200/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-blue-600 uppercase tracking-widest mb-2">Total Berat Sampah</p>
                        <h3 class="text-4xl font-black text-gray-900">{{ number_format($totalBerat, 1) }}<span class="text-xl text-blue-600 font-semibold"> kg</span></h3>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-weight text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Harga -->
        <div class="group relative">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-200 via-pink-200 to-purple-200/50 rounded-3xl blur-xl opacity-50 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative bg-white rounded-3xl p-8 shadow-md hover:shadow-xl card-hover border border-gray-200/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-black text-purple-600 uppercase tracking-widest mb-2">Total Harga</p>
                        <h3 class="text-4xl font-black text-gray-900">Rp <span class="text-xl text-purple-600 font-semibold">{{ number_format($totalHarga / 1000000, 1) }}J</span></h3>
                    </div>
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-hand-holding-usd text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="bg-white rounded-3xl shadow-md border border-gray-200/50 overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s;">
    <div class="p-8 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
        <h3 class="text-xl font-black text-gray-900">Transaksi Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="border-b border-gray-200 bg-gray-50">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Tanggal</th>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Kategori</th>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Berat (kg)</th>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Harga</th>
                    <th class="px-6 py-4 text-left text-sm font-black text-gray-900">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($transaksi as $t)
                <tr class="hover:bg-green-50/30 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $t->tanggal_transaksi->format('d M Y • H:i') }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $t->kategoriSampah->nama_kategori ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">{{ number_format($t->berat_kg, 2) }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">Rp {{ number_format($t->total_harga, 0) }}</td>
                    <td class="px-6 py-4 text-sm">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $t->status_penjualan === 'terjual' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ ucfirst($t->status_penjualan) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 font-medium">Belum ada transaksi</p>
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
