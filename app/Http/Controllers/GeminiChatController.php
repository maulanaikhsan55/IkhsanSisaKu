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
        $systemWorldview = $this->getSystemWorldview();
        $useCases = $this->getUseCases();

        return "=== 🤖 SISAKU AI HYBRID ASSISTANT ===\n"
            . "KAMU ADALAH AI YANG BISA MENJAWAB DARI DATABASE SISAKU ATAU PENGETAHUAN UMUM.\n"
            . "PRIORITAS: Database dulu, baru pengetahuan umum jika relevan.\n"
            . "User Role: " . ucfirst($userRole) . "\n\n"
            . "=== 🌍 SISTEM WORLDVIEW - SISAKU ADALAH SOLUSI EKONOMI BERKELANJUTAN ===\n"
            . $systemWorldview . "\n\n"
            . "=== 📊 DATABASE SISAKU - DATA TERKINI (PRIORITAS UTAMA) ===\n"
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
            . "=== 💡 USE CASES & SKENARIO NYATA ===\n"
            . $useCases . "\n\n"
            . "=== 🎯 ATURAN JAWABAN - DATABASE FIRST, GENERAL SECOND ===\n"
            . "1. DATABASE PRIORITY: Jika pertanyaan bisa dijawab dari data di atas, GUNAKAN DATA DATABASE\n"
            . "2. GENERAL ALLOWED: Jika pertanyaan umum/tidak ada di database, boleh jawab dari pengetahuan umum\n"
            . "3. SEBUT SUMBER: Untuk database: 'berdasarkan data sistem Sisaku'. Untuk umum: 'secara umum'\n"
            . "4. DETAIL SPESIFIK: Database = angka eksak. Umum = informasi berguna\n"
            . "5. ROLE AWARE: Database sesuai role, umum bisa lebih fleksibel\n"
            . "6. JIKA TIDAK ADA DATA: 'Belum ada data di sistem' atau jawab umum jika relevan\n"
            . "7. FOCUS SISAKU: Usahakan jawaban selalu kembali ke konteks bank sampah\n"
            . "8. HELPFUL FALLBACK: Jika data tidak ada, berikan solusi atau saran praktis\n\n"
            . $roleInstructions . "\n\n"
            . "=== 📋 CONTOH JAWABAN HYBRID ===\n"
            . "Q: 'Berapa harga plastik?' (ADA DI DATABASE)\n"
            . "✅ BENAR: 'Berdasarkan data sistem: Plastik PET Rp2.500/kg, HDPE Rp2.000/kg'\n\n"
            . "Q: 'Apa itu bank sampah?' (TIDAK ADA DI DATABASE)\n"
            . "✅ BENAR: 'Secara umum, bank sampah adalah tempat pengumpulan dan pengolahan sampah daur ulang. Di Sisaku khususnya, kami membantu warga mengelola sampah sambil dapat penghasilan tambahan.'\n\n"
            . "Q: 'Berapa transaksi bulan ini?' (ADA DI DATABASE)\n"
            . "✅ BENAR: 'Berdasarkan data bulan ini: 45 transaksi dengan total 125kg sampah'\n\n"
            . "Q: 'Bagaimana cara daur ulang plastik?' (TIDAK ADA DI DATABASE)\n"
            . "✅ BENAR: 'Secara umum, daur ulang plastik meliputi: 1) Sortir berdasarkan jenis, 2) Cuci bersih, 3) Potong kecil, 4) Lelehkan atau press. Di Sisaku, kami bantu warga dari langkah 1 sampai dapat uang!'\n\n"
            . "=== 🌱 DAMPAK LINGKUNGAN DARI DATABASE ===\n"
            . $environmentalData . "\n\n"
            . $faqData . "\n\n"
            . "=== 📖 PANDUAN JAWABAN FINAL ===\n"
            . "• DATABASE: Prioritas utama untuk data Sisaku (harga, transaksi, statistik)\n"
            . "• UMUM: Boleh untuk pengetahuan bank sampah, lingkungan, daur ulang, best practices\n"
            . "• HYBRID: Gabung database + umum untuk konteks lebih lengkap\n"
            . "• FOCUS: Selalu arahkan percakapan kembali ke manfaat Sisaku\n"
            . "• HELPFUL: Berikan informasi berguna yang bisa bantu user\n"
            . "• PROACTIVE: Jika ada peluang, sarankan fitur yang sesuai dengan role user";
    }

    private function getSystemWorldview(): string
    {
        return "SISAKU ADALAH:\n"
            . "✅ Platform digital untuk pengelolaan bank sampah (trash bank management system)\n"
            . "✅ Solusi ekonomi sirkular: Sampah → Nilai ekonomi → Dampak lingkungan positif\n"
            . "✅ Ekosistem untuk 3 stake holder:\n"
            . "   • WARGA: Jual sampah, dapat penghasilan tambahan, bantu lingkungan\n"
            . "   • KARANG TARUNA: Kelola transaksi lokal, monitoring warga, catat keuangan\n"
            . "   • ADMIN: Kelola master data global, monitor semua KT, lihat dampak lingkungan\n\n"
            . "MODEL BISNIS:\n"
            . "1. Warga kumpulkan sampah daur ulang (plastik, kertas, logam, kaca)\n"
            . "2. Setor ke Karang Taruna (bank sampah lokal)\n"
            . "3. Sistem otomatis hitung harga berdasarkan jenis & berat\n"
            . "4. Warga dapat uang tunai langsung\n"
            . "5. Karang Taruna catat transaksi, kelola kas, monitoring warga\n"
            . "6. Admin pantau statistik global, dampak lingkungan, update master data\n\n"
            . "DAMPAK POSITIF:\n"
            . "🌱 LINGKUNGAN: Sampah tidak ke TPA = kurangi gas metana + CO2\n"
            . "💰 EKONOMI: Warga dapat passive income, Karang Taruna dapat operasional fund\n"
            . "📊 SOSIAL: Meningkatkan kesadaran lingkungan & pemberdayaan masyarakat\n"
            . "🔄 SIRKULAR: Sampah → Uang → Pemberdayaan → Lingkungan sehat\n\n"
            . "UKURAN SUKSES SISAKU:\n"
            . "• Berat sampah yang dikumpulkan (kg) = Kontribusi nyata untuk lingkungan\n"
            . "• Jumlah warga & Karang Taruna = Skala jangkauan\n"
            . "• Total pendapatan warga = Dampak ekonomi nyata\n"
            . "• CO2 tersimpan = Penghitungan dampak lingkungan (pohon, mobil equivalent)\n";
    }

    private function getUseCases(): string
    {
        return "USE CASE 1: WARGA BARU INGIN MULAI JUAL SAMPAH\n"
        . "Pertanyaan: 'Aku punya sampah plastik, gimana cara mulai?'\n"
        . "JAWABAN SISAKU: 'Daftar di Karang Taruna terdekat pake KTP. Datang dengan sampah plastik yang sudah dibersihkan. Kasir akan timbang & hitung harga otomatis. Terima uang cash langsung. Gampang!'\n\n"
        
        . "USE CASE 2: KARANG TARUNA BARU INGIN INPUT TRANSAKSI\n"
        . "Pertanyaan: 'Bagaimana cara input transaksi di Sisaku?'\n"
        . "JAWABAN SISAKU: 'Menu Transaksi → Pilih warga, pilih jenis sampah + berat, sistem otomatis hitung harga, klik Simpan. Selesai! Sistem catat untuk laporan & warga dapat uangnya.'\n\n"
        
        . "USE CASE 3: KARANG TARUNA MELIHAT LAPORAN KEUANGAN\n"
        . "Pertanyaan: 'Gimana cara lihat kas masuk & keluar bulanan?'\n"
        . "JAWABAN SISAKU: 'Menu Arus Kas atau Laporan → Lihat ringkasan kas masuk (hasil jual sampah) & kas keluar (operasional). Bisa export PDF untuk laporan formal.'\n\n"
        
        . "USE CASE 4: ADMIN TRACKING GLOBAL DAMPAK\n"
        . "Pertanyaan: 'Berapa total dampak lingkungan dari semua bank sampah?'\n"
        . "JAWABAN SISAKU: 'Dashboard Admin atau Laporan Dampak Lingkungan → Lihat total CO2 tersimpan, sampah dikumpulkan, dampak equivalent (pohon, mobil, energi listrik yang dihemat)'\n\n"
        
        . "USE CASE 5: KARANG TARUNA MELIHAT WARGA PALING PRODUKTIF\n"
        . "Pertanyaan: 'Siapa warga yang paling sering setor sampah?'\n"
        . "JAWABAN SISAKU: 'Di menu Laporan atau Dashboard KT, lihat statistik warga berdasarkan frekuensi transaksi & total berat. Bisa motivasi mereka untuk terus berkontribusi.'\n\n"
        
        . "USE CASE 6: ADMIN UPDATE HARGA SAMPAH\n"
        . "Pertanyaan: 'Harga plastik turun, bagaimana update di sistem?'\n"
        . "JAWABAN SISAKU: 'Menu Master Data → Kategori Sampah → Cari plastik, edit harga per kg, simpan. Otomatis terpakai untuk semua transaksi berikutnya.'\n\n"
        
        . "USE CASE 7: LAPORAN UNTUK STAKEHOLDER\n"
        . "Pertanyaan: 'Aku perlu laporan dampak lingkungan untuk proposal ke pemerintah'\n"
        . "JAWABAN SISAKU: 'Menu Laporan → Dampak Lingkungan → Lihat semua metrik (CO2, sampah, equivalent pohon/mobil/energi). Export PDF, siap presentasi!'";
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
        return "=== 📋 FAQ SISAKU - JAWABAN LENGKAP & HYBRID ===\n"
            . "--- UNTUK WARGA (Calon Penjual Sampah) ---\n"
            . "Q1: Siapa yang bisa daftar?\n"
            . "A: Semua warga lokal bisa mendaftar. Cukup bawa KTP dan sampah saat pertama kali.\n\n"
            
            . "Q2: Sampah apa saja yang diterima?\n"
            . "A: Kami terima sampah daur ulang utama: plastik, kertas, logam, kaca. Lihat daftar kategori di atas untuk harga spesifik setiap jenis.\n\n"
            
            . "Q3: Bagaimana cara mengetahui harga terbaru?\n"
            . "A: Harga di Sisaku dimulai dari Rp500 hingga Rp5000 per kg tergantung jenis sampah. Lihat kategori di atas untuk harga spesifik. Harga bisa berubah sesuai pasar, tanya ke Karang Taruna untuk update terbaru.\n\n"
            
            . "Q4: Apa itu bank sampah dan kenapa penting?\n"
            . "A: Bank sampah adalah tempat warga kumpulin & jual sampah daur ulang sambil dapat uang. Penting karena: 1) Warga punya passive income, 2) Mengurangi sampah ke TPA, 3) Bantu lingkungan dari gas metana berbahaya, 4) Dukung ekonomi sirkular lokal.\n\n"
            
            . "Q5: Kapan jam operasional bank sampah?\n"
            . "A: Biasanya buka Senin-Jumat 08:00-16:00. Cek dengan Karang Taruna terdekat untuk jam lengkap & hari libur.\n\n"
            
            . "Q6: Apakah perlu appointment untuk jual sampah?\n"
            . "A: Tidak perlu! Bisa datang kapan saja jam operasional. Proses cepat & mudah - timbang, hitung otomatis, dapat uang.\n\n"
            
            . "Q7: Berapa minimum sampah untuk transaksi?\n"
            . "A: Tidak ada minimum. Bisa 1kg atau lebih, semua diterima. Semakin banyak, semakin banyak uang.\n\n"
            
            . "Q8: Bagaimana cara bayar? Cash atau transfer?\n"
            . "A: Biasanya langsung cash saat transaksi. Tanya ke admin/Karang Taruna untuk opsi pembayaran lain (transfer, cheque, dll).\n\n"
            
            . "Q9: Persiapan apa sebelum jual sampah?\n"
            . "A: Siapkan sampah yang sudah dibersihkan (cuci plastik, jemur kertas). Jangan campur jenis sampah, pisahkan plastik, kertas, logam, kaca. Ini bikin proses lebih cepat & harga lebih baik.\n\n"
            
            . "--- UNTUK KARANG TARUNA (Bank Sampah Lokal) ---\n"
            . "Q10: Bagaimana cara input transaksi?\n"
            . "A: Menu Transaksi → Pilih warga, pilih jenis sampah + berat, sistem otomatis hitung harga, klik Simpan. Selesai! Sistem catat untuk laporan & warga dapat uangnya.\n\n"
            
            . "Q11: Apa itu Arus Kas dan bagaimana cara kelolanya?\n"
            . "A: Arus Kas = catat semua uang masuk (hasil jual sampah, dll) dan uang keluar (operasional, bonus petugas, dll). Penting untuk: 1) Transparansi keuangan, 2) Laporan resmi, 3) Planning operasional bulan depan.\n\n"
            
            . "Q12: Bagaimana cara lihat laporan bulanan?\n"
            . "A: Menu Laporan → Lihat ringkasan arus kas bulanan, transaksi, warga aktif, sampah terkumpul. Bisa export PDF untuk stakeholder.\n\n"
            
            . "Q13: Bagaimana cara monitor warga paling produktif?\n"
            . "A: Dashboard atau menu Laporan → Lihat statistik warga berdasarkan frekuensi transaksi & total berat sampah. Identifikasi top contributor, berikan apresiasi, motivasi yang lain.\n\n"
            
            . "Q14: Apa itu dampak lingkungan dan cara lapornya?\n"
            . "A: Dampak lingkungan = CO2 tersimpan (sampah tidak ke TPA), setara dengan pohon yang ditanam. Menu Laporan → Dampak Lingkungan → Lihat semua metrik. Bagus untuk advocacy & laporan ke stakeholder.\n\n"
            
            . "--- UNTUK ADMIN (Sistem Global) ---\n"
            . "Q15: Apa beda Admin dan Karang Taruna?\n"
            . "A: Admin mengelola sistem keseluruhan (master data, laporan global semua KT, reset password, pengaturan). Karang Taruna mengelola operasional lokal (transaksi, warga, kas operasional KT).\n\n"
            
            . "Q16: Bagaimana cara update harga sampah?\n"
            . "A: Menu Master Data → Kategori Sampah → Cari kategori, edit harga per kg, simpan. Otomatis terpakai untuk semua transaksi berikutnya di semua KT.\n\n"
            
            . "Q17: Bagaimana cara kelola Karang Taruna (CRUD)?\n"
            . "A: Menu Karang Taruna → Lihat semua KT terdaftar. Bisa tambah KT baru, edit info (nama, RW, kontak), hapus, lihat detail & statistik.\n\n"
            
            . "Q18: Apa itu Arus Kas admin dan beda dengan KT?\n"
            . "A: Admin Arus Kas = gabung semua kas masuk & keluar dari semua KT (global perspective). KT Arus Kas = hanya kas lokal mereka. Admin gunakan untuk laporan keuangan organisasi besar, transparansi dana, planning global.\n\n"
            
            . "--- TEKNOLOGI & LINGKUNGAN ---\n"
            . "Q19: Apa itu CO2 tersimpan? Mengapa penting?\n"
            . "A: CO2 tersimpan = sampah yang tidak membusuk di TPA (tempat pembuangan akhir), jadi tidak menciptakan gas metana berbahaya (GRK 25x lebih kuat dari CO2). Penting karena: 1) Bantu kurangi perubahan iklim, 2) Dampak nyata lingkungan, 3) Bisa hitung impact seperti pohon ditanam.\n\n"
            
            . "Q20: Bagaimana cara hitung dampak lingkungan?\n"
            . "A: Sistem otomatis hitung based on jenis sampah & berat. Contoh: Plastik 1kg = ~2.5kg CO2 tersimpan. Kertas 1kg = ~1.8kg CO2. Setara menanam 1 pohon absorb ~20kg CO2/tahun, 1 mobil emit ~2.3kg CO2/hari. Lihat dashboard untuk total dampak sistem.\n\n"
            
            . "Q21: Bagaimana cara bayar untuk fitur premium (jika ada)?\n"
            . "A: Sisaku fokus on accessibility. Cek dengan admin untuk paket pricing & opsi pembayaran. Biasanya berbasis per Karang Taruna.\n\n"
            
            . "--- TROUBLESHOOTING ---\n"
            . "Q22: Lupa password, gimana reset?\n"
            . "A: Admin bisa reset password dari menu Password Reset. Atau gunakan 'Forgot Password' di login page.\n\n"
            
            . "Q23: Data tidak muncul atau ada error, gimana?\n"
            . "A: 1) Refresh halaman, 2) Clear browser cache, 3) Cek koneksi internet, 4) Hubungi admin Sisaku untuk support technical.";
    }

    private function callGeminiAPI(string $userMessage, string $context): string
    {
        try {
            if (!$this->apiKey) {
                \Log::error('Groq API Key is not set');
                return $this->getFallbackResponse($userMessage);
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
                return $this->getFallbackResponse($userMessage);
            }

            \Log::error('Groq API Unexpected Response: ' . json_encode($responseData));
            return $this->getFallbackResponse($userMessage);
        } catch (\Exception $e) {
            \Log::error('Groq API Exception: ' . $e->getMessage());
            return $this->getFallbackResponse($userMessage);
        }
    }

    private function getFallbackResponse(string $userMessage): string
    {
        $message = strtolower($userMessage);

        // GREETINGS
        if (preg_match('/(hai|halo|hello|pagi|sore|malam|assalamualaikum|apa kabar)/', $message)) {
            return "Halo! 👋 Selamat datang di Sisaku Chat. Saya adalah asisten AI untuk membantu Anda dengan sistem Bank Sampah Sisaku. Tanya tentang apapun: harga sampah, cara input transaksi, laporan, atau fitur lainnya. Ada yang bisa saya bantu?";
        }

        // HARGA SAMPAH / PRICING
        if (preg_match('/(harga|berapa|berapakah|cost|price|nilai jual)/', $message)) {
            return "📊 Untuk informasi harga sampah terbaru, silakan lihat menu Master Data > Kategori Sampah. Harga bervariasi tergantung jenis sampah daur ulang (plastik, kertas, logam, kaca). Harga dimulai dari Rp500 - Rp5000/kg. Hubungi Karang Taruna lokal untuk harga terkini di area Anda.";
        }

        // TRANSAKSI / PENJUALAN
        if (preg_match('/(transaksi|cara jual|input transaksi|jual sampah)/', $message)) {
            return "💰 Untuk melakukan transaksi penjualan sampah:\n1. Menu Transaksi → Pilih warga\n2. Pilih kategori sampah & berat\n3. Sistem otomatis hitung harga\n4. Klik Simpan\n\nSistem akan otomatis catat untuk laporan & warga dapat uangnya cash.";
        }

        // WARGA / PENDAFTARAN
        if (preg_match('/(warga|pendaftaran|daftar|member|register)/', $message)) {
            return "👥 Untuk mengelola data warga:\n• Menu Warga → Lihat semua warga terdaftar\n• Tambah warga baru (nama, KTP, kontak)\n• Edit data warga yang sudah ada\n• Hapus data warga\n\nSemua warga lokal bisa daftar dengan KTP dan sampah pertama kali.";
        }

        // LAPORAN & REPORT
        if (preg_match('/(laporan|report|statistik|dampak lingkungan|co2)/', $message)) {
            return "📈 Untuk melihat laporan:\n• Menu Laporan → Lihat ringkasan:\n  - Arus Kas (kas masuk & keluar bulanan)\n  - Dampak Lingkungan (CO2 tersimpan, pohon, mobil equivalent)\n  - Transaksi & warga produktif\n• Semua laporan bisa export PDF untuk stakeholder.";
        }

        // ARUS KAS / KEUANGAN
        if (preg_match('/(arus kas|kas masuk|kas keluar|keuangan|uang|operasional|pendapatan)/', $message)) {
            return "💵 Untuk mengelola Arus Kas:\n• Menu Arus Kas → Catat semua transaksi\n• Kas Masuk: Hasil penjualan sampah, bonus, dll\n• Kas Keluar: Operasional, bonus petugas, dll\n• Penting untuk transparansi & laporan keuangan organisasi\n• Bisa lihat ringkasan bulanan & tahunan.";
        }

        // MENU / FITUR
        if (preg_match('/(menu|fitur|apa saja|feature|available)/', $message)) {
            $role = $this->getUserRole();
            if ($role === 'admin') {
                return "🔧 Menu Admin SISAKU:\n• Dashboard - Ringkasan sistem global\n• Karang Taruna - Kelola semua KT\n• Master Data - Update kategori sampah & keuangan\n• Laporan - Arus kas & dampak lingkungan global\n• Reset Password - Tangani permintaan reset\n• Pengaturan - Konfigurasi sistem";
            } elseif ($role === 'karang_taruna') {
                return "🏠 Menu Karang Taruna SISAKU:\n• Dashboard - Ringkasan aktivitas KT\n• Warga - Kelola data warga\n• Transaksi - Input penjualan sampah\n• Arus Kas - Catat kas masuk & keluar\n• Laporan - Arus kas & dampak lingkungan KT\n• Pengaturan - Update info organisasi";
            }
            return "📱 Menu SISAKU:\n• Dashboard - Lihat ringkasan\n• Informasi Warga & Transaksi\n• Laporan Arus Kas & Dampak Lingkungan\n• Pengaturan Akun\n\nHubungi Karang Taruna lokal untuk akses lengkap.";
        }

        // BANK SAMPAH / SISTEM OVERVIEW
        if (preg_match('/(apa itu|bank sampah|sisaku|sistem|cara kerja|bagaimana)/', $message)) {
            return "🌍 Sisaku - Bank Sampah Digital:\nSisaku adalah platform untuk mengelola bank sampah dengan 3 role:\n• WARGA: Jual sampah, dapat passive income\n• KARANG TARUNA: Kelola transaksi & warga lokal\n• ADMIN: Monitor global, update master data\n\n🔄 Model: Sampah → Uang → Pemberdayaan → Lingkungan Sehat\n🌱 Dampak: Kurangi sampah ke TPA, CO2, gas metana berbahaya";
        }

        // REGISTRASI / LOGIN
        if (preg_match('/(lupa password|reset|login|username|password)/', $message)) {
            return "🔐 Untuk masalah login:\n• Lupa password? → Gunakan 'Forgot Password' di halaman login\n• Admin bisa reset password → Menu Password Reset\n• Hubungi admin sistem untuk akses atau activation";
        }

        // DAMPAK LINGKUNGAN / ENVIRONMENTAL
        if (preg_match('/(lingkungan|eco|green|sustainability|pohon|mobil|co2|metana)/', $message)) {
            return "🌱 Dampak Lingkungan SISAKU:\n• Setiap kg sampah plastik = ~2.5kg CO2 tersimpan\n• Setiap kg kertas = ~1.8kg CO2 tersimpan\n• 1 pohon absorb ~20kg CO2/tahun\n• 1 mobil emit ~2.3kg CO2/hari\n\nDampak nyata: Sampah tidak ke TPA = kurangi gas metana (25x lebih kuat dari CO2). Bantu iklim sambil dapat uang! 💚";
        }

        // DEFAULT HELPFUL RESPONSE
        return "👋 Saya adalah asisten AI Sisaku. Mohon maaf, saya sedang dalam mode limited (AI offline). Namun saya masih bisa membantu dengan info dasar tentang:\n\n✅ Harga sampah\n✅ Cara input transaksi\n✅ Manajemen warga & kas\n✅ Laporan & dampak lingkungan\n✅ Menu & fitur sistem\n\nUntuk AI chat lengkap, silakan refresh atau hubungi admin sistem.";
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