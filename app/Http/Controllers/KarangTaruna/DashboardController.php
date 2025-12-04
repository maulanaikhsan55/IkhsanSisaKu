<?php

namespace App\Http\Controllers\KarangTaruna;

use App\Http\Controllers\Controller;
use App\Models\ArusKas;
use App\Models\TransaksiSampah;
use App\Models\Warga;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $karangTaruna = auth()->user()->karangTaruna;

        // Get transaction IDs for this KT
        $transaksiIds = TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)->pluck('id');

        // Stats for dashboard cards - Query from items table
        $stats = [
            'sampah_hari_ini' => DB::table('transaksi_sampah_items')
                ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
                ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
                ->whereDate('transaksi_sampah.tanggal_transaksi', today())
                ->sum('transaksi_sampah_items.berat_kg'),

            'pendapatan_hari_ini' => DB::table('transaksi_sampah_items')
                ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
                ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
                ->whereDate('transaksi_sampah.tanggal_transaksi', today())
                ->sum('transaksi_sampah_items.total_harga'),

            'transaksi_hari_ini' => TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)
                ->whereDate('tanggal_transaksi', today())
                ->count(),

            'sampah_bulan_ini' => DB::table('transaksi_sampah_items')
                ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
                ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
                ->whereYear('transaksi_sampah.tanggal_transaksi', now()->year)
                ->whereMonth('transaksi_sampah.tanggal_transaksi', now()->month)
                ->sum('transaksi_sampah_items.berat_kg'),

            'co2_bulan_ini' => DB::table('transaksi_sampah_items')
                ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
                ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
                ->whereYear('transaksi_sampah.tanggal_transaksi', now()->year)
                ->whereMonth('transaksi_sampah.tanggal_transaksi', now()->month)
                ->sum('transaksi_sampah_items.co2_tersimpan'),

            'pendapatan_bulan_ini' => DB::table('transaksi_sampah_items')
                ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
                ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
                ->whereYear('transaksi_sampah.tanggal_transaksi', now()->year)
                ->whereMonth('transaksi_sampah.tanggal_transaksi', now()->month)
                ->sum('transaksi_sampah_items.total_harga'),

            'transaksi_bulan_ini' => TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)
                ->whereYear('tanggal_transaksi', now()->year)
                ->whereMonth('tanggal_transaksi', now()->month)
                ->count(),

            'target_bulanan' => $this->calculateMonthlyTarget($karangTaruna->id),
        ];

        // Recent transactions for dashboard
        $recentTransactions = TransaksiSampah::with(['warga', 'kategoriSampah', 'items.kategoriSampah'])
            ->where('karang_taruna_id', $karangTaruna->id)
            ->whereNotNull('warga_id')
            ->latest('tanggal_transaksi')
            ->limit(5)
            ->get();

        // Legacy stats for backward compatibility - Query from items table
        $totalSampah = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->sum('berat_kg');

        $totalKasMasuk = ArusKas::where('karang_taruna_id', $karangTaruna->id)->where('jenis_transaksi', 'masuk')->sum('jumlah');
        $totalKasKeluar = ArusKas::where('karang_taruna_id', $karangTaruna->id)->where('jenis_transaksi', 'keluar')->sum('jumlah');
        $saldoAkhir = $totalKasMasuk - $totalKasKeluar;
        $totalWarga = Warga::where('karang_taruna_id', $karangTaruna->id)->count();

        $totalCO2 = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->sum('co2_tersimpan');

        $totalTransaksi = TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)->count();

        $sampahBelumTerjual = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
            ->where('transaksi_sampah.status_penjualan', 'belum_terjual')
            ->sum('transaksi_sampah_items.berat_kg');

        $arusKasBulanan = ArusKas::select(
            DB::raw('DATE_FORMAT(tanggal_transaksi, "%Y-%m") as bulan'),
            DB::raw('MONTHNAME(tanggal_transaksi) as nama_bulan'),
            DB::raw('SUM(CASE WHEN jenis_transaksi = "masuk" THEN jumlah ELSE 0 END) as total_masuk'),
            DB::raw('SUM(CASE WHEN jenis_transaksi = "keluar" THEN jumlah ELSE 0 END) as total_keluar')
        )
        ->where('karang_taruna_id', $karangTaruna->id)
        ->where('tanggal_transaksi', '>=', now()->subMonths(6))
        ->groupBy('bulan', 'nama_bulan')
        ->orderBy('bulan', 'asc')
        ->get();

        $transaksiTerbaru = TransaksiSampah::with(['warga', 'kategoriSampah', 'items.kategoriSampah'])
            ->where('karang_taruna_id', $karangTaruna->id)
            ->whereNotNull('warga_id')
            ->orderBy('tanggal_transaksi', 'desc')
            ->limit(10)
            ->get();

        $topWarga = Warga::where('karang_taruna_id', $karangTaruna->id)
            ->withSum('transaksiSampah', 'berat_kg')
            ->orderBy('transaksi_sampah_sum_berat_kg', 'desc')
            ->limit(5)
            ->get();

        // Chart data - 6 months trend
        $sampahTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulan = $date->format('M');
            $total = DB::table('transaksi_sampah_items')
                ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
                ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
                ->whereYear('transaksi_sampah.tanggal_transaksi', $date->year)
                ->whereMonth('transaksi_sampah.tanggal_transaksi', $date->month)
                ->sum('transaksi_sampah_items.berat_kg');
            $sampahTrend[$bulan] = round($total, 2);
        }

        // Pie chart data - waste distribution by category
        $sampahByKategori = DB::table('transaksi_sampah_items')
            ->selectRaw('kategori_sampah.nama_kategori, SUM(transaksi_sampah_items.berat_kg) as total_kg')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->join('kategori_sampah', 'transaksi_sampah_items.kategori_sampah_id', '=', 'kategori_sampah.id')
            ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
            ->groupBy('kategori_sampah.id', 'kategori_sampah.nama_kategori')
            ->orderBy('total_kg', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_kategori' => $item->nama_kategori,
                    'total_kg' => round($item->total_kg, 1),
                ];
            })
            ->toArray();

        // Greeting message
        $hour = now()->hour;
        if ($hour < 12) {
            $greeting = 'Selamat Pagi';
            $message = 'Semangat untuk hari yang produktif! Mari tingkatkan target sampah hari ini.';
        } elseif ($hour < 15) {
            $greeting = 'Selamat Siang';
            $message = 'Ayo lanjutkan kerja keras! Lihat kemajuan terkini di dashboard.';
        } elseif ($hour < 18) {
            $greeting = 'Selamat Sore';
            $message = 'Terima kasih atas dedikasi hari ini! Raih kesempatan untuk melebihi target.';
        } else {
            $greeting = 'Selamat Malam';
            $message = 'Istirahat yang berkualitas untuk besok! Periksa ringkasan hari ini.';
        }

        return view('karang-taruna.dashboard', compact(
            'stats',
            'recentTransactions',
            'karangTaruna',
            'totalSampah',
            'totalKasMasuk',
            'totalKasKeluar',
            'saldoAkhir',
            'totalWarga',
            'totalCO2',
            'totalTransaksi',
            'sampahBelumTerjual',
            'arusKasBulanan',
            'transaksiTerbaru',
            'topWarga',
            'sampahTrend',
            'sampahByKategori',
            'greeting',
            'message'
        ));
    }

    private function calculateMonthlyTarget($karangTarunaId)
    {
        // Calculate monthly target based on current month progress
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $monthlyTransactions = TransaksiSampah::where('karang_taruna_id', $karangTarunaId)
            ->whereYear('tanggal_transaksi', $currentYear)
            ->whereMonth('tanggal_transaksi', $currentMonth)
            ->count();

        // Assume target is 100 transactions per month
        $target = 100;
        $progress = min(($monthlyTransactions / $target) * 100, 100);

        return round($progress);
    }
}