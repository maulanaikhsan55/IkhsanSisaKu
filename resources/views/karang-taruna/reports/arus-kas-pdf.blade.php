<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Arus Kas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        .info { margin-bottom: 15px; font-size: 11px; }
        .info-row { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table thead { background-color: #f0f0f0; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .summary { margin-top: 20px; }
        .summary-item { margin: 10px 0; padding: 10px; background-color: #f9f9f9; border-left: 3px solid #16A34A; }
        .summary-label { font-weight: bold; }
        .summary-value { font-size: 14px; color: #16A34A; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Arus Kas</h1>
        <p>{{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info">
        <div class="info-row"><strong>Karang Taruna:</strong> {{ $karangTaruna->nama_karang_taruna }} (RW {{ $karangTaruna->rw }})</div>
        <div class="info-row"><strong>Pengelola:</strong> {{ $karangTaruna->nama_lengkap ?? '-' }}</div>
        <div class="info-row"><strong>No. Telf:</strong> {{ $karangTaruna->no_telp ?? '-' }}</div>
    </div>

    <div class="title" style="font-weight: bold; font-size: 13px; margin: 15px 0 10px 0;">Kas Masuk</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kasmasuk as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y') }}</td>
                <td>{{ $item->kategoriKeuangan->nama_kategori ?? '-' }}</td>
                <td>{{ Str::limit($item->deskripsi ?? '-', 25) }}</td>
                <td style="text-align: right;">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada kas masuk</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="title" style="font-weight: bold; font-size: 13px; margin: 15px 0 10px 0;">Kas Keluar</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kasKeluar as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d/m/Y') }}</td>
                <td>{{ $item->kategoriKeuangan->nama_kategori ?? '-' }}</td>
                <td>{{ Str::limit($item->deskripsi ?? '-', 25) }}</td>
                <td style="text-align: right;">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada kas keluar</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Kas Masuk:</span>
            <span class="summary-value">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Total Kas Keluar:</span>
            <span class="summary-value">Rp {{ number_format($totalKeluar, 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Saldo Bersih:</span>
            <span class="summary-value">Rp {{ number_format($totalMasuk - $totalKeluar, 0, ',', '.') }}</span>
        </div>
    </div>
</body>
</html>
