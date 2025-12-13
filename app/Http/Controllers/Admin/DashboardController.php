<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KarangTaruna;
use App\Models\TransaksiSampah;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKarangTaruna = KarangTaruna::where('status', 'aktif')->count();
        // Total Sampah dari semua transaksi yang sudah terjual
        $totalSampahKg = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.status_penjualan', 'sudah_terjual')
            ->sum('transaksi_sampah_items.berat_kg');

        // Total CO2 tersimpan dari transaksi yang sudah terjual
        $totalCO2 = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.status_penjualan', 'sudah_terjual')
            ->sum('transaksi_sampah_items.co2_tersimpan');
        $totalKasMasuk = DB::table('arus_kas')
            ->where('jenis_transaksi', 'masuk')
            ->sum('jumlah');
        $totalKasKeluar = DB::table('arus_kas')
            ->where('jenis_transaksi', 'keluar')
            ->sum('jumlah');
        $totalKasBersih = $totalKasMasuk - $totalKasKeluar;

        // Tren sampah 6 bulan terakhir dari transaksi yang sudah terjual
        $sampahTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulan = $date->format('M');
            $total = DB::table('transaksi_sampah_items')
                ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
                ->where('transaksi_sampah.status_penjualan', 'sudah_terjual')
                ->whereYear('transaksi_sampah.tanggal_transaksi', $date->year)
                ->whereMonth('transaksi_sampah.tanggal_transaksi', $date->month)
                ->sum('transaksi_sampah_items.berat_kg');
            $sampahTrend[$bulan] = round($total, 2);
        }

        // Distribusi sampah per kategori dari transaksi yang sudah terjual
        $sampahByKategori = DB::table('transaksi_sampah_items')
            ->selectRaw('kategori_sampah.nama_kategori, SUM(transaksi_sampah_items.berat_kg) as total_kg')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->join('kategori_sampah', 'transaksi_sampah_items.kategori_sampah_id', '=', 'kategori_sampah.id')
            ->where('transaksi_sampah.status_penjualan', 'sudah_terjual')
            ->groupBy('kategori_sampah.id', 'kategori_sampah.nama_kategori')
            ->orderBy('total_kg', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_kategori' => $item->nama_kategori,
                    'total_kg' => round($item->total_kg, 2),
                ];
            })
            ->toArray();

        // Top performer karang taruna dari transaksi yang sudah terjual
        $topPerformerData = DB::table('karang_taruna')
            ->selectRaw('karang_taruna.id, karang_taruna.nama_karang_taruna, karang_taruna.rw, COALESCE(SUM(transaksi_sampah_items.berat_kg), 0) as total_sampah')
            ->leftJoin('transaksi_sampah', 'karang_taruna.id', '=', 'transaksi_sampah.karang_taruna_id')
            ->leftJoin('transaksi_sampah_items', 'transaksi_sampah.id', '=', 'transaksi_sampah_items.transaksi_sampah_id')
            ->where('transaksi_sampah.status_penjualan', 'sudah_terjual')
            ->groupBy('karang_taruna.id', 'karang_taruna.nama_karang_taruna', 'karang_taruna.rw')
            ->orderBy('total_sampah', 'desc')
            ->limit(3)
            ->get();

        // Format top performers with ranking
        $topPerformers = $topPerformerData->map(function ($item, $index) {
            return [
                'rank' => $index + 1,
                'nama_karang_taruna' => $item->nama_karang_taruna,
                'rw' => $item->rw,
                'total_sampah' => round($item->total_sampah ?? 0, 1),
            ];
        })->toArray();

        return view('admin.dashboard', compact(
            'totalKarangTaruna',
            'totalSampahKg',
            'totalCO2',
            'totalKasMasuk',
            'totalKasKeluar',
            'totalKasBersih',
            'sampahTrend',
            'sampahByKategori',
            'topPerformers'
        ));
    }
}