<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PesananController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\BinderbyteController;
use App\Http\Controllers\Api\DashboardDataController;
use App\Http\Controllers\Api\AlamatPenggunaController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\AlamatPengirimController;
use App\Http\Controllers\Api\KurirController;
use App\Http\Controllers\Api\KendaraanController; // ✅ Tambahkan ini

// =======================
// 🔓 PUBLIC ROUTES
// =======================

// 👤 Autentikasi Umum
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/verify-token', [AuthController::class, 'verifyToken']);
Route::post('/resend-token', [AuthController::class, 'resendToken']);

// 👮 Login Admin & CS
Route::post('/admin/login', [AuthController::class, 'apiLoginAdmin']);

// ✅ Login Kurir menggunakan AuthController
Route::post('/kurir/login', [AuthController::class, 'loginKurir']);
Route::post('/kurir/verifikasi-token', [AuthController::class, 'verifikasiTokenKurir']);

// 📦 Produk & Ulasan
Route::get('/produk', [ProdukController::class, 'index']);
Route::get('/produk/{id}', [ProdukController::class, 'show']);
Route::get('/produk/{id}/ulasan', [UlasanController::class, 'list']);

// 📊 Dashboard (Publik)
Route::get('/dashboard-data', [DashboardDataController::class, 'get']);

// 🚚 Ongkir & Wilayah
Route::get('/provinces', [BinderbyteController::class, 'getProvinces']);
Route::get('/cities', [BinderbyteController::class, 'getCities']);
Route::post('/ongkir', [BinderbyteController::class, 'checkOngkir']);

// 📍 Alamat Pengirim (Admin)
Route::get('/alamat-admin', [AlamatPengirimController::class, 'get']);

// 💳 Midtrans Callback & Testing
Route::post('/payment/callback', [PaymentController::class, 'callback']);
Route::post('/payment/test-snap', [PaymentController::class, 'testMidtrans']);

// 📦 Detail Pesanan (Admin)
Route::get('/admin/pesanan/{id}', [PesananController::class, 'show'])->name('admin.pesanan.show');

// 💬 Chat Umum (Pengguna ke Admin)
Route::post('/chat', [ChatController::class, 'store']);
Route::get('/chat/{id_pengguna}', [ChatController::class, 'index']);
Route::post('/chat/upload', [ChatController::class, 'uploadImage']);
Route::post('/chat/upload-file', [ChatController::class, 'uploadFile']);
Route::post('/admin/chat/reply', [ChatController::class, 'adminReply']);

// =======================
// 🔐 PROTECTED ROUTES (auth:sanctum)
// =======================
Route::middleware('auth:sanctum')->group(function () {
    // 👤 Akun & Profil Pengguna
    Route::get('/me', [ProfileController::class, 'me']);
    Route::get('/akun', [ProfileController::class, 'me']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/ubah-password', [ProfileController::class, 'ubahPassword']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // 📍 Alamat Pengguna
    Route::get('/alamat', [AlamatPenggunaController::class, 'index']);
    Route::get('/alamat/default', [AlamatPenggunaController::class, 'default']);
    Route::post('/alamat', [AlamatPenggunaController::class, 'store']);
    Route::put('/alamat/{id}', [AlamatPenggunaController::class, 'update']);
    Route::delete('/alamat/{id}', [AlamatPenggunaController::class, 'destroy']);
    Route::put('/alamat-pengirim/{id}', [AlamatPengirimController::class, 'update']);

    // 🛒 Keranjang
    Route::get('/keranjang', [KeranjangController::class, 'index']);
    Route::post('/keranjang', [KeranjangController::class, 'store']);
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update']);
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy']);

    // 📦 Pesanan
    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::post('/pesanan', [PesananController::class, 'store']);

    // ✍️ Ulasan Produk
    Route::post('/produk/{id}/ulasan', [UlasanController::class, 'store']);
    Route::put('/ulasan/{id}', [UlasanController::class, 'update']);
    Route::delete('/ulasan/{id}', [UlasanController::class, 'destroy']);

    // 💳 Midtrans Payment
    Route::post('/payment/snap-token', [PaymentController::class, 'getSnapToken']);
    Route::post('/payment/checkout', [PaymentController::class, 'checkout']);

    // 🔔 Notifikasi & Chat CS
    Route::get('/chat/unread-count/{id_pengguna}', [ChatController::class, 'unreadCount']);
    Route::get('/messages', [MessageController::class, 'index']);
    Route::get('/messages/{id_pengguna}', [MessageController::class, 'getMessages']);
    Route::post('/messages', [MessageController::class, 'store']);
    Route::post('/messages/send', [MessageController::class, 'sendMessage']);

    // 🚚 Kurir
    Route::get('/kurir/profile', [KurirController::class, 'profile']);
    Route::get('/kurir/pesanan', [KurirController::class, 'daftarPesanan']);
    Route::post('/kurir/pesanan/{id}/update-status', [KurirController::class, 'updateStatus']);

    // 🚛 Kendaraan
    Route::get('/kendaraan', [KendaraanController::class, 'index']);
    Route::post('/kendaraan', [KendaraanController::class, 'store']);
    Route::post('/kendaraan/{id}/toggle', [KendaraanController::class, 'togglePenggunaan']);
});
