<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Karang Taruna - SisaKu</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .container {
            padding: 30px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4CAF50;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4CAF50;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .header p {
            color: #666;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table thead {
            background-color: #4CAF50;
            color: white;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            font-weight: bold;
        }
        table td {
            padding: 10px 12px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-aktif {
            color: #4CAF50;
            font-weight: bold;
        }
        .status-nonaktif {
            color: #dc2626;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #999;
            font-size: 11px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Laporan Kelola Karang Taruna</h1>
            <p>Data Karang Taruna - {{ date('d F Y') }}</p>
        </div>

        <!-- Data Table -->
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>RW</th>
                    <th>Nama Unit</th>
                    <th>Total Warga</th>
                    <th>Total Sampah (kg)</th>
                    <th>Kas Masuk</th>
                    <th>Kas Keluar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dataKarangTaruna as $key => $kt)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $kt['rw'] }}</td>
                    <td>{{ $kt['nama_unit'] }}</td>
                    <td>{{ $kt['total_warga'] }} orang</td>
                    <td>{{ number_format($kt['total_sampah'], 2) }}</td>
                    <td>Rp {{ number_format($kt['kas_masuk'], 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($kt['kas_keluar'], 0, ',', '.') }}</td>
                    <td class="status-{{ $kt['status'] }}">{{ ucfirst($kt['status']) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>Laporan ini dibuat otomatis dari sistem SisaKu pada {{ date('d F Y H:i') }}</p>
            <p>© 2025 SisaKu - Sistem Manajemen Sampah Karang Taruna</p>
        </div>
    </div>
</body>
</html>