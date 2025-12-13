<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriKeuangan;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function kategoriSampah()
    {
        $totalKategori = KategoriSampah::count();
        $avgCO2 = KategoriSampah::with('konversiDampak')
            ->get()
            ->average(function ($item) {
                return $item->konversiDampak?->co2_per_kg ?? 0;
            });
        $kategoriSampah = KategoriSampah::with('konversiDampak')->orderBy('created_at', 'desc')->paginate(5);

        return view('admin.master-data.kategori-sampah', compact('kategoriSampah', 'totalKategori', 'avgCO2'));
    }

    public function storeKategoriSampah(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_sampah,nama_kategori',
            'deskripsi' => 'nullable|string',
            'co2_per_kg' => 'nullable|numeric|min:0',
            'harga_per_kg' => 'required|numeric|min:0',
            'tanggal_berlaku' => 'required|date',
        ]);

        $kategori = KategoriSampah::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'harga_per_kg' => $request->harga_per_kg,
            'tanggal_berlaku' => $request->tanggal_berlaku,
        ]);

        if ($request->co2_per_kg) {
            $kategori->konversiDampak()->create([
                'co2_per_kg' => $request->co2_per_kg,
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Kategori sampah berhasil ditambahkan']);
    }

    public function updateKategoriSampah(Request $request, $id)
    {
        $kategori = KategoriSampah::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_sampah,nama_kategori,'.$id,
            'deskripsi' => 'nullable|string',
            'co2_per_kg' => 'nullable|numeric|min:0',
            'harga_per_kg' => 'required|numeric|min:0',
            'tanggal_berlaku' => 'required|date',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'harga_per_kg' => $request->harga_per_kg,
            'tanggal_berlaku' => $request->tanggal_berlaku,
        ]);

        if ($request->co2_per_kg) {
            $kategori->konversiDampak()->updateOrCreate(
                ['kategori_sampah_id' => $kategori->id],
                ['co2_per_kg' => $request->co2_per_kg]
            );
        } else {
            $kategori->konversiDampak()->delete();
        }

        return response()->json(['success' => true, 'message' => 'Kategori sampah berhasil diperbarui']);
    }

    public function destroyKategoriSampah($id)
    {
        $kategori = KategoriSampah::findOrFail($id);

        // Check if kategori has transactions
        $hasTransaksi = $kategori->transaksiSampah()->exists();

        if ($hasTransaksi) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori sampah tidak dapat dihapus karena masih memiliki transaksi sampah',
            ], 422);
        }

        // Delete related konversi dampak
        $kategori->konversiDampak()->delete();

        // Delete the kategori
        $kategori->delete();

        return response()->json(['success' => true, 'message' => 'Kategori sampah berhasil dihapus']);
    }

    public function kategoriKeuangan()
    {
        $totalMasuk = KategoriKeuangan::where('jenis', 'masuk')->count();
        $totalKeluar = KategoriKeuangan::where('jenis', 'keluar')->count();
        $kategoriKeuangan = KategoriKeuangan::orderBy('created_at', 'desc')->paginate(5);

        return view('admin.master-data.kategori-keuangan', compact('kategoriKeuangan', 'totalMasuk', 'totalKeluar'));
    }

    public function storeKategoriKeuangan(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_keuangan,nama_kategori',
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:masuk,keluar',
        ]);

        KategoriKeuangan::create($request->all());

        return response()->json(['success' => true, 'message' => 'Kategori keuangan berhasil ditambahkan']);
    }

    public function updateKategoriKeuangan(Request $request, $id)
    {
        $kategori = KategoriKeuangan::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_keuangan,nama_kategori,'.$id,
            'deskripsi' => 'nullable|string',
            'jenis' => 'required|in:masuk,keluar',
        ]);

        $kategori->update($request->only(['nama_kategori', 'deskripsi', 'jenis']));

        return response()->json(['success' => true, 'message' => 'Kategori keuangan berhasil diperbarui']);
    }

    public function destroyKategoriKeuangan($id)
    {
        $kategori = KategoriKeuangan::findOrFail($id);

        // Check if kategori has related arus kas records
        $hasArusKas = $kategori->arusKas()->exists();

        if ($hasArusKas) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori keuangan tidak dapat dihapus karena masih memiliki transaksi keuangan terkait',
            ], 422);
        }

        $kategori->delete();

        return response()->json(['success' => true, 'message' => 'Kategori keuangan berhasil dihapus']);
    }

    public function bulkUpdateHarga(Request $request)
    {
        $request->validate([
            'updates' => 'required|array',
            'updates.*.id' => 'required|exists:kategori_sampah,id',
            'updates.*.harga_per_kg' => 'required|numeric|min:0',
            'updates.*.tanggal_berlaku' => 'required|date',
        ]);

        $updated = 0;
        $errors = [];

        foreach ($request->updates as $update) {
            try {
                $kategori = KategoriSampah::findOrFail($update['id']);
                $kategori->update([
                    'harga_per_kg' => $update['harga_per_kg'],
                    'tanggal_berlaku' => $update['tanggal_berlaku'],
                ]);
                $updated++;
            } catch (\Exception $e) {
                $errors[] = "Gagal update kategori ID {$update['id']}: {$e->getMessage()}";
            }
        }

        $message = "$updated kategori berhasil diperbarui";
        if (!empty($errors)) {
            $message .= ". " . implode(", ", $errors);
        }

        return response()->json([
            'success' => empty($errors) || $updated > 0,
            'message' => $message,
            'updated' => $updated,
        ]);
    }
}
