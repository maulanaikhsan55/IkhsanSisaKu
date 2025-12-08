<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Warga</title>
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
        <h1>Daftar Warga</h1>
        <p>{{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="info">
        <div class="info-row"><strong>Karang Taruna:</strong> {{ $karangTaruna->nama_karang_taruna }} (RW {{ $karangTaruna->rw }})</div>
        <div class="info-row"><strong>Pengelola:</strong> {{ $karangTaruna->nama_lengkap ?? '-' }}</div>
        <div class="info-row"><strong>No. Telf:</strong> {{ $karangTaruna->no_telp ?? '-' }}</div>
    </div>

    @if($search || $address)
    <div class="info" style="border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9;">
        <div class="info-row"><strong>Filter yang diterapkan:</strong></div>
        @if($search)
        <div class="info-row">Nama: {{ $search }}</div>
        @endif
        @if($address)
        <div class="info-row">Alamat: {{ $address }}</div>
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. Telepon</th>
                <th>Tanggal Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($warga as $index => $w)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $w->nama }}</td>
                <td>{{ Str::limit($w->alamat, 30) }}</td>
                <td>{{ $w->no_telepon ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($w->created_at)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Tidak ada data warga</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item">
            <span class="summary-label">Total Warga:</span>
            <span class="summary-value">{{ $warga->count() }} orang</span>
        </div>
    </div>
</body>
</html>
