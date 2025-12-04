<?php

namespace App\Http\Controllers;

use App\Models\ChatHistory;
use App\Models\KategoriSampah;
use App\Models\KategoriKeuangan;
use App\Models\TransaksiSampah;
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
    private $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';

    public function __construct()
    {
        $this->apiKey = config('app.gemini_api_key') ?? env('GEMINI_API_KEY');
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
        
        $roleContext = $this->getRoleSpecificContext($userRole);
        
        $roleInstructions = $this->getRoleSpecificInstructions($userRole);
        
        return "Role: Kamu adalah Assistant AI untuk Sisaku - Sistem Manajemen Bank Sampah Indonesia.\n"
            . "Bahasa: Jawab dalam bahasa Indonesia santai dan ramah.\n"
            . "Kepribadian: Membantu, responsif, dan sangat tahu tentang bank sampah.\n"
            . "User Role: " . ucfirst($userRole) . "\n\n"
            . "=== DATA TERKINI DARI DATABASE ===\n"
            . "KATEGORI SAMPAH YANG KAMI TERIMA:\n"
            . $kategoriData . "\n\n"
            . "STATISTIK SISTEM SISAKU:\n"
            . $statistikData . "\n\n"
            . $roleContext . "\n\n"
            . "=== PENGETAHUAN UMUM TENTANG SISAKU ===\n"
            . "Sisaku adalah platform manajemen bank sampah yang membantu:\n"
            . "• Warga setempat menjual sampah daur ulang dengan harga fair\n"
            . "• Mengurangi sampah plastik dan limbah di lingkungan\n"
            . "• Mendapat penghasilan tambahan dari sampah\n"
            . "• Berkontribusi pada lingkungan yang lebih bersih\n\n"
            . "CARA TRANSAKSI:\n"
            . "1. Warga membawa sampah ke bank sampah terdekat\n"
            . "2. Sampah ditimbang dan dikategorikan sesuai jenisnya\n"
            . "3. Mendapat uang langsung berdasarkan harga per kg\n"
            . "4. Transaksi tercatat di sistem Sisaku\n\n"
            . "MANFAAT PROGRAM:\n"
            . "✓ Penghasilan tambahan untuk masyarakat\n"
            . "✓ Mengurangi limbah sampah plastik\n"
            . "✓ Setiap kg sampah bisa menyimpan CO2 dan membantu lingkungan\n"
            . "✓ Mendukung ekonomi sirkular dan komunitas lokal\n\n"
            . $faqData . "\n\n"
            . "=== INSTRUKSI UMUM ===\n"
            . "1. GUNAKAN DATA REAL: Selalu rujuk ke data database untuk jawaban spesifik\n"
            . "2. AKURAT & DETAIL: Sebutkan nama, harga, deskripsi dengan jelas\n"
            . "3. RAMAH & MEMBANTU: Jelaskan proses dengan detail, gunakan emoji jika sesuai\n"
            . "4. DAMPAK POSITIF: Jelaskan manfaat CO2 dan lingkungan saat relevan\n"
            . "5. OUT OF SCOPE: Jika ditanya hal luar Sisaku, kembalikan dengan ramah ke topik Sisaku\n\n"
            . $roleInstructions . "\n\n"
            . "=== CONTOH JAWABAN YANG BAIK ===\n"
            . "Q: 'Berapa harga plastik?' → A: 'Plastik kami bayar [harga]/kg dengan [deskripsi]. Bisa bawa kapan saja!'\n"
            . "Q: 'Cara daftar?' → A: 'Sudah terdaftar dengan hanya bawa sampah & KTP! Proses cepat & mudah.'\n"
            . "Q: 'Berapa CO2 terselamatkan?' → A: 'Setiap [X]kg sampah = [Y]kg CO2 tersimpan! Bantuan nyata untuk bumi!'";
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
                \Log::error('Gemini API Key is not set');
                return 'API Key tidak terkonfigurasi. Hubungi admin.';
            }

            $requestBody = [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [['text' => $context . "\n\nPertanyaan: " . $userMessage]]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 300,
                ]
            ];

            $response = Http::timeout(30)
                ->post($this->apiUrl . '?key=' . $this->apiKey, $requestBody);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
                return $responseData['candidates'][0]['content']['parts'][0]['text'];
            }

            if (isset($responseData['error'])) {
                $errorMsg = $responseData['error']['message'] ?? 'Unknown error';
                \Log::error('Gemini API Error: ' . $errorMsg);
                
                if (strpos($errorMsg, 'not found') !== false || strpos($errorMsg, 'not supported') !== false) {
                    return 'Model tidak tersedia. Admin perlu update API key atau model.';
                }
                
                return 'API Error: ' . $errorMsg;
            }

            \Log::error('Gemini API Unexpected Response: ' . json_encode($responseData));
            return 'Tidak bisa mendapat jawaban. Coba lagi.';
        } catch (\Exception $e) {
            \Log::error('Gemini API Exception: ' . $e->getMessage());
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
