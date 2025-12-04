<?php

namespace App\Http\Controllers\KarangTaruna;

use App\Http\Controllers\Controller;
use App\Models\ArusKas;
use App\Models\TransaksiSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function arusKas(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $bulan = date('Y-m', strtotime($startDate));
        } else {
            $bulan = $request->query('bulan') ? date('Y-m', strtotime($request->query('bulan'))) : now()->format('Y-m');
            $startDate = $bulan.'-01';
            $endDate = date('Y-m-t', strtotime($startDate));
        }

        $tahun = substr($bulan, 0, 4);
        $bulanNum = substr($bulan, 5, 2);

        $kasmasuk = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'masuk')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $kasKeluar = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'keluar')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $totalMasuk = $kasmasuk->sum('jumlah');
        $totalKeluar = $kasKeluar->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        $summary = [
            'bulan' => $bulan,
            'bulan_nama' => $this->getNamaBulan($bulanNum),
            'tahun' => $tahun,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo' => $saldo,
        ];

        return view('karang-taruna.reports.arus-kas', compact('kasmasuk', 'kasKeluar', 'summary'));
    }

    public function dampakLingkungan(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
            $bulan = date('Y-m', strtotime($startDate));
        } else {
            $bulan = $request->query('bulan') ? date('Y-m', strtotime($request->query('bulan'))) : now()->format('Y-m');
            $startDate = $bulan.'-01';
            $endDate = date('Y-m-t', strtotime($startDate));
        }

        $tahun = substr($bulan, 0, 4);
        $bulanNum = substr($bulan, 5, 2);

        $transaksi = TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with(['warga', 'kategoriSampah', 'items.kategoriSampah'])
            ->get();

        $transaksiIds = $transaksi->pluck('id');

        $totalBerat = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->sum('berat_kg');
        $totalCo2 = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->sum('co2_tersimpan');

        $byCategory = DB::table('transaksi_sampah_items')
            ->join('kategori_sampah', 'transaksi_sampah_items.kategori_sampah_id', '=', 'kategori_sampah.id')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->selectRaw('kategori_sampah.id as kategori_id, kategori_sampah.nama_kategori as kategori, SUM(transaksi_sampah_items.berat_kg) as total_berat, SUM(transaksi_sampah_items.co2_tersimpan) as total_co2, COUNT(DISTINCT transaksi_sampah_items.transaksi_sampah_id) as jumlah_transaksi')
            ->groupBy('kategori_sampah.id', 'kategori_sampah.nama_kategori')
            ->orderByDesc('total_berat')
            ->get()
            ->map(function ($item) {
                return [
                    'kategori_id' => $item->kategori_id,
                    'kategori' => $item->kategori,
                    'total_berat' => $item->total_berat,
                    'total_co2' => $item->total_co2,
                    'jumlah_transaksi' => $item->jumlah_transaksi,
                ];
            });

        $jumlahTransaksi = $transaksi->count();
        $jumlahWarga = $transaksi->pluck('warga_id')->unique()->count();

        $summary = [
            'bulan' => $bulan,
            'bulan_nama' => $this->getNamaBulan($bulanNum),
            'tahun' => $tahun,
            'total_berat' => $totalBerat,
            'total_co2' => $totalCo2,
            'jumlah_transaksi' => $jumlahTransaksi,
            'jumlah_warga' => $jumlahWarga,
        ];

        return view('karang-taruna.reports.dampak-lingkungan', compact('transaksi', 'byCategory', 'summary'));
    }

    public function exportArusKasPdf(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;
        $bulan = $request->query('bulan') ? date('Y-m', strtotime($request->query('bulan'))) : now()->format('Y-m');
        $tahun = substr($bulan, 0, 4);
        $bulanNum = substr($bulan, 5, 2);

        $startDate = $bulan.'-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $kasmasuk = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'masuk')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan')
            ->get();

        $kasKeluar = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'keluar')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan')
            ->get();

        $totalMasuk = $kasmasuk->sum('jumlah');
        $totalKeluar = $kasKeluar->sum('jumlah');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('karang-taruna.reports.arus-kas-pdf', compact('kasmasuk', 'kasKeluar', 'totalMasuk', 'totalKeluar', 'karangTaruna'));

        return $pdf->download('laporan-arus-kas-'.date('Y-m-d H:i:s').'.pdf');
    }

    public function exportDampakLingkunganPdf(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;
        $bulan = $request->query('bulan') ? date('Y-m', strtotime($request->query('bulan'))) : now()->format('Y-m');
        $tahun = substr($bulan, 0, 4);
        $bulanNum = substr($bulan, 5, 2);

        $startDate = $bulan.'-01';
        $endDate = date('Y-m-t', strtotime($startDate));

        $transaksi = TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with(['warga', 'kategoriSampah', 'items.kategoriSampah'])
            ->get();

        $transaksiIds = $transaksi->pluck('id');

        $totalBerat = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->sum('berat_kg');
        $totalCo2 = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->sum('co2_tersimpan');

        $byCategory = DB::table('transaksi_sampah_items')
            ->join('kategori_sampah', 'transaksi_sampah_items.kategori_sampah_id', '=', 'kategori_sampah.id')
            ->whereIn('transaksi_sampah_id', $transaksiIds)
            ->selectRaw('kategori_sampah.id as kategori_id, kategori_sampah.nama_kategori as kategori, SUM(transaksi_sampah_items.berat_kg) as total_berat, SUM(transaksi_sampah_items.co2_tersimpan) as total_co2, COUNT(DISTINCT transaksi_sampah_items.transaksi_sampah_id) as jumlah_transaksi')
            ->groupBy('kategori_sampah.id', 'kategori_sampah.nama_kategori')
            ->orderByDesc('total_berat')
            ->get()
            ->map(function ($item) {
                return [
                    'kategori_id' => $item->kategori_id,
                    'kategori' => $item->kategori,
                    'total_berat' => $item->total_berat,
                    'total_co2' => $item->total_co2,
                    'jumlah_transaksi' => $item->jumlah_transaksi,
                ];
            });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('karang-taruna.reports.dampak-lingkungan-pdf', compact('totalBerat', 'totalCo2', 'byCategory', 'karangTaruna'));

        return $pdf->download('laporan-dampak-lingkungan-'.date('Y-m-d H:i:s').'.pdf');
    }

    private function getNamaBulan($bulanNum)
    {
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        return $bulan[$bulanNum] ?? '';
    }
}
