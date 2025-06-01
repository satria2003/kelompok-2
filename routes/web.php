<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\CustomerServiceController;
use App\Http\Controllers\Admin\KurirController;
use App\Http\Controllers\Admin\KendaraanController;

// ==============================
// 🔗 ROOT REDIRECT
// ==============================
Route::get('/', fn() => redirect('/login'));

// ==============================
// 👤 USER LOGIN
// ==============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==============================
// 🔐 ADMIN LOGIN
// ==============================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

// ==============================
// 🏠 USER HOME
// ==============================
Route::middleware(['auth'])->get('/home', fn() => view('home'))->name('home');

// ==============================
// 🛠️ ADMIN PANEL
// ==============================
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {

    // 📊 Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard-data', [DashboardController::class, 'getDashboardData']);

    // 📦 Produk
    Route::resource('produk', ProdukController::class);

    // 🛒 Pesanan
    Route::resource('pesanan', PesananController::class)->only(['index', 'destroy', 'show']);
    Route::patch('pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // 👥 Pengguna
    Route::resource('user', UserController::class)->except(['create', 'store', 'edit', 'update']);
    Route::delete('user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

    // 🧾 Laporan Bulanan
    Route::get('laporan-bulanan', [DashboardController::class, 'laporanBulanan'])->name('laporan.bulanan');
    Route::get('laporan-bulanan/pdf', [DashboardController::class, 'laporanBulananPDF'])->name('laporan.bulanan.pdf');

    // 💬 Customer Service
    Route::get('cs/{id_pengguna?}', [CustomerServiceController::class, 'index'])->name('cs.index');
    Route::post('cs/send', [CustomerServiceController::class, 'sendMessage'])->name('cs.send');
    Route::post('cs/message/delete', [CustomerServiceController::class, 'deleteMessage'])->name('cs.message.delete');

    // 🛵 Kurir
    Route::get('kurir', [KurirController::class, 'index'])->name('kurir.index');
    Route::get('kurir/tambah', [KurirController::class, 'create'])->name('kurir.create');
    Route::post('kurir', [KurirController::class, 'store'])->name('kurir.store');

    // ✅ Verifikasi email kurir (admin)
    Route::get('kurir/verifikasi', [KurirController::class, 'showPendaftaranForm'])->name('kurir.verifikasi.form');
    Route::post('kurir/verifikasi', [KurirController::class, 'verifikasi'])->name('kurir.verifikasi');

    // 🚚 Kendaraan
    Route::resource('kendaraan', KendaraanController::class)->except('show');
});
