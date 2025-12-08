<?php

namespace App\Http\Controllers\KarangTaruna;

use App\Http\Controllers\Controller;
use App\Models\ArusKas;
use App\Models\KategoriKeuangan;
use App\Models\KategoriSampah;
use App\Models\TransaksiSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function arusKas(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;

        // Get date range
        $dateRange = $this->getDateRange($request);
        $startDate = $dateRange['start_date'];
        $endDate = $dateRange['end_date'];
        $bulan = $dateRange['bulan'];
        $tahun = $dateRange['tahun'];
        $bulanNum = $dateRange['bulan_num'];

        // Handle jenis filter
        $jenisFilter = $request->query('jenis', 'all');

        // Build queries
        $queries = $this->buildArusKasQueries($karangTaruna->id, $startDate, $endDate, $jenisFilter);
        $kasmasukAll = $queries['masuk']->get();
        $kasKeluarAll = $queries['keluar']->get();

        // Get summary data
        $summary = $this->getArusKasSummary($kasmasukAll, $kasKeluarAll, $bulan, $bulanNum, $tahun, $startDate, $endDate);

        // Get daily trend data
        $dailyTrendData = $this->getDailyArusKasTrend($karangTaruna->id, $startDate, $endDate);

        // Get categories for filtering
        $kategoris = $this->getArusKasCategories($karangTaruna->id);

        // Handle AJAX requests
        if ($request->ajax()) {
            return $this->handleArusKasAjaxRequest($request, $karangTaruna);
        }

        // Combine and paginate transactions for regular view
        $allTransactions = $this->combineArusKasTransactions($kasmasukAll, $kasKeluarAll);
        $paginatedTransactions = $this->paginateArusKasTransactions($allTransactions, $request);

        return view('karang-taruna.reports.arus-kas', compact('paginatedTransactions', 'summary', 'dailyTrendData', 'kategoris'));
    }

    private function getDateRange(Request $request): array
    {
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

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bulan_num' => $bulanNum,
        ];
    }

    private function buildArusKasQueries(int $karangTarunaId, string $startDate, string $endDate, string $jenisFilter): array
    {
        $kasmasukQuery = ArusKas::where('karang_taruna_id', $karangTarunaId)
            ->where('jenis_transaksi', 'masuk')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan');

        $kasKeluarQuery = ArusKas::where('karang_taruna_id', $karangTarunaId)
            ->where('jenis_transaksi', 'keluar')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan');

        // Apply jenis filter
        if ($jenisFilter === 'masuk') {
            $kasKeluarQuery->whereRaw('1 = 0'); // Return empty for keluar when filtering masuk only
        } elseif ($jenisFilter === 'keluar') {
            $kasmasukQuery->whereRaw('1 = 0'); // Return empty for masuk when filtering keluar only
        }

        return [
            'masuk' => $kasmasukQuery,
            'keluar' => $kasKeluarQuery,
        ];
    }

    private function getArusKasSummary($kasmasukAll, $kasKeluarAll, string $bulan, string $bulanNum, string $tahun, string $startDate, string $endDate): array
    {
        $totalMasuk = $kasmasukAll->sum('jumlah');
        $totalKeluar = $kasKeluarAll->sum('jumlah');
        $saldo = $totalMasuk - $totalKeluar;

        return [
            'bulan' => $bulan,
            'bulan_nama' => $this->getNamaBulan($bulanNum),
            'tahun' => $tahun,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_masuk' => $totalMasuk,
            'total_keluar' => $totalKeluar,
            'saldo' => $saldo,
        ];
    }

    private function getArusKasCategories(int $karangTarunaId)
    {
        return KategoriKeuangan::whereHas('arusKas', function ($query) use ($karangTarunaId) {
            $query->where('karang_taruna_id', $karangTarunaId);
        })->distinct()->get();
    }

    private function combineArusKasTransactions($kasmasukAll, $kasKeluarAll)
    {
        $allTransactions = collect();

        foreach($kasmasukAll as $kas) {
            $allTransactions->push((object)[
                'id' => $kas->id,
                'tanggal' => \Carbon\Carbon::parse($kas->tanggal_transaksi),
                'kategori' => $kas->kategoriKeuangan->nama_kategori,
                'deskripsi' => $kas->deskripsi,
                'jumlah' => $kas->jumlah,
                'jenis' => 'masuk',
                'type' => 'masuk'
            ]);
        }

        foreach($kasKeluarAll as $kas) {
            $allTransactions->push((object)[
                'id' => $kas->id,
                'tanggal' => \Carbon\Carbon::parse($kas->tanggal_transaksi),
                'kategori' => $kas->kategoriKeuangan->nama_kategori,
                'deskripsi' => $kas->deskripsi,
                'jumlah' => $kas->jumlah,
                'jenis' => 'keluar',
                'type' => 'keluar'
            ]);
        }

        // Sort by date descending
        return $allTransactions->sortByDesc('tanggal');
    }

    private function paginateArusKasTransactions($allTransactions, Request $request)
    {
        $currentPage = $request->query('page', 1);
        $perPage = 5;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $allTransactions->forPage($currentPage, $perPage),
            $allTransactions->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'pageName' => 'page']
        );
    }

    private function handleArusKasAjaxRequest(Request $request, $karangTaruna)
    {
        $search = $request->query('search', '');
        $jenis = $request->query('jenis', '');
        $kategori = $request->query('kategori', '');
        $startDate = $request->query('start_date', '');
        $endDate = $request->query('end_date', '');
        $page = $request->query('page', 1);

        // Build base queries
        $kasmasukQuery = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'masuk')
            ->with('kategoriKeuangan');

        $kasKeluarQuery = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'keluar')
            ->with('kategoriKeuangan');

        // Apply filters
        if ($jenis === 'masuk') {
            $kasKeluarQuery->whereRaw('1 = 0'); // No keluar transactions
        } elseif ($jenis === 'keluar') {
            $kasmasukQuery->whereRaw('1 = 0'); // No masuk transactions
        }

        if ($startDate && $endDate) {
            $kasmasukQuery->whereDate('tanggal_transaksi', '>=', $startDate)
                         ->whereDate('tanggal_transaksi', '<=', $endDate);
            $kasKeluarQuery->whereDate('tanggal_transaksi', '>=', $startDate)
                          ->whereDate('tanggal_transaksi', '<=', $endDate);
        }

        if ($search) {
            $kasmasukQuery->where('deskripsi', 'LIKE', '%' . $search . '%');
            $kasKeluarQuery->where('deskripsi', 'LIKE', '%' . $search . '%');
        }

        if ($kategori) {
            $kasmasukQuery->whereHas('kategoriKeuangan', function ($query) use ($kategori) {
                $query->where('nama_kategori', $kategori);
            });
            $kasKeluarQuery->whereHas('kategoriKeuangan', function ($query) use ($kategori) {
                $query->where('nama_kategori', $kategori);
            });
        }

        // Get filtered results
        $kasmasukFiltered = $kasmasukQuery->get();
        $kasKeluarFiltered = $kasKeluarQuery->get();

        // Combine transactions
        $allTransactions = collect();
        foreach($kasmasukFiltered as $kas) {
            $allTransactions->push((object)[
                'id' => $kas->id,
                'tanggal' => \Carbon\Carbon::parse($kas->tanggal_transaksi),
                'kategori' => $kas->kategoriKeuangan->nama_kategori ?? '-',
                'deskripsi' => $kas->deskripsi,
                'jumlah' => $kas->jumlah,
                'jenis' => 'masuk'
            ]);
        }
        foreach($kasKeluarFiltered as $kas) {
            $allTransactions->push((object)[
                'id' => $kas->id,
                'tanggal' => \Carbon\Carbon::parse($kas->tanggal_transaksi),
                'kategori' => $kas->kategoriKeuangan->nama_kategori ?? '-',
                'deskripsi' => $kas->deskripsi,
                'jumlah' => $kas->jumlah,
                'jenis' => 'keluar'
            ]);
        }

        // Sort by date descending
        $allTransactions = $allTransactions->sortByDesc(function($item) {
            return $item->tanggal;
        });

        // Paginate
        $perPage = 5;
        $paginatedTransactions = new \Illuminate\Pagination\LengthAwarePaginator(
            $allTransactions->forPage($page, $perPage),
            $allTransactions->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'pageName' => 'page']
        );

        $html = view('karang-taruna.reports.partials.table-rows', compact('paginatedTransactions'))->render();
        $pagination = (string) $paginatedTransactions->links('pagination.custom');

        return response()->json([
            'html' => $html,
            'pagination' => $pagination,
            'has_pages' => $paginatedTransactions->hasPages(),
            'total' => $allTransactions->count()
        ]);
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

        $dailyTrendData = $this->getDailyDampakTrend($karangTaruna->id, $startDate, $endDate);
        $categoryChartData = $this->getCategoryChartData($byCategory);

        // Get all waste categories used in transactions for filtering
        $kategoris = KategoriSampah::whereHas('transaksiSampah', function ($query) use ($karangTaruna) {
            $query->where('karang_taruna_id', $karangTaruna->id);
        })->distinct()->get();

        $summary = [
            'bulan' => $bulan,
            'bulan_nama' => $this->getNamaBulan($bulanNum),
            'tahun' => $tahun,
            'total_berat' => $totalBerat,
            'total_co2' => $totalCo2,
            'jumlah_transaksi' => $jumlahTransaksi,
            'jumlah_warga' => $jumlahWarga,
        ];

        return view('karang-taruna.reports.dampak-lingkungan', compact('transaksi', 'byCategory', 'summary', 'dailyTrendData', 'categoryChartData', 'kategoris'));
    }

    public function exportArusKasPdf(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;

        // Handle date range
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

        // Handle jenis filter for PDF export
        $jenisFilter = $request->query('jenis', 'semua');

        $kasmasukQuery = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'masuk')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan');

        $kasKeluarQuery = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'keluar')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->with('kategoriKeuangan');

        // Apply jenis filter
        if ($jenisFilter === 'masuk') {
            $kasKeluarQuery->whereRaw('1 = 0'); // Return empty for keluar when filtering masuk only
        } elseif ($jenisFilter === 'keluar') {
            $kasmasukQuery->whereRaw('1 = 0'); // Return empty for masuk when filtering keluar only
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $kasmasukQuery->where('deskripsi', 'LIKE', '%' . $search . '%');
            $kasKeluarQuery->where('deskripsi', 'LIKE', '%' . $search . '%');
        }

        // Apply kategori filter
        if ($request->filled('kategori')) {
            $kategori = $request->kategori;
            $kasmasukQuery->whereHas('kategoriKeuangan', function ($query) use ($kategori) {
                $query->where('nama_kategori', $kategori);
            });
            $kasKeluarQuery->whereHas('kategoriKeuangan', function ($query) use ($kategori) {
                $query->where('nama_kategori', $kategori);
            });
        }

        $kasmasuk = $kasmasukQuery->orderBy('tanggal_transaksi', 'desc')->get();
        $kasKeluar = $kasKeluarQuery->orderBy('tanggal_transaksi', 'desc')->get();

        $totalMasuk = $kasmasuk->sum('jumlah');
        $totalKeluar = $kasKeluar->sum('jumlah');

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('karang-taruna.reports.arus-kas-pdf', compact('kasmasuk', 'kasKeluar', 'totalMasuk', 'totalKeluar', 'karangTaruna', 'startDate', 'endDate'));

        return $pdf->download('laporan-arus-kas-'.date('Y-m-d H:i:s').'.pdf');
    }

    public function exportDampakLingkunganPdf(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;

        // Handle date range
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

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('karang-taruna.reports.dampak-lingkungan-pdf', compact('totalBerat', 'totalCo2', 'byCategory', 'karangTaruna', 'startDate', 'endDate'));

        return $pdf->download('laporan-dampak-lingkungan-'.date('Y-m-d H:i:s').'.pdf');
    }

    private function getDailyArusKasTrend($karangTarunaId, $startDate, $endDate)
    {
        $masukDaily = DB::table('arus_kas')
            ->where('karang_taruna_id', $karangTarunaId)
            ->where('jenis_transaksi', 'masuk')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $keluarDaily = DB::table('arus_kas')
            ->where('karang_taruna_id', $karangTarunaId)
            ->where('jenis_transaksi', 'keluar')
            ->whereDate('tanggal_transaksi', '>=', $startDate)
            ->whereDate('tanggal_transaksi', '<=', $endDate)
            ->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(jumlah) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $dates = [];
        $masukValues = [];
        $keluarValues = [];

        $current = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        while ($current <= $end) {
            $dateStr = $current->format('Y-m-d');
            $dates[] = $current->format('d M');

            $masuk = $masukDaily->firstWhere('tanggal', $dateStr);
            $keluar = $keluarDaily->firstWhere('tanggal', $dateStr);

            $masukValues[] = $masuk ? (int)$masuk->total : 0;
            $keluarValues[] = $keluar ? (int)$keluar->total : 0;

            $current->modify('+1 day');
        }

        return [
            'labels' => $dates,
            'masuk' => $masukValues,
            'keluar' => $keluarValues,
        ];
    }

    private function getDailyDampakTrend($karangTarunaId, $startDate, $endDate)
    {
        $dailyData = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.karang_taruna_id', $karangTarunaId)
            ->whereDate('transaksi_sampah.tanggal_transaksi', '>=', $startDate)
            ->whereDate('transaksi_sampah.tanggal_transaksi', '<=', $endDate)
            ->selectRaw('DATE(transaksi_sampah.tanggal_transaksi) as tanggal, SUM(transaksi_sampah_items.berat_kg) as total_berat, SUM(transaksi_sampah_items.co2_tersimpan) as total_co2')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $dates = [];
        $beratValues = [];
        $co2Values = [];

        $current = new \DateTime($startDate);
        $end = new \DateTime($endDate);

        while ($current <= $end) {
            $dateStr = $current->format('Y-m-d');
            $dates[] = $current->format('d M');

            $data = $dailyData->firstWhere('tanggal', $dateStr);

            $beratValues[] = $data ? round($data->total_berat, 2) : 0;
            $co2Values[] = $data ? round($data->total_co2, 2) : 0;

            $current->modify('+1 day');
        }

        return [
            'labels' => $dates,
            'berat' => $beratValues,
            'co2' => $co2Values,
        ];
    }

    private function getCategoryChartData($byCategory)
    {
        $categories = [];
        $berat = [];
        $co2 = [];

        foreach ($byCategory as $item) {
            $categories[] = $item['kategori'];
            $berat[] = round($item['total_berat'], 2);
            $co2[] = round($item['total_co2'], 2);
        }

        return [
            'labels' => $categories,
            'berat' => $berat,
            'co2' => $co2,
        ];
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
