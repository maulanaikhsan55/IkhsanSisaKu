<?php

namespace App\Http\Controllers\KarangTaruna;

use App\Http\Controllers\Controller;
use App\Models\ArusKas;
use App\Models\KategoriKeuangan;
use App\Models\KategoriSampah;
use App\Models\TransaksiSampah;
use App\Models\TransaksiSampahItem;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $karangTaruna = Auth::user()->karangTaruna;
        $transaksi = TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)
            ->whereNotNull('warga_id')
            ->with(['warga', 'items.kategoriSampah'])
            ->latest('tanggal_transaksi')
            ->paginate(10);

        // Get statistics from items table (correct data source)
        $statistics = DB::table('transaksi_sampah_items')
            ->join('transaksi_sampah', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampah.id')
            ->where('transaksi_sampah.karang_taruna_id', $karangTaruna->id)
            ->selectRaw('COUNT(*) as total_count, COALESCE(SUM(transaksi_sampah_items.berat_kg), 0) as total_berat, COALESCE(SUM(transaksi_sampah_items.total_harga), 0) as total_nilai')
            ->first();

        return view('karang-taruna.transaksi.index', compact('transaksi', 'statistics'));
    }

    public function create()
    {
        $karangTaruna = Auth::user()->karangTaruna;
        $warga = Warga::where('karang_taruna_id', $karangTaruna->id)->get();
        $kategoriSampah = KategoriSampah::all();

        return view('karang-taruna.transaksi.create', compact('warga', 'kategoriSampah', 'karangTaruna'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'tanggal_transaksi' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'items.*.berat_kg' => 'required|numeric|min:0.1',
        ]);

        $karangTaruna = Auth::user()->karangTaruna;
        $items = $request->items;
        $totalHargaTransaksi = 0;

        foreach ($items as $item) {
            $kategori = KategoriSampah::find($item['kategori_sampah_id']);
            if (!$kategori || !$kategori->harga_per_kg) {
                $kategoriNama = $kategori->nama_kategori ?? 'Unknown';
                return back()->withErrors(["items.*.kategori_sampah_id" => "Harga sampah untuk kategori '{$kategoriNama}' belum ditentukan."]);
            }
            $totalHargaTransaksi += $item['berat_kg'] * $kategori->harga_per_kg;
        }

        DB::transaction(function () use ($request, $karangTaruna, $items, $totalHargaTransaksi) {
            $totalBeratKg = 0;
            $totalCO2 = 0;

            $transaksi = TransaksiSampah::create([
                'karang_taruna_id' => $karangTaruna->id,
                'warga_id' => $request->warga_id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'status_penjualan' => 'belum_terjual',
            ]);

            foreach ($items as $item) {
                $kategori = KategoriSampah::with('konversiDampak')->find($item['kategori_sampah_id']);
                $itemTotalHarga = $item['berat_kg'] * $kategori->harga_per_kg;
                $co2 = $item['berat_kg'] * ($kategori->konversiDampak?->co2_per_kg ?? 0);

                $totalBeratKg += $item['berat_kg'];
                $totalCO2 += $co2;

                TransaksiSampahItem::create([
                    'transaksi_sampah_id' => $transaksi->id,
                    'kategori_sampah_id' => $item['kategori_sampah_id'],
                    'berat_kg' => $item['berat_kg'],
                    'harga_per_kg' => $kategori->harga_per_kg,
                    'total_harga' => $itemTotalHarga,
                    'co2_tersimpan' => $co2,
                ]);
            }

            $transaksi->update([
                'berat_kg' => $totalBeratKg,
                'co2_tersimpan' => $totalCO2,
            ]);
        });

        return redirect()->route('karang-taruna.transaksi.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function show(TransaksiSampah $transaksi)
    {
        $this->authorizeTransaksi($transaksi);
        $transaksi->load(['warga', 'items.kategoriSampah', 'karangTaruna']);

        return view('karang-taruna.transaksi.show', compact('transaksi'));
    }

    public function edit(TransaksiSampah $transaksi)
    {
        $this->authorizeTransaksi($transaksi);

        if ($transaksi->status_penjualan === 'sudah_terjual') {
            return back()->withErrors(['edit' => 'Transaksi yang sudah dibayar tidak dapat diedit. Hubungi admin jika perlu perubahan.']);
        }

        $karangTaruna = Auth::user()->karangTaruna;
        $warga = Warga::where('karang_taruna_id', $karangTaruna->id)->get();
        $kategoriSampah = KategoriSampah::all();
        $transaksi->load('items');

        return view('karang-taruna.transaksi.edit', compact('transaksi', 'warga', 'kategoriSampah'));
    }

    public function update(Request $request, TransaksiSampah $transaksi)
    {
        $this->authorizeTransaksi($transaksi);

        $request->validate([
            'warga_id' => 'required|exists:warga,id',
            'tanggal_transaksi' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.kategori_sampah_id' => 'required|exists:kategori_sampah,id',
            'items.*.berat_kg' => 'required|numeric|min:0.1',
        ]);

        $items = $request->items;

        foreach ($items as $item) {
            $kategori = KategoriSampah::find($item['kategori_sampah_id']);
            if (!$kategori || !$kategori->harga_per_kg) {
                return back()->withErrors(["items.*.kategori_sampah_id" => "Harga sampah untuk kategori belum ditentukan."]);
            }
        }

        DB::transaction(function () use ($transaksi, $request, $items) {
            $totalBeratKg = 0;
            $totalCO2 = 0;

            $transaksi->update([
                'warga_id' => $request->warga_id,
                'tanggal_transaksi' => $request->tanggal_transaksi,
            ]);

            $transaksi->items()->delete();

            foreach ($items as $item) {
                $kategori = KategoriSampah::with('konversiDampak')->find($item['kategori_sampah_id']);
                $itemTotalHarga = $item['berat_kg'] * $kategori->harga_per_kg;
                $co2 = $item['berat_kg'] * ($kategori->konversiDampak?->co2_per_kg ?? 0);

                $totalBeratKg += $item['berat_kg'];
                $totalCO2 += $co2;

                TransaksiSampahItem::create([
                    'transaksi_sampah_id' => $transaksi->id,
                    'kategori_sampah_id' => $item['kategori_sampah_id'],
                    'berat_kg' => $item['berat_kg'],
                    'harga_per_kg' => $kategori->harga_per_kg,
                    'total_harga' => $itemTotalHarga,
                    'co2_tersimpan' => $co2,
                ]);
            }

            $transaksi->update([
                'berat_kg' => $totalBeratKg,
                'co2_tersimpan' => $totalCO2,
            ]);
        });

        return redirect()->route('karang-taruna.transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(TransaksiSampah $transaksi)
    {
        $this->authorizeTransaksi($transaksi);

        if ($transaksi->status_penjualan === 'sudah_terjual') {
            return back()->withErrors(['delete' => 'Transaksi yang sudah dibayar tidak dapat dihapus. Hubungi admin jika perlu dibatalkan.']);
        }

        $transaksi->delete();

        return redirect()->route('karang-taruna.transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }

    public function filter(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;

        $dari = $request->query('dari');
        $sampai = $request->query('sampai');

        $transaksi = TransaksiSampah::where('karang_taruna_id', $karangTaruna->id)
            ->whereNotNull('warga_id')
            ->where('status_penjualan', 'belum_terjual')
            ->whereDate('tanggal_transaksi', '>=', $dari)
            ->whereDate('tanggal_transaksi', '<=', $sampai)
            ->with(['warga', 'kategoriSampah', 'items.kategoriSampah'])
            ->get();

        return response()->json([
            'success' => true,
            'transaksi' => $transaksi->map(function ($t) {
                if ($t->items->count() > 0) {
                    $totalHarga = $t->items()->sum('total_harga');
                    $totalBerat = $t->items()->sum('berat_kg');
                    $kategoriNama = $t->items->pluck('kategoriSampah.nama_kategori')->join(', ');
                } else {
                    $totalHarga = $t->total_harga ?? 0;
                    $totalBerat = $t->berat_kg ?? 0;
                    $kategoriNama = $t->kategoriSampah?->nama_kategori ?? 'N/A';
                }
                
                return [
                    'id' => $t->id,
                    'warga_nama' => $t->warga?->nama ?? 'N/A',
                    'kategori_nama' => $kategoriNama,
                    'berat_kg' => $totalBerat,
                    'total_harga' => $totalHarga,
                ];
            }),
        ]);
    }

    public function getHargaSampah($kategoriId)
    {
        $kategori = KategoriSampah::findOrFail($kategoriId);

        if (!$kategori->harga_per_kg) {
            return response()->json([
                'success' => false,
                'message' => 'Harga sampah tidak ditemukan',
                'harga' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'harga' => [
                'id' => $kategori->id,
                'harga_per_kg' => (float) $kategori->harga_per_kg,
            ],
        ]);
    }

    public function showBulkPayment()
    {
        return view('karang-taruna.transaksi.bulk-payment');
    }

    public function bulkProcessPayment(Request $request)
    {
        $karangTaruna = Auth::user()->karangTaruna;

        $request->validate([
            'transaksi_ids' => 'required|array|min:1',
            'transaksi_ids.*' => 'exists:transaksi_sampah,id',
            'harga_pembayaran' => 'required|numeric|min:0.01',
        ]);

        $kategoriPenjualan = KategoriKeuangan::where('jenis', 'masuk')
            ->where('nama_kategori', 'Penjualan Sampah')
            ->first();

        if (!$kategoriPenjualan) {
            return back()->withErrors(['error' => 'Kategori Penjualan Sampah tidak ditemukan. Hubungi admin untuk konfigurasi.']);
        }

        DB::transaction(function () use ($request, $karangTaruna, $kategoriPenjualan) {
            $transaksi_ids = $request->transaksi_ids;

            foreach ($transaksi_ids as $id) {
                $transaksi = TransaksiSampah::find($id);

                if ($transaksi->karang_taruna_id !== $karangTaruna->id) {
                    continue;
                }

                $hargaPembayaran = $transaksi->items()->exists() 
                    ? $transaksi->items()->sum('total_harga') 
                    : ($transaksi->total_harga ?? 0);

                $transaksi->update([
                    'harga_pembayaran' => $hargaPembayaran,
                    'status_penjualan' => 'sudah_terjual',
                    'tanggal_terjual' => now(),
                ]);

                ArusKas::create([
                    'karang_taruna_id' => $karangTaruna->id,
                    'kategori_keuangan_id' => $kategoriPenjualan->id,
                    'jenis_transaksi' => 'masuk',
                    'jumlah' => $hargaPembayaran,
                    'tanggal_transaksi' => now()->toDateString(),
                    'deskripsi' => "Pembayaran sampah dari bank sampah - Transaksi #{$transaksi->id}",
                    'created_by' => Auth::id(),
                ]);
            }
        });

        return redirect()->route('karang-taruna.transaksi.index')
            ->with('success', 'Pembayaran sampah berhasil diproses untuk ' . count($request->transaksi_ids) . ' transaksi!');
    }

    public function processPaymentForm(TransaksiSampah $transaksi)
    {
        $this->authorizeTransaksi($transaksi);

        return view('karang-taruna.transaksi.process-payment', compact('transaksi'));
    }

    public function processPayment(Request $request, TransaksiSampah $transaksi)
    {
        $this->authorizeTransaksi($transaksi);

        $request->validate([
            'harga_pembayaran' => 'required|numeric|min:0.01',
            'catatan_pembayaran' => 'nullable|string|max:500',
        ]);

        $kategoriPenjualan = KategoriKeuangan::where('jenis', 'masuk')
            ->where('nama_kategori', 'Penjualan Sampah')
            ->first();

        if (!$kategoriPenjualan) {
            return back()->withErrors(['error' => 'Kategori Penjualan Sampah tidak ditemukan. Hubungi admin untuk konfigurasi.']);
        }

        DB::transaction(function () use ($request, $transaksi, $kategoriPenjualan) {
            $karangTaruna = Auth::user()->karangTaruna;
            $hargaPembayaran = (float) $request->harga_pembayaran;

            $transaksi->update([
                'harga_pembayaran' => $hargaPembayaran,
                'status_penjualan' => 'sudah_terjual',
                'tanggal_terjual' => now(),
                'catatan' => $request->catatan_pembayaran ?? $transaksi->catatan,
            ]);

            ArusKas::create([
                'karang_taruna_id' => $karangTaruna->id,
                'kategori_keuangan_id' => $kategoriPenjualan->id,
                'jenis_transaksi' => 'masuk',
                'jumlah' => $hargaPembayaran,
                'tanggal_transaksi' => now()->toDateString(),
                'deskripsi' => "Pembayaran sampah dari bank sampah - Transaksi #{$transaksi->id}",
                'created_by' => Auth::id(),
            ]);
        });

        return redirect()->route('karang-taruna.transaksi.show', $transaksi)
            ->with('success', 'Pembayaran sampah berhasil diproses!');
    }

    public function quickPayment(Request $request, TransaksiSampah $transaksi)
    {
        $this->authorizeTransaksi($transaksi);

        if ($transaksi->status_penjualan === 'sudah_terjual') {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi sudah dibayar',
            ], 400);
        }

        $karangTaruna = Auth::user()->karangTaruna;

        $kategoriPenjualan = KategoriKeuangan::where('jenis', 'masuk')
            ->where('nama_kategori', 'Penjualan Sampah')
            ->first();

        if (!$kategoriPenjualan) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori Penjualan Sampah tidak ditemukan. Hubungi admin untuk konfigurasi.',
            ], 500);
        }

        DB::transaction(function () use ($transaksi, $karangTaruna, $kategoriPenjualan) {
            $totalHarga = $transaksi->items()->exists() 
                ? $transaksi->items()->sum('total_harga') 
                : ($transaksi->total_harga ?? 0);

            $transaksi->update([
                'harga_pembayaran' => $totalHarga,
                'status_penjualan' => 'sudah_terjual',
                'tanggal_terjual' => now(),
            ]);

            ArusKas::create([
                'karang_taruna_id' => $karangTaruna->id,
                'kategori_keuangan_id' => $kategoriPenjualan->id,
                'jenis_transaksi' => 'masuk',
                'jumlah' => $totalHarga,
                'tanggal_transaksi' => now()->toDateString(),
                'deskripsi' => "Pembayaran sampah dari bank sampah - Transaksi #{$transaksi->id}",
                'created_by' => Auth::id(),
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil diproses!',
        ]);
    }

    private function authorizeTransaksi(TransaksiSampah $transaksi)
    {
        if ($transaksi->karang_taruna_id !== Auth::user()->karangTaruna->id) {
            abort(403, 'Unauthorized access to this transaction.');
        }
    }
}
