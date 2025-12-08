@foreach($paginatedTransactions as $kas)
<tr class="kas-row border-b border-gray-200 cursor-pointer" data-jenis="{{ $kas->jenis }}">
    <td class="px-6 py-4 text-sm text-gray-900 font-semibold">
        {{ $kas->tanggal->format('d M Y') }}
    </td>
    <td class="px-6 py-4 text-sm">
        @if($kas->jenis === 'masuk')
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
            {{ $kas->kategori }}
        </span>
    </td>
    <td class="px-6 py-4 text-sm text-gray-600">
        {{ Str::limit($kas->deskripsi ?? '-', 30) }}
    </td>
    <td class="px-6 py-4 text-sm text-right font-semibold" data-jenis-type="{{ $kas->jenis }}">
        @if($kas->jenis === 'masuk')
        <span class="text-green-600">+ Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
        @else
        <span class="text-red-600">- Rp {{ number_format($kas->jumlah, 0, ',', '.') }}</span>
        @endif
    </td>
</tr>
@endforeach
