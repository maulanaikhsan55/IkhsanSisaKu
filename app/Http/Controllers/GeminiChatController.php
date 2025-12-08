<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\KategoriSampah;
use App\Models\KategoriKeuangan;
use App\Models\TransaksiSampah;
use App\Models\TransaksiSampahItem;
use App\Models\PenjualanSampah;
use App\Models\ArusKas;
use App\Models\KarangTaruna;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GeminiChatController extends Controller
{
    private $apiKey;
    private $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('app.groq_api_key') ?? env('GROQ_API_KEY');
    }



    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $sessionId = session('chat_session_id') ?? Str::uuid();
        session(['chat_session_id' => $sessionId]);

        $userMessage = $request->input('message');

        ChatHistory::create([
            'user_id' => auth()->id(),
            'sender' => 'user',
            'message' => $userMessage,
            'session_id' => $sessionId,
        ]);

        $context = $this->buildContext();
        $botResponse = $this->callGeminiAPI($userMessage, $context);

        ChatHistory::create([
            'user_id' => null,
            'sender' => 'bot',
            'message' => $botResponse,
            'session_id' => $sessionId,
        ]);

        return response()->json([
            'success' => true,
            'message' => $botResponse,
        ]);
    }

    private function getUserRole(): string
    {
        $user = auth()->user();
        if (!$user) return 'guest';
        
        if ($user->role_id == 1) return 'admin';
        if ($user->role_id == 2) return 'karang_taruna';
        
        return 'user';
    }

    private function buildContext(): string
    {
        $userRole = $this->getUserRole();
        $kategoriData = $this->getKategoriDataForContext();
        $statistikData = $this->getStatistikForContext();
        $faqData = $this->getFAQData();
        $environmentalData = $this->getEnvironmentalImpactData();
        $recentTransactions = $this->getRecentTransactionsForContext();
        $currentMonthData = $this->getCurrentMonthData();
        $topCategories = $this->getTopCategoriesData();

        $roleContext = $this->getRoleSpecificContext($userRole);
        $roleInstructions = $this->getRoleSpecificInstructions($userRole);

        return "=== SISAKU AI HYBRID ASSISTANT ===\n"
            . "KAMU ADALAH AI YANG BISA MENJAWAB DARI DATABASE SISAKU ATAU PENGETAHUAN UMUM.\n"
            . "PRIORITAS: Database dulu, baru pengetahuan umum jika relevan.\n"
            . "User Role: " . ucfirst($userRole) . "\n\n"
            . "=== DATABASE SISAKU - DATA TERKINI (PRIORITAS UTAMA) ===\n"
            . "KATEGORI SAMPAH & HARGA SAAT INI:\n"
            . $kategoriData . "\n\n"
            . "KATEGORI TERLARIS BULAN INI:\n"
            . $topCategories . "\n\n"
            . "STATISTIK SISTEM HARI INI:\n"
            . $statistikData . "\n\n"
            . "DATA BULAN INI (" . date('F Y') . "):\n"
            . $currentMonthData . "\n\n"
            . "TRANSAKSI TERBARU (7 HARI TERAKHIR):\n"
            . $recentTransactions . "\n\n"
            . $roleContext . "\n\n"
            . "=== ATURAN JAWABAN - DATABASE FIRST, GENERAL SECOND ===\n"
            . "1. DATABASE PRIORITY: Jika pertanyaan bisa dijawab dari data di atas, GUNAKAN DATA DATABASE\n"
            . "2. GENERAL ALLOWED: Jika pertanyaan umum/tidak ada di database, boleh jawab dari pengetahuan umum\n"
            . "3. SEBUT SUMBER: Untuk database: 'berdasarkan data sistem Sisaku'. Untuk umum: 'secara umum'\n"
            . "4. DETAIL SPESIFIK: Database = angka eksak. Umum = informasi berguna\n"
            . "5. ROLE AWARE: Database sesuai role, umum bisa lebih fleksibel\n"
            . "6. JIKA TIDAK ADA DATA: 'Belum ada data di sistem' atau jawab umum jika relevan\n"
            . "7. FOCUS SISAKU: Usahakan jawaban selalu kembali ke konteks bank sampah\n\n"
            . $roleInstructions . "\n\n"
            . "=== CONTOH JAWABAN HYBRID ===\n"
            . "Q: 'Berapa harga plastik?' (ADA DI DATABASE)\n"
            . "✅ BENAR: 'Berdasarkan data sistem: Plastik PET Rp2.500/kg, HDPE Rp2.000/kg'\n\n"
            . "Q: 'Apa itu bank sampah?' (TIDAK ADA DI DATABASE)\n"
            . "✅ BENAR: 'Secara umum, bank sampah adalah tempat pengumpulan dan pengolahan sampah daur ulang. Di Sisaku khususnya, kami membantu warga mengelola sampah sambil dapat penghasilan tambahan.'\n\n"
            . "Q: 'Berapa transaksi bulan ini?' (ADA DI DATABASE)\n"
            . "✅ BENAR: 'Berdasarkan data bulan ini: 45 transaksi dengan total 125kg sampah'\n\n"
            . "Q: 'Bagaimana cara daur ulang plastik?' (TIDAK ADA DI DATABASE)\n"
            . "✅ BENAR: 'Secara umum, daur ulang plastik meliputi: 1) Sortir berdasarkan jenis, 2) Cuci bersih, 3) Potong kecil, 4) Lelehkan atau press. Di Sisaku, kami bantu warga dari langkah 1 sampai dapat uang!'\n\n"
            . "=== DAMPAK LINGKUNGAN DARI DATABASE ===\n"
            . $environmentalData . "\n\n"
            . $faqData . "\n\n"
            . "=== PANDUAN JAWABAN ===\n"
            . "• DATABASE: Prioritas utama untuk data Sisaku (harga, transaksi, statistik)\n"
            . "• UMUM: Boleh untuk pengetahuan bank sampah, lingkungan, daur ulang\n"
            . "• HYBRID: Gabung database + umum untuk konteks lebih lengkap\n"
            . "• FOCUS: Selalu arahkan percakapan kembali ke manfaat Sisaku\n"
            . "• HELPFUL: Berikan informasi berguna yang bisa bantu user";
    }

    private function getRoleSpecificContext(string $userRole): string
    {
        if ($userRole === 'admin') {
            return $this->getAdminContext();
        } elseif ($userRole === 'karang_taruna') {
            return $this->getKarangTarunaContext();
        }
        
        return "DATA UMUM - Anda bisa melihat informasi umum tentang SISAKU.";
    }

    private function getRoleSpecificInstructions(string $userRole): string
    {
        if ($userRole === 'admin') {
            return "=== INSTRUKSI ADMIN ===\n"
                . "1. FOKUS ADMIN: Jawab tentang master data, laporan sistem keseluruhan, manajemen KT, keuangan global\n"
                . "2. MENU: Kalau user tanya 'menu apa?' → Sebutkan semua menu admin (dashboard, KT, master data, laporan, reset password, pengaturan)\n"
                . "3. MASTER DATA: Bantu user mengelola kategori sampah & keuangan (tambah, edit, hapus, harga)\n"
                . "4. LAPORAN: Jelaskan cara lihat laporan arus kas, dampak lingkungan, dan export PDF\n"
                . "5. STATISTIK: Referensikan total KT, warga, transaksi, pendapatan dari data yang diberikan di atas";
        } elseif ($userRole === 'karang_taruna') {
            return "=== INSTRUKSI KARANG TARUNA ===\n"
                . "1. FOKUS KT: Jawab tentang operasional lokal (transaksi, warga, kas, laporan)\n"
                . "2. MENU: Kalau user tanya 'menu apa?' → Sebutkan menu KT (dashboard, warga, transaksi, arus kas, laporan, pengaturan)\n"
                . "3. TRANSAKSI: Bantu user cara input transaksi (pilih warga, kategori sampah, berat), hitung otomatis\n"
                . "4. ARUS KAS: Jelaskan cara mencatat kas masuk (penjualan) & kas keluar (operasional)\n"
                . "5. STATISTIK: Referensikan data KT (nama organisasi, warga, transaksi bulan ini, kas bulan ini) dari data di atas";
        }
        
        return "";
    }

    private function getAdminContext(): string
    {
        $kategoriKeuangan = $this->getKategoriKeuanganData();
        $adminStats = $this->getAdminStatistics();
        $karangTarunaCount = KarangTaruna::count();
        
        return "=== KONTEKS ADMIN ===\n"
            . "Anda memiliki akses ke fitur admin SISAKU:\n\n"
            . "FITUR ADMIN TERSEDIA:\n"
            . "• Dashboard - Lihat ringkasan sistem\n"
            . "• Manajemen Karang Taruna - Kelola organisasi & anggota (" . $karangTarunaCount . " KT terdaftar)\n"
            . "• Master Data:\n"
            . "  - Kategori Sampah - Atur harga & jenis sampah\n"
            . "  - Kategori Keuangan - Atur kategori pemasukan/pengeluaran\n"
            . "• Laporan:\n"
            . "  - Arus Kas (Cash Flow) - Lihat pemasukan & pengeluaran\n"
            . "  - Dampak Lingkungan - Analisis CO2 yang terselamatkan\n"
            . "• Manajemen Reset Password - Tangani permintaan reset password\n"
            . "• Pengaturan Sistem - Konfigurasi sistem\n\n"
            . "KATEGORI KEUANGAN:\n"
            . $kategoriKeuangan . "\n\n"
            . "STATISTIK ADMIN:\n"
            . $adminStats;
    }

    private function getKarangTarunaContext(): string
    {
        $karangTarunaData = auth()->user()->karangTaruna;
        
        if (!$karangTarunaData) {
            return "=== KONTEKS KARANG TARUNA ===\nAnda adalah anggota Karang Taruna. Akses penuh ke fitur operasional.";
        }
        
        $wargaCount = Warga::where('karang_taruna_id', $karangTarunaData->id)->count();
        $ktStats = $this->getKarangTarunaStatistics($karangTarunaData->id);
        
        return "=== KONTEKS KARANG TARUNA ===\n"
            . "Organisasi: " . $karangTarunaData->nama_karang_taruna . " (RW " . $karangTarunaData->rw . ")\n"
            . "Kontak: " . $karangTarunaData->no_telp . "\n\n"
            . "FITUR KARANG TARUNA TERSEDIA:\n"
            . "• Dashboard - Lihat ringkasan aktivitas KT\n"
            . "• Manajemen Warga - Daftar & kelola warga (" . $wargaCount . " warga terdaftar)\n"
            . "• Manajemen Transaksi - Catat penjualan sampah dari warga\n"
            . "• Arus Kas:\n"
            . "  - Kas Masuk - Catat pemasukan (hasil penjualan sampah, dll)\n"
            . "  - Kas Keluar - Catat pengeluaran (operasional, dll)\n"
            . "• Laporan:\n"
            . "  - Arus Kas - Lihat ringkasan pemasukan/pengeluaran\n"
            . "  - Dampak Lingkungan - Lihat dampak sampah yang dikumpulkan\n"
            . "• Pengaturan Organisasi - Update info KT\n\n"
            . "STATISTIK KARANG TARUNA:\n"
            . $ktStats;
    }

    private function getKategoriKeuanganData(): string
    {
        $kategori = KategoriKeuangan::select('nama_kategori', 'jenis', 'deskripsi')
            ->orderBy('jenis', 'asc')
            ->get();
        
        if ($kategori->isEmpty()) {
            return "Belum ada kategori keuangan terdaftar.";
        }
        
        $grouped = [];
        foreach ($kategori as $item) {
            if (!isset($grouped[$item->jenis])) {
                $grouped[$item->jenis] = [];
            }
            $grouped[$item->jenis][] = "• " . $item->nama_kategori . (!$item->deskripsi ?: " - " . $item->deskripsi);
        }
        
        $result = [];
        foreach ($grouped as $jenis => $items) {
            $result[] = ucfirst($jenis) . ":\n" . implode("\n", $items);
        }
        
        return implode("\n\n", $result);
    }

    private function getAdminStatistics(): string
    {
        $totalKT = KarangTaruna::count();
        $totalWarga = Warga::count();
        $totalTransaksi = TransaksiSampah::count();
        $totalKasIn = ArusKas::where('jenis_transaksi', 'masuk')->sum('jumlah') ?? 0;
        $totalKasOut = ArusKas::where('jenis_transaksi', 'keluar')->sum('jumlah') ?? 0;
        $totalSampah = TransaksiSampah::sum('berat_kg') ?? 0;
        
        return sprintf(
            "Total Karang Taruna: %d | Total Warga: %d | Total Transaksi: %d | Total Sampah: %.1f kg\n"
            . "Kas Masuk: Rp%s | Kas Keluar: Rp%s | Saldo: Rp%s",
            $totalKT,
            $totalWarga,
            $totalTransaksi,
            $totalSampah,
            number_format($totalKasIn, 0, ',', '.'),
            number_format($totalKasOut, 0, ',', '.'),
            number_format($totalKasIn - $totalKasOut, 0, ',', '.')
        );
    }

    private function getKarangTarunaStatistics(int $karangTarunaId): string
    {
        $wargaCount = Warga::where('karang_taruna_id', $karangTarunaId)->count();
        $transaksiBulanIni = TransaksiSampah::where('karang_taruna_id', $karangTarunaId)
            ->whereMonth('created_at', now()->month)
            ->count();
        $sampahBulanIni = TransaksiSampah::where('karang_taruna_id', $karangTarunaId)
            ->whereMonth('created_at', now()->month)
            ->sum('berat_kg') ?? 0;
        $kasInBulanIni = ArusKas::where('karang_taruna_id', $karangTarunaId)
            ->where('jenis_transaksi', 'masuk')
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah') ?? 0;
        $kasOutBulanIni = ArusKas::where('karang_taruna_id', $karangTarunaId)
            ->where('jenis_transaksi', 'keluar')
            ->whereMonth('created_at', now()->month)
            ->sum('jumlah') ?? 0;
        
        return sprintf(
            "Warga Terdaftar: %d | Transaksi Bulan Ini: %d | Sampah Bulan Ini: %.1f kg\n"
            . "Kas Masuk Bulan Ini: Rp%s | Kas Keluar Bulan Ini: Rp%s | Saldo Bulan Ini: Rp%s",
            $wargaCount,
            $transaksiBulanIni,
            $sampahBulanIni,
            number_format($kasInBulanIni, 0, ',', '.'),
            number_format($kasOutBulanIni, 0, ',', '.'),
            number_format($kasInBulanIni - $kasOutBulanIni, 0, ',', '.')
        );
    }

    private function getKategoriDataForContext(): string
    {
        $kategori = KategoriSampah::select('nama_kategori', 'harga_per_kg', 'deskripsi')
            ->where('harga_per_kg', '>', 0)
            ->orderBy('harga_per_kg', 'desc')
            ->get();
        
        if ($kategori->isEmpty()) {
            return "Belum ada data kategori sampah di sistem.";
        }
        
        $result = [];
        foreach ($kategori as $item) {
            $desc = $item->deskripsi ?? 'Sampah daur ulang';
            $price = number_format($item->harga_per_kg, 0, ',', '.');
            $result[] = sprintf(
                "• %s | Harga: Rp%s/kg | Deskripsi: %s",
                $item->nama_kategori,
                $price,
                $desc
            );
        }
        
        return implode("\n", $result);
    }

    private function getStatistikForContext(): string
    {
        $totalTransaksi = TransaksiSampah::count();
        $totalBeratKg = TransaksiSampah::sum('berat_kg') ?? 0;
        $totalCO2 = TransaksiSampah::sum('co2_tersimpan') ?? 0;
        $totalPendapatan = PenjualanSampah::sum('total_uang_diterima') ?? 0;

        return sprintf(
            "Total Transaksi: %d | Total Sampah: %.1f kg | CO2 Tersimpan: %.2f kg | Total Pendapatan: Rp%s",
            $totalTransaksi,
            $totalBeratKg,
            $totalCO2,
            number_format($totalPendapatan, 0, ',', '.')
        );
    }

    private function getEnvironmentalImpactData(): string
    {
        $totalCO2 = TransaksiSampah::sum('co2_tersimpan') ?? 0;
        $totalSampah = TransaksiSampah::sum('berat_kg') ?? 0;
        $bulanIniCO2 = TransaksiSampah::whereMonth('created_at', now()->month)->sum('co2_tersimpan') ?? 0;
        $bulanIniSampah = TransaksiSampah::whereMonth('created_at', now()->month)->sum('berat_kg') ?? 0;

        return sprintf(
            "• Setiap 1kg sampah plastik = ~2.5kg CO2 tersimpan (tidak membusuk di TPA)\n"
            . "• Setiap 1kg sampah kertas = ~1.8kg CO2 tersimpan\n"
            . "• Setiap 1kg sampah logam/kaca = ~1.2kg CO2 tersimpan\n"
            . "• Total CO2 tersimpan sistem: %.2f kg\n"
            . "• Total sampah didaur ulang: %.1f kg\n"
            . "• CO2 tersimpan bulan ini: %.2f kg\n"
            . "• Dampak: Setara dengan menanam %.0f pohon atau mengurangi %.0f mobil berjalan sehari\n"
            . "• Manfaat: Mengurangi gas metana berbahaya dari sampah organik di TPA",
            $totalCO2,
            $totalSampah,
            $bulanIniCO2,
            $totalCO2 / 20, // rough estimate: 1 tree absorbs ~20kg CO2 per year
            $totalCO2 / 2.3  // rough estimate: 1 car emits ~2.3kg CO2 per day
        );
    }

    private function getRecentTransactionsForContext(): string
    {
        try {
            $recentTransactions = TransaksiSampah::with(['warga', 'transaksiSampahItems.kategoriSampah'])
                ->where('created_at', '>=', now()->subDays(7))
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            if ($recentTransactions->isEmpty()) {
                return "Belum ada transaksi dalam 7 hari terakhir";
            }

            $transactionList = [];
            foreach ($recentTransactions as $transaction) {
                $items = $transaction->transaksiSampahItems->map(function ($item) {
                    return $item->kategoriSampah->nama . " (" . $item->berat . "kg x Rp" . number_format((float)$item->harga_per_kg) . ")";
                })->join(", ");

                $transactionList[] = date('d/m', strtotime($transaction->created_at)) . ": " .
                                   $transaction->warga->nama_lengkap . " - " .
                                   $items . " = Rp" . number_format($transaction->total_harga);
            }

            return implode("\n", $transactionList);
        } catch (\Exception $e) {
            return "Data transaksi terbaru belum tersedia";
        }
    }

    private function getCurrentMonthData(): string
    {
        try {
            $currentMonth = now()->month;
            $currentYear = now()->year;

            $transaksiBulanIni = TransaksiSampah::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->count();

            $beratBulanIni = TransaksiSampah::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('total_berat') ?? 0;

            $pendapatanBulanIni = TransaksiSampah::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('total_harga') ?? 0;

            $co2BulanIni = TransaksiSampah::whereMonth('created_at', $currentMonth)
                ->whereYear('created_at', $currentYear)
                ->sum('co2_tersimpan') ?? 0;

            return sprintf(
                "Transaksi: %d | Total Berat: %.1f kg | Pendapatan: Rp%s | CO2 Tersimpan: %.2f kg",
                $transaksiBulanIni,
                $beratBulanIni,
                number_format($pendapatanBulanIni, 0, ',', '.'),
                $co2BulanIni
            );
        } catch (\Exception $e) {
            return "Data bulan ini belum tersedia";
        }
    }

    private function getTopCategoriesData(): string
    {
        try {
            $currentMonth = now()->month;
            $currentYear = now()->year;

            $topCategories = TransaksiSampahItem::with('kategoriSampah')
                ->join('transaksi_sampahs', 'transaksi_sampah_items.transaksi_sampah_id', '=', 'transaksi_sampahs.id')
                ->whereMonth('transaksi_sampahs.created_at', $currentMonth)
                ->whereYear('transaksi_sampahs.created_at', $currentYear)
                ->selectRaw('kategori_sampah_id, SUM(berat) as total_berat, SUM(harga_per_kg * berat) as total_nilai')
                ->groupBy('kategori_sampah_id')
                ->orderBy('total_berat', 'desc')
                ->limit(5)
                ->get();

            if ($topCategories->isEmpty()) {
                return "Belum ada data kategori terlaris bulan ini";
            }

            $result = [];
            foreach ($topCategories as $item) {
                $kategori = $item->kategoriSampah;
                if ($kategori) {
                    $result[] = sprintf(
                        "%s: %.1f kg (Rp%s)",
                        $kategori->nama,
                        $item->total_berat,
                        number_format($item->total_nilai, 0, ',', '.')
                    );
                }
            }

            return implode(" | ", $result);
        } catch (\Exception $e) {
            return "Data kategori terlaris belum tersedia";
        }
    }

    private function getFAQData(): string
    {
        return "=== FAQ SISAKU - JAWABAN UMUM (Sisaku) ===\n"
            . "Q1: Siapa yang bisa daftar?\n"
            . "A: Semua warga lokal bisa mendaftar. Cukup bawa KTP dan sampah saat pertama kali.\n\n"
            . "Q2: Sampah apa saja yang diterima?\n"
            . "A: Kami terima sampah daur ulang utama: plastik, kertas, logam, kaca. Lihat daftar kategori di atas untuk detil.\n\n"
            . "Q3: Bagaimana cara mengetahui harga terbaru?\n"
            . "A: Harga dimulai dari Rp500 hingga Rp5000 per kg tergantung jenis sampah. Lihat kategori di atas.\n\n"
            . "Q4: Kapan jam operasional bank sampah?\n"
            . "A: Biasanya buka Senin-Jumat 08:00-16:00. Tanyakan jam lengkap ke admin lokal.\n\n"
            . "Q5: Apakah perlu appointment untuk jual sampah?\n"
            . "A: Tidak perlu! Bisa datang kapan saja jam operasional. Proses cepat & mudah.\n\n"
            . "Q6: Berapa minimum sampah untuk transaksi?\n"
            . "A: Tidak ada minimum. Bisa 1kg atau lebih, semua diterima.\n\n"
            . "Q7: Bagaimana cara bayar? Cash atau transfer?\n"
            . "A: Biasanya langsung cash saat transaksi. Tanya ke admin untuk opsi lain.\n\n"
            . "Q8: Apa itu CO2 tersimpan? Mengapa penting?\n"
            . "A: CO2 tersimpan = sampah yang tidak membusuk di TPA (tempat pembuangan akhir), jadi tidak menciptakan gas metana berbahaya. Itu bantuan nyata untuk bumi!\n\n"
            . "Q9: Apa beda Admin dan Karang Taruna?\n"
            . "A: Admin mengelola sistem keseluruhan (master data, laporan global, reset password). Karang Taruna mengelola operasional lokal (transaksi, warga, kas operasional).\n\n"
            . "Q10: Bagaimana cara input transaksi?\n"
            . "A: Di menu Transaksi, pilih warga, pilih sampah & berat, sistem otomatis hitung harga. Simpan & selesai!\n\n"
            . "Q11: Apa itu Arus Kas?\n"
            . "A: Catat semua uang masuk (penjualan sampah, dll) dan uang keluar (operasional). Penting untuk laporan keuangan organisasi.";
    }

    private function callGeminiAPI(string $userMessage, string $context): string
    {
        try {
            if (!$this->apiKey) {
                \Log::error('Groq API Key is not set');
                return 'API Key tidak terkonfigurasi. Hubungi admin.';
            }

            $requestBody = [
                'model' => 'llama-3.3-70b-versatile',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $context
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 300,
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, $requestBody);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['choices'][0]['message']['content'])) {
                return $responseData['choices'][0]['message']['content'];
            }

            if (isset($responseData['error'])) {
                $errorMsg = $responseData['error']['message'] ?? 'Unknown error';
                \Log::error('Groq API Error: ' . $errorMsg);
                return 'API Error: ' . $errorMsg;
            }

            \Log::error('Groq API Unexpected Response: ' . json_encode($responseData));
            return 'Tidak bisa mendapat jawaban. Coba lagi.';
        } catch (\Exception $e) {
            \Log::error('Groq API Exception: ' . $e->getMessage());
            return 'Koneksi error. Periksa internet.';
        }
    }

    public function getChatHistory(Request $request)
    {
        $sessionId = session('chat_session_id');

        if (!$sessionId) {
            return response()->json(['messages' => []]);
        }

        $messages = ChatHistory::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json(['messages' => $messages]);
    }

    public function clearChat()
    {
        session()->forget('chat_session_id');
        return response()->json(['success' => true]);
    }


}
