<?php

namespace App\Http\Controllers;

use App\Models\KarangTaruna;
use App\Models\Warga;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index()
    {
        // Total Sampah dari transaksi yang sudah terjual
        $totalSampahKg = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.status_penjualan', 'sudah_terjual')
            ->sum('transaksi_sampah_items.berat_kg');

        // Total Kas Masuk
        $totalKasMasuk = DB::table('arus_kas')
            ->where('jenis_transaksi', 'masuk')
            ->sum('jumlah');

        // Total Warga
        $totalWarga = Warga::count();

        // Total CO2 tersimpan dari transaksi yang sudah terjual
        $totalCO2 = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.status_penjualan', 'sudah_terjual')
            ->sum('transaksi_sampah_items.co2_tersimpan');

        // Total Dampak Lingkungan (Pohon Setara) - 1 pohon absorbs ~21kg CO2/year
        $totalDampakLingkungan = round($totalCO2 / 21);

        return view('welcome', compact(
            'totalSampahKg',
            'totalKasMasuk',
            'totalWarga',
            'totalCO2',
            'totalDampakLingkungan'
        ));
    }
}
