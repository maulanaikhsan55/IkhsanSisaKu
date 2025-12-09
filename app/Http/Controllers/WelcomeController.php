<?php

namespace App\Http\Controllers;

use App\Models\TransaksiSampah;
use App\Models\ArusKas;
use App\Models\Warga;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Total Sampah (sum of berat_kg from transaksi_sampah)
        $totalSampah = TransaksiSampah::sum('berat_kg');

        // Kas Masuk (sum of jumlah from arus_kas where jenis_transaksi = 'masuk')
        $kasMasuk = ArusKas::where('jenis_transaksi', 'masuk')->sum('jumlah');

        // Total Warga (count of warga)
        $totalWarga = Warga::count();

        // CO₂e Dikurangi (sum of co2_tersimpan from transaksi_sampah)
        $co2Dikurangi = TransaksiSampah::sum('co2_tersimpan');

        return view('welcome', compact('totalSampah', 'kasMasuk', 'totalWarga', 'co2Dikurangi'));
    }
}
