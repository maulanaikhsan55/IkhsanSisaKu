<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransaksiSampah;
use App\Models\ArusKas;
use App\Models\KarangTaruna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    /**
     * Apply common date and karang taruna filters to a query
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('karang_taruna_id') && $request->karang_taruna_id !== 'all') {
            $query->where('karang_taruna_id', $request->karang_taruna_id);
        }

        if ($request->filled('start_date')) {
            $query->where('tanggal_transaksi', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('tanggal_transaksi', '<=', $request->end_date . ' 23:59:59');
        }

        return $query;
    }

    public function index()
    {
        return redirect()->route('admin.laporan.arus-kas');
    }

    public function arusKas(Request $request)
    {
        $query = ArusKas::with(['karangTaruna', 'kategoriKeuangan']);
        $query = $this->applyFilters($query, $request);

        $arusKas = $query->orderBy('tanggal_transaksi', 'desc')->paginate(5);

        // Calculate totals for summary cards
        $queryMasuk = ArusKas::where('jenis_transaksi', 'masuk');
        $queryMasuk = $this->applyFilters($queryMasuk, $request);
        $totalMasuk = $queryMasuk->sum('jumlah');

        $queryKeluar = ArusKas::where('jenis_transaksi', 'keluar');
        $queryKeluar = $this->applyFilters($queryKeluar, $request);
        $totalKeluar = $queryKeluar->sum('jumlah');

        // Get all Karang Taruna for filter dropdown
        $karangTarunas = KarangTaruna::orderBy('rw', 'asc')->get();

        return view('admin.laporan.arus-kas', compact('arusKas', 'karangTarunas', 'totalMasuk', 'totalKeluar'));
    }

    public function dampakLingkungan(Request $request)
    {
        // Build base query for transactions to apply filters
        $transQuery = TransaksiSampah::with(['karangTaruna', 'kategoriSampah']);
        $transQuery = $this->applyFilters($transQuery, $request);
        $transaksiIds = (clone $transQuery)->pluck('id');

        // Get totals from items
        $itemsQuery = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds);
        
        $totalSampah = (clone $itemsQuery)->sum('berat_kg');
        $totalCO2 = (clone $itemsQuery)->sum('co2_tersimpan');

        // Dampak per Karang Taruna
        $dampakPerRW = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->whereIn('transaksi_sampah.id', $transaksiIds)
            ->selectRaw('transaksi_sampah.karang_taruna_id, SUM(transaksi_sampah_items.berat_kg) as total_sampah, SUM(transaksi_sampah_items.co2_tersimpan) as total_co2, COUNT(DISTINCT transaksi_sampah.id) as total_transaksi')
            ->groupBy('transaksi_sampah.karang_taruna_id')
            ->orderByDesc('total_sampah')
            ->get()
            ->map(function ($item) {
                $karangTaruna = KarangTaruna::find($item->karang_taruna_id);
                return (object)[
                    'karang_taruna_id' => $item->karang_taruna_id,
                    'total_sampah' => $item->total_sampah,
                    'total_co2' => $item->total_co2,
                    'total_transaksi' => $item->total_transaksi,
                    'karangTaruna' => $karangTaruna,
                ];
            });

        // Get all Karang Taruna for filter dropdown
        $karangTarunas = KarangTaruna::orderBy('rw', 'asc')->get();

        return view('admin.laporan.dampak-lingkungan', compact('totalSampah', 'totalCO2', 'dampakPerRW', 'karangTarunas'));
    }

    public function exportArusKasPdf(Request $request)
    {
        $query = ArusKas::with(['karangTaruna', 'kategoriKeuangan']);
        $query = $this->applyFilters($query, $request);

        $arusKas = $query->orderBy('tanggal_transaksi', 'desc')->get();

        $queryMasuk = ArusKas::where('jenis_transaksi', 'masuk');
        $queryMasuk = $this->applyFilters($queryMasuk, $request);
        $totalMasuk = $queryMasuk->sum('jumlah');

        $queryKeluar = ArusKas::where('jenis_transaksi', 'keluar');
        $queryKeluar = $this->applyFilters($queryKeluar, $request);
        $totalKeluar = $queryKeluar->sum('jumlah');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.arus-kas-pdf', compact('arusKas', 'totalMasuk', 'totalKeluar'));
        return $pdf->download('laporan-arus-kas-' . date('Y-m-d H:i:s') . '.pdf');
    }

    public function exportDampakPdf(Request $request)
    {
        // Build base query for transactions to apply filters
        $transQuery = TransaksiSampah::with(['karangTaruna', 'kategoriSampah']);
        $transQuery = $this->applyFilters($transQuery, $request);
        $transaksiIds = (clone $transQuery)->pluck('id');

        // Get totals from items
        $itemsQuery = DB::table('transaksi_sampah_items')
            ->whereIn('transaksi_sampah_id', $transaksiIds);
        
        $totalSampah = (clone $itemsQuery)->sum('berat_kg');
        $totalCO2 = (clone $itemsQuery)->sum('co2_tersimpan');

        // Dampak per Karang Taruna
        $dampakPerRW = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->whereIn('transaksi_sampah.id', $transaksiIds)
            ->selectRaw('transaksi_sampah.karang_taruna_id, SUM(transaksi_sampah_items.berat_kg) as total_sampah, SUM(transaksi_sampah_items.co2_tersimpan) as total_co2, COUNT(DISTINCT transaksi_sampah.id) as total_transaksi')
            ->groupBy('transaksi_sampah.karang_taruna_id')
            ->orderByDesc('total_sampah')
            ->get()
            ->map(function ($item) {
                $karangTaruna = KarangTaruna::find($item->karang_taruna_id);
                return (object)[
                    'karang_taruna_id' => $item->karang_taruna_id,
                    'total_sampah' => $item->total_sampah,
                    'total_co2' => $item->total_co2,
                    'total_transaksi' => $item->total_transaksi,
                    'karangTaruna' => $karangTaruna,
                ];
            });

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.laporan.dampak-lingkungan-pdf', compact('totalSampah', 'totalCO2', 'dampakPerRW'));
        return $pdf->download('laporan-dampak-lingkungan-' . date('Y-m-d H:i:s') . '.pdf');
    }
}