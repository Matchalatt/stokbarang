<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController; // 1. Uncomment dan pastikan AuthController sudah dibuat
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PurchasingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

##
## Rute Autentikasi (Guest)
##

// Mengarahkan halaman utama (root) ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rute untuk MENAMPILKAN halaman login
Route::get('/login', function () {
    return view('welcome');
})->name('login');

// 2. Rute untuk MEMPROSES data dari form login
Route::post('/login', [AuthController::class, 'login']);

// Rute untuk MENAMPILKAN halaman registrasi
Route::get('/register', function () {
    return view('register');
})->name('register');

// Rute untuk MEMPROSES data dari form registrasi
Route::post('/register', [AuthController::class, 'store']); // <-- Tambahkan ini

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk MEMPROSES data dari form registrasi (bisa diaktifkan nanti)
// Route::post('/register', [AuthController::class, 'store']);


##
## Rute Admin
##

Route::prefix('sales')->name('sales.')->group(function () {
    Route::get('/dashboard', [SalesController::class, 'index'])->name('dashboard');
    Route::post('/order-requests', [SalesController::class, 'store'])->name('order-requests.store');
});
// Grup Rute untuk semua fungsionalitas Admin
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute untuk menampilkan dashboard & daftar user yang perlu disetujui
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Rute untuk memproses persetujuan user
    Route::patch('/users/{user}/approve', [AdminController::class, 'approve'])->name('approve');
});

## Rute Purchasing
##
Route::prefix('purchasing')->name('purchasing.')->group(function () {
    // Menampilkan dashboard utama
    Route::get('/dashboard', [PurchasingController::class, 'index'])->name('dashboard');
    
    // Menampilkan halaman detail/edit
    Route::get('/order-requests/{orderRequest}/edit', [PurchasingController::class, 'edit'])->name('order-requests.edit');

    // Memproses update (edit jumlah & harga)
    Route::put('/order-requests/{orderRequest}', [PurchasingController::class, 'update'])->name('order-requests.update');
    
    // Memproses perubahan status
    Route::patch('/order-requests/{orderRequest}/update-status', [PurchasingController::class, 'updateStatus'])->name('order-requests.update-status');
});