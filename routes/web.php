<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\KarangTaruna\DashboardController as KTDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes aplikasi, dipisahkan berdasarkan area (public, auth, admin, karang-taruna).
| Semua route admin dilindungi middleware 'auth' + 'admin', sedangkan karang-taruna
| dilindungi oleh 'auth' + 'karang_taruna'.
|
*/

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Chatbot routes (public access)
Route::post('/chatbot/send', [App\Http\Controllers\GeminiChatController::class, 'sendMessage'])->name('chatbot.send');
Route::get('/chatbot/history', [App\Http\Controllers\GeminiChatController::class, 'getChatHistory'])->name('chatbot.history');
Route::post('/chatbot/clear', [App\Http\Controllers\GeminiChatController::class, 'clearChat'])->name('chatbot.clear');

Route::middleware('auth')->group(function () {
    // Other authenticated routes can go here if needed
});

// ============================================
// AUTHENTICATION ROUTES
// ============================================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes (Laravel default)
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

// ============================================
// ADMIN ROUTES (Protected by 'admin' middleware)
// ============================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Password Reset Routes
    Route::prefix('password-reset')->name('password-reset.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PasswordResetController::class, 'index'])->name('index');
        Route::post('/{passwordResetRequest}/reset', [App\Http\Controllers\Admin\PasswordResetController::class, 'reset'])->name('reset');
        Route::get('/history', [App\Http\Controllers\Admin\PasswordResetController::class, 'history'])->name('history');
        Route::get('/api/pending-count', [App\Http\Controllers\Admin\PasswordResetController::class, 'getPendingCount'])->name('api.pending-count');
    });

    // Karang Taruna CRUD + additional actions (export, force-delete)
    // Keep export route before resource if you ever use similar slug patterns (safe placement anyway)
    Route::get('karang-taruna/export/pdf', [App\Http\Controllers\Admin\KarangTarunaController::class, 'exportPdf'])->name('karang-taruna.export-pdf');

    // Resource (index, create, store, show, edit, update, destroy)
    Route::resource('karang-taruna', App\Http\Controllers\Admin\KarangTarunaController::class);

    // Force delete (permanent) - non-standard DELETE route with suffix
    Route::delete('karang-taruna/{karangTaruna}/force-delete', [App\Http\Controllers\Admin\KarangTarunaController::class, 'forceDelete'])
        ->name('karang-taruna.force-delete');

    // Master Data Routes
    Route::prefix('master-data')->name('master-data.')->group(function () {
        // Kategori Sampah CRUD
        Route::get('/kategori-sampah', [App\Http\Controllers\Admin\MasterDataController::class, 'kategoriSampah'])->name('kategori-sampah');
        Route::post('/kategori-sampah/bulk-update', [App\Http\Controllers\Admin\MasterDataController::class, 'bulkUpdateHarga'])->name('kategori-sampah.bulk-update');
        Route::post('/kategori-sampah', [App\Http\Controllers\Admin\MasterDataController::class, 'storeKategoriSampah'])->name('kategori-sampah.store');
        Route::put('/kategori-sampah/{id}', [App\Http\Controllers\Admin\MasterDataController::class, 'updateKategoriSampah'])->name('kategori-sampah.update');
        Route::delete('/kategori-sampah/{id}', [App\Http\Controllers\Admin\MasterDataController::class, 'destroyKategoriSampah'])->name('kategori-sampah.destroy');

        // Kategori Keuangan CRUD
        Route::get('/kategori-keuangan', [App\Http\Controllers\Admin\MasterDataController::class, 'kategoriKeuangan'])->name('kategori-keuangan');
        Route::post('/kategori-keuangan', [App\Http\Controllers\Admin\MasterDataController::class, 'storeKategoriKeuangan'])->name('kategori-keuangan.store');

        Route::put('/kategori-keuangan/{id}', [App\Http\Controllers\Admin\MasterDataController::class, 'updateKategoriKeuangan'])->name('kategori-keuangan.update');
        Route::delete('/kategori-keuangan/{id}', [App\Http\Controllers\Admin\MasterDataController::class, 'destroyKategoriKeuangan'])->name('kategori-keuangan.destroy');
    });

    // Laporan Routes
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('index');
        Route::get('/arus-kas', [App\Http\Controllers\Admin\LaporanController::class, 'arusKas'])->name('arus-kas');
        Route::get('/arus-kas/export-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'exportArusKasPdf'])->name('arus-kas.export-pdf');

        Route::get('/dampak-lingkungan', [App\Http\Controllers\Admin\LaporanController::class, 'dampakLingkungan'])->name('dampak-lingkungan');
        Route::get('/dampak-lingkungan/export-pdf', [App\Http\Controllers\Admin\LaporanController::class, 'exportDampakPdf'])->name('dampak-lingkungan.export-pdf');
    });

    // Pengaturan
    Route::get('/pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan');
    Route::put('/pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');

    // TODO: Tambah route admin lainnya di sini
});

// ============================================
// KARANG TARUNA ROUTES (Protected by 'karang_taruna' middleware)
// ============================================
Route::prefix('karang-taruna')->name('karang-taruna.')->middleware(['auth', 'karang_taruna', 'check_karang_taruna_active'])->group(function () {
    Route::get('/dashboard', [KTDashboardController::class, 'index'])->name('dashboard');

    Route::get('/pengaturan', [App\Http\Controllers\KarangTaruna\PengaturanController::class, 'index'])->name('pengaturan');
    Route::put('/pengaturan', [App\Http\Controllers\KarangTaruna\PengaturanController::class, 'update'])->name('pengaturan.update');

    // Helper routes for AJAX
    Route::get('/get-harga-sampah/{kategoriId}', [App\Http\Controllers\KarangTaruna\TransaksiController::class, 'getHargaSampah'])->name('get-harga-sampah');
    Route::get('/transaksi/filter', [App\Http\Controllers\KarangTaruna\TransaksiController::class, 'filter'])->name('transaksi.filter');

    // Transaksi payment routes - static routes BEFORE parameterized routes
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/bulk-payment', [App\Http\Controllers\KarangTaruna\TransaksiController::class, 'showBulkPayment'])->name('showBulkPayment');
        Route::post('/bulk-payment', [App\Http\Controllers\KarangTaruna\TransaksiController::class, 'bulkProcessPayment'])->name('bulkProcessPayment');
        Route::post('/{transaksi}/quick-payment', [App\Http\Controllers\KarangTaruna\TransaksiController::class, 'quickPayment'])->name('quickPayment');
        Route::get('/{transaksi}/process-payment', [App\Http\Controllers\KarangTaruna\TransaksiController::class, 'processPaymentForm'])->name('processPaymentForm');
        Route::put('/{transaksi}/process-payment', [App\Http\Controllers\KarangTaruna\TransaksiController::class, 'processPayment'])->name('processPayment');
    });

    // Resources specific to Karang Taruna users
    Route::resource('warga', App\Http\Controllers\KarangTaruna\WargaController::class);
    Route::get('/warga/search', [App\Http\Controllers\KarangTaruna\WargaController::class, 'search'])->name('warga.search');
    Route::get('/warga/export/pdf', [App\Http\Controllers\KarangTaruna\WargaController::class, 'exportPdf'])->name('warga.export-pdf');
    Route::resource('transaksi', App\Http\Controllers\KarangTaruna\TransaksiController::class);

    // Arus Kas (Kas Masuk & Keluar)
    Route::prefix('arus-kas')->name('arus-kas.')->group(function () {
        Route::get('/', [App\Http\Controllers\KarangTaruna\ArusKasController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\KarangTaruna\ArusKasController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\KarangTaruna\ArusKasController::class, 'store'])->name('store');
        Route::get('/{arusKas}/edit', [App\Http\Controllers\KarangTaruna\ArusKasController::class, 'edit'])->name('edit');
        Route::put('/{arusKas}', [App\Http\Controllers\KarangTaruna\ArusKasController::class, 'update'])->name('update');
        Route::delete('/{arusKas}', [App\Http\Controllers\KarangTaruna\ArusKasController::class, 'destroy'])->name('destroy');
    });

    // Laporan (Reports)
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/arus-kas', [App\Http\Controllers\KarangTaruna\ReportController::class, 'arusKas'])->name('arus-kas');
        Route::get('/arus-kas/export-pdf', [App\Http\Controllers\KarangTaruna\ReportController::class, 'exportArusKasPdf'])->name('arus-kas.export-pdf');
        Route::get('/dampak-lingkungan', [App\Http\Controllers\KarangTaruna\ReportController::class, 'dampakLingkungan'])->name('dampak-lingkungan');
        Route::get('/dampak-lingkungan/export-pdf', [App\Http\Controllers\KarangTaruna\ReportController::class, 'exportDampakLingkunganPdf'])->name('dampak-lingkungan.export-pdf');
    });
});
