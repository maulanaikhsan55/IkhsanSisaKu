<?php

namespace App\Http\Controllers\KarangTaruna;

use App\Http\Controllers\Controller;
use App\Models\ArusKas;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArusKasController extends Controller
{
    public function index()
    {
        $karangTaruna = Auth::user()->karangTaruna;
        $arusKas = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->with(['kategoriKeuangan', 'creator'])
            ->latest('tanggal_transaksi')
            ->paginate(15);

        $statisticsMasuk = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'masuk')
            ->selectRaw('COUNT(*) as total_count, COALESCE(SUM(jumlah), 0) as total_masuk')
            ->first();

        $statisticsKeluar = ArusKas::where('karang_taruna_id', $karangTaruna->id)
            ->where('jenis_transaksi', 'keluar')
            ->selectRaw('COUNT(*) as total_count, COALESCE(SUM(jumlah), 0) as total_keluar')
            ->first();

        $kategoris = KategoriKeuangan::all();

        return view('karang-taruna.arus-kas.index', compact('arusKas', 'statisticsMasuk', 'statisticsKeluar', 'kategoris'));
    }

    public function create()
    {
        $kategoriMasuk = KategoriKeuangan::where('jenis', 'masuk')->get();
        $kategoriKeluar = KategoriKeuangan::where('jenis', 'keluar')->get();

        return view('karang-taruna.arus-kas.create', compact('kategoriMasuk', 'kategoriKeluar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_transaksi' => 'required|in:masuk,keluar',
            'kategori_keuangan_id' => 'required|exists:kategori_keuangan,id',
            'jumlah' => 'required|numeric|min:0.01',
            'tanggal_transaksi' => 'required|date',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $karangTaruna = Auth::user()->karangTaruna;
        $kategori = KategoriKeuangan::find($request->kategori_keuangan_id);

        if ($kategori->jenis !== $request->jenis_transaksi) {
            return back()->withErrors(['kategori_keuangan_id' => "Kategori harus berjenis {$request->jenis_transaksi}"]);
        }

        DB::transaction(function () use ($request, $karangTaruna) {
            ArusKas::create([
                'karang_taruna_id' => $karangTaruna->id,
                'kategori_keuangan_id' => $request->kategori_keuangan_id,
                'jenis_transaksi' => $request->jenis_transaksi,
                'jumlah' => $request->jumlah,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'deskripsi' => $request->deskripsi,
                'created_by' => Auth::id(),
            ]);
        });

        $jenis = $request->jenis_transaksi === 'masuk' ? 'Pemasukan' : 'Pengeluaran';

        return redirect()->route('karang-taruna.arus-kas.index')
            ->with('success', "$jenis kas berhasil dicatat!");
    }

    public function edit(ArusKas $arusKas)
    {
        $this->authorizeArusKas($arusKas);
        $kategoriKeuangan = KategoriKeuangan::where('jenis', $arusKas->jenis_transaksi)->get();

        return view('karang-taruna.arus-kas.edit', compact('arusKas', 'kategoriKeuangan'));
    }

    public function update(Request $request, ArusKas $arusKas)
    {
        $this->authorizeArusKas($arusKas);

        $request->validate([
            'kategori_keuangan_id' => 'required|exists:kategori_keuangan,id',
            'jumlah' => 'required|numeric|min:0.01',
            'tanggal_transaksi' => 'required|date',
            'deskripsi' => 'nullable|string|max:500',
        ]);

        $kategori = KategoriKeuangan::find($request->kategori_keuangan_id);

        if ($kategori->jenis !== $arusKas->jenis_transaksi) {
            return back()->withErrors(['kategori_keuangan_id' => "Kategori harus berjenis {$arusKas->jenis_transaksi}"]);
        }

        $arusKas->update([
            'kategori_keuangan_id' => $request->kategori_keuangan_id,
            'jumlah' => $request->jumlah,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'deskripsi' => $request->deskripsi,
        ]);

        $jenis = $arusKas->jenis_transaksi === 'masuk' ? 'Pemasukan' : 'Pengeluaran';

        return redirect()->route('karang-taruna.arus-kas.index')
            ->with('success', "$jenis kas berhasil diperbarui!");
    }

    public function destroy(ArusKas $arusKas)
    {
        $this->authorizeArusKas($arusKas);
        $arusKas->delete();

        $jenis = $arusKas->jenis_transaksi === 'masuk' ? 'Pemasukan' : 'Pengeluaran';

        return redirect()->route('karang-taruna.arus-kas.index')
            ->with('success', "$jenis kas berhasil dihapus!");
    }

    private function authorizeArusKas(ArusKas $arusKas)
    {
        if ($arusKas->karang_taruna_id !== Auth::user()->karangTaruna->id) {
            abort(403, 'Unauthorized access to this record');
        }
    }
}
