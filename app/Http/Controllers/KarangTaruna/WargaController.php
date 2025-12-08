<?php

namespace App\Http\Controllers\KarangTaruna;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WargaController extends Controller
{
    public function index()
    {
        $karangTaruna = auth()->user()->karangTaruna;
        $warga = Warga::where('karang_taruna_id', $karangTaruna->id)
            ->orderBy('nama', 'asc')
            ->paginate(5);

        return view('karang-taruna.warga.index', compact('warga', 'karangTaruna'));
    }

    public function create()
    {
        return view('karang-taruna.warga.create');
    }

    public function store(Request $request)
    {
        $karangTaruna = auth()->user()->karangTaruna;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|regex:/^[0-9\s\-\+()]*$/|max:15',
        ]);

        $validated['karang_taruna_id'] = $karangTaruna->id;
        Warga::create($validated);

        return redirect()->route('karang-taruna.warga.index')
            ->with('success', 'Warga berhasil ditambahkan');
    }

    public function show(Warga $warga)
    {
        $karangTaruna = auth()->user()->karangTaruna;

        if ($warga->karang_taruna_id != $karangTaruna->id) {
            abort(403);
        }

        $transaksi = $warga->transaksiSampah()->with('items.kategoriSampah')->latest()->take(10)->get();
        $totalBerat = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.warga_id', $warga->id)
            ->sum('transaksi_sampah_items.berat_kg');
        $totalHarga = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.warga_id', $warga->id)
            ->sum('transaksi_sampah_items.total_harga');

        return view('karang-taruna.warga.show', compact('warga', 'transaksi', 'totalBerat', 'totalHarga'));
    }

    public function edit(Warga $warga)
    {
        $karangTaruna = auth()->user()->karangTaruna;

        if ($warga->karang_taruna_id != $karangTaruna->id) {
            abort(403);
        }

        return view('karang-taruna.warga.edit', compact('warga'));
    }

    public function update(Request $request, Warga $warga)
    {
        $karangTaruna = auth()->user()->karangTaruna;

        if ($warga->karang_taruna_id != $karangTaruna->id) {
            abort(403);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'nullable|regex:/^[0-9\s\-\+()]*$/|max:15',
        ]);

        $warga->update($validated);

        return redirect()->route('karang-taruna.warga.show', $warga)
            ->with('success', 'Warga berhasil diperbarui');
    }

    public function destroy(Warga $warga)
    {
        $karangTaruna = auth()->user()->karangTaruna;

        if ($warga->karang_taruna_id != $karangTaruna->id) {
            abort(403);
        }

        $warga->delete();

        return redirect()->route('karang-taruna.warga.index')
            ->with('success', 'Warga berhasil dihapus');
    }

    public function search(Request $request)
    {
        $karangTaruna = auth()->user()->karangTaruna;
        $search = $request->input('search', '');
        $address = $request->input('address', '');

        $query = Warga::where('karang_taruna_id', $karangTaruna->id);

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($address) {
            $query->where('alamat', 'like', "%{$address}%");
        }

        $warga = $query->orderBy('nama', 'asc')->get();

        return response()->json([
            'warga' => $warga->map(function ($w) {
                return [
                    'id' => $w->id,
                    'nama' => $w->nama,
                    'alamat' => \Illuminate\Support\Str::limit($w->alamat, 30),
                    'no_telepon' => $w->no_telepon ?? '-',
                ];
            }),
            'count' => $warga->count(),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $karangTaruna = auth()->user()->karangTaruna;
        $search = $request->input('search', '');
        $address = $request->input('address', '');

        $query = Warga::where('karang_taruna_id', $karangTaruna->id);

        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($address) {
            $query->where('alamat', 'like', "%{$address}%");
        }

        $warga = $query->orderBy('nama', 'asc')->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('karang-taruna.warga.pdf', compact('warga', 'karangTaruna', 'search', 'address'));
        $filename = 'daftar-warga-' . $karangTaruna->nama . '-' . date('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
