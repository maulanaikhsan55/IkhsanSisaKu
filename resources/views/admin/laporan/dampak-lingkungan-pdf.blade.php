<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Dampak Lingkungan</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; }
        .summary { margin: 20px 0; }
        .summary-item { margin: 10px 0; padding: 10px; background-color: #f0f0f0; border-left: 3px solid #16A34A; }
        .summary-label { font-weight: bold; }
        .summary-value { font-size: 14px; color: #16A34A; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table thead { background-color: #f0f0f0; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table th { font-weight: bold; }
        .title { font-weight: bold; font-size: 14px; margin-top: 20px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Dampak Lingkungan</h1>
        <p>{{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Sampah Terkumpul:</span>
            <span class="summary-value">{{ number_format($totalSampah, 2, ',', '.') }} kg</span>
        </div>
        <div class="summary-item">
            <span class="summary-label">Total CO₂e Berkurang:</span>
            <span class="summary-value">{{ number_format($totalCO2, 2, ',', '.') }} kg CO₂e</span>
        </div>
    </div>

    <div class="title">Dampak per Karang Taruna</div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Karang Taruna (RW)</th>
                <th>Transaksi</th>
                <th>Total Sampah (kg)</th>
                <th>CO₂e Berkurang (kg)</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dampakPerRW as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->karangTaruna->nama_karang_taruna ?? '-' }} (RW {{ $item->karangTaruna->rw }})</td>
                <td>{{ $item->total_transaksi }}</td>
                <td>{{ number_format($item->total_sampah, 2, ',', '.') }}</td>
                <td>{{ number_format($item->total_co2, 2, ',', '.') }}</td>
                <td>{{ number_format(($item->total_sampah / $totalSampah) * 100, 2, ',', '.') }}%</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
