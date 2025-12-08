@forelse($arusKas as $kas)
<tr class="hover:bg-green-100/50 transition-all duration-200 border-b border-gray-200 kas-row cursor-pointer" data-jenis="{{ $kas->jenis_transaksi }}">
    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
        {{ $kas->tanggal_transaksi->format('d M Y') }}
    </td>
    <td class="px-6 py-4 text-sm">
        @if($kas->jenis_transaksi === 'masuk')
        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
            <i class="fas fa-arrow-down mr-1"></i>Masuk
        </span>
        @else
        <span class="inline-block px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
            <i class="fas fa-arrow-up mr-1"></i>Keluar
        </span>
        @endif
    </td>
    <td class="px-6 py-4 text-sm">
        <span class="inline-block px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
            {{ $kas->kategoriKeuangan->nama_kategori }}
        </span>
    </td>
    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
        {{ $kas->deskripsi ?? '-' }}
    </td>
    <td class="px-6 py-4 text-sm text-right font-semibold" data-jenis-type="{{ $kas->jenis_transaksi }}">
        @if($kas->jenis_transaksi === 'masuk')
        <span class="text-green-600">+ Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
        @else
        <span class="text-red-600">- Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
        @endif
    </td>
    <td class="px-6 py-4 text-center">
        <div class="flex items-center justify-center gap-2">
            <a href="{{ route('karang-taruna.arus-kas.edit', $kas) }}"
               class="p-1.5 sm:p-2 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors text-xs sm:text-sm"
               title="Edit">
                <i class="fas fa-edit"></i>
            </a>
            <button onclick="deleteArusKas({{ $kas->id }})"
                    class="p-1.5 sm:p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors text-xs sm:text-sm"
                    title="Hapus">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="px-6 py-12 text-center">
        <div class="flex flex-col items-center justify-center">
            <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 font-medium">Belum ada transaksi kas</p>
            <p class="text-sm text-gray-400 mt-1">Mulai dengan menambahkan transaksi baru</p>
        </div>
    </td>
</tr>
@endforelse
