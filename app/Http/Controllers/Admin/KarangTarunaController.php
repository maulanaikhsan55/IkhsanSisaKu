<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KarangTarunaRequest;
use App\Models\KarangTaruna;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KarangTarunaController extends Controller
{
    /**
     * Display a listing of Karang Taruna
     */
    public function index(Request $request)
    {
        $query = KarangTaruna::with(['user', 'warga', 'transaksiSampah']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_karang_taruna', 'like', "%{$search}%");
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Calculate stats BEFORE pagination (for all data)
        $totalKarangTaruna = (clone $query)->count();
        $totalAktif = (clone $query)->where('status', 'aktif')->count();
        $totalNonaktif = (clone $query)->where('status', 'nonaktif')->count();

        // Sort
        $sortBy = $request->get('sort_by', 'rw');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $karangTarunas = $query->paginate(5)->withQueryString();

        $ktIds = $karangTarunas->pluck('id')->toArray();

        $wargaCounts = DB::table('warga')
            ->whereIn('karang_taruna_id', $ktIds)
            ->selectRaw('karang_taruna_id, COUNT(*) as count')
            ->groupBy('karang_taruna_id')
            ->get()
            ->keyBy('karang_taruna_id');

        $sampahTotals = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->whereIn('transaksi_sampah.karang_taruna_id', $ktIds)
            ->selectRaw('transaksi_sampah.karang_taruna_id, SUM(transaksi_sampah_items.berat_kg) as total')
            ->groupBy('transaksi_sampah.karang_taruna_id')
            ->get()
            ->keyBy('karang_taruna_id');

        $karangTarunas->getCollection()->transform(function ($kt) use ($wargaCounts, $sampahTotals) {
            $kt->total_warga = $wargaCounts[$kt->id]->count ?? 0;
            $kt->total_sampah = $sampahTotals[$kt->id]->total ?? 0;

            return $kt;
        });

        $uniqueRws = KarangTaruna::distinct()->pluck('rw')->sort();

        return view('admin.karang-taruna.index', compact('karangTarunas', 'uniqueRws', 'totalKarangTaruna', 'totalAktif', 'totalNonaktif'));
    }

    /**
     * Show the form for creating a new Karang Taruna
     */
    public function create()
    {
        return view('admin.karang-taruna.create');
    }

    /**
     * Store a newly created Karang Taruna
     */
    public function store(KarangTarunaRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create User first
            $user = User::create([
                'name' => $request->nama_lengkap ?: $request->username,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'karang_taruna',
                'status_akun' => 'aktif',
            ]);

            // Create Karang Taruna
            KarangTaruna::create([
                'user_id' => $user->id,
                'nama_karang_taruna' => $request->nama_karang_taruna,
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'rw' => $request->rw,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.karang-taruna.index')
                ->with('success', 'Karang Taruna berhasil ditambahkan! 🎉')
                ->with([
                    'show_password' => true,
                    'password_info' => [
                        'nama_karang_taruna' => $request->nama_karang_taruna,
                        'username' => $request->username,
                        'email' => $request->email,
                        'password' => $request->password,
                    ],
                ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan Karang Taruna: '.$e->getMessage());
        }
    }

    /**
     * Display the specified Karang Taruna
     */
    public function show(KarangTaruna $karangTaruna)
    {
        $karangTaruna->load(['user', 'warga', 'transaksiSampah', 'penjualanSampah', 'arusKas']);

        // Stats
        $stats = [
            'total_warga' => $karangTaruna->warga()->count(),
            'total_sampah' => $karangTaruna->transaksiSampah()->sum('berat_kg'),
            'total_co2' => $karangTaruna->transaksiSampah()->sum('co2_tersimpan'),
            'total_penjualan' => $karangTaruna->penjualanSampah()->sum('total_uang_diterima'),
            'kas_masuk' => $karangTaruna->arusKas()->where('jenis_transaksi', 'masuk')->sum('jumlah'),
            'kas_keluar' => $karangTaruna->arusKas()->where('jenis_transaksi', 'keluar')->sum('jumlah'),
        ];

        return view('admin.karang-taruna.show', compact('karangTaruna', 'stats'));
    }

    /**
     * Show the form for editing Karang Taruna
     */
    public function edit(KarangTaruna $karangTaruna)
    {
        $karangTaruna->load('user');

        return view('admin.karang-taruna.edit', compact('karangTaruna'));
    }

    /**
     * Update the specified Karang Taruna
     */
    public function update(KarangTarunaRequest $request, KarangTaruna $karangTaruna)
    {
        try {
            DB::beginTransaction();

            $karangTaruna->update([
                'nama_karang_taruna' => $request->nama_karang_taruna,
                'nama_lengkap' => $request->nama_lengkap,
                'no_telp' => $request->no_telp,
                'rw' => $request->rw,
                'status' => $request->status,
            ]);

            // Update user name and status
            $karangTaruna->user->update([
                'name' => $request->nama_lengkap ?: $karangTaruna->user->username,
                'status_akun' => $request->status,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.karang-taruna.index')
                ->with('success', 'Karang Taruna berhasil diupdate!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate Karang Taruna: '.$e->getMessage());
        }
    }

    /**
     * Soft delete (set status to nonaktif)
     */
    public function destroy(KarangTaruna $karangTaruna)
    {
        try {
            DB::beginTransaction();

            // Soft delete: set status to nonaktif
            $karangTaruna->update(['status' => 'nonaktif']);
            $karangTaruna->user->update(['status_akun' => 'nonaktif']);

            DB::commit();

            return redirect()
                ->route('admin.karang-taruna.index')
                ->with('success', 'Karang Taruna berhasil dinonaktifkan!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menonaktifkan Karang Taruna: '.$e->getMessage());
        }
    }

    /**
     * Permanent delete (force delete)
     */
    public function forceDelete(KarangTaruna $karangTaruna)
    {
        try {
            DB::beginTransaction();

            // Delete related data first
            $karangTaruna->warga()->delete();
            $karangTaruna->transaksiSampah()->delete();
            $karangTaruna->penjualanSampah()->delete();
            $karangTaruna->arusKas()->delete();

            // Delete user and karang taruna
            $user = $karangTaruna->user;
            $karangTaruna->delete();
            $user->delete();

            DB::commit();

            return redirect()
                ->route('admin.karang-taruna.index')
                ->with('success', 'Karang Taruna berhasil dihapus permanen!');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus Karang Taruna: '.$e->getMessage());
        }
    }

    /**
     * Export Karang Taruna data to PDF
     */
    public function exportPdf(Request $request)
    {
        $query = KarangTaruna::with(['user', 'warga', 'transaksiSampah', 'penjualanSampah']);

        // Apply search filter if exists
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_karang_taruna', 'like', "%{$search}%");
        }

        // Apply status filter if exists
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $karangTarunas = $query->get();

        // Prepare data for PDF
        $dataKarangTaruna = $karangTarunas->map(function ($kt) {
            return [
                'id' => $kt->id,
                'rw' => $kt->rw,
                'nama_unit' => $kt->nama_karang_taruna,
                'total_warga' => $kt->warga->count(),
                'total_sampah' => $kt->transaksiSampah->sum('berat_kg'),
                'kas_masuk' => $kt->penjualanSampah->sum('total_uang_diterima'),
                'kas_keluar' => DB::table('arus_kas')
                    ->where('karang_taruna_id', $kt->id)
                    ->where('jenis_transaksi', 'keluar')
                    ->sum('jumlah'),
                'status' => $kt->status,
            ];
        });

        // Generate PDF
        $pdf = Pdf::loadView('admin.karang-taruna.export-pdf', compact('dataKarangTaruna'));

        return $pdf->download('laporan-karang-taruna-'.date('Y-m-d').'.pdf');
    }
}
