<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

// --- ADMIN CONTROLLERS ---
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\DokterController as AdminDokterCtrl; 
use App\Http\Controllers\Admin\PasienController as AdminPasienCtrl;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Admin\VerifikasiPembayaranController;

// --- DOKTER CONTROLLERS ---
use App\Http\Controllers\Dokter\DashboardController as DokterDashboard;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;

// --- PASIEN CONTROLLERS ---
use App\Http\Controllers\Pasien\DashboardController as PasienDashboard;
use App\Http\Controllers\Pasien\DaftarPoliController;
use App\Http\Controllers\Pasien\RiwayatPendaftaranController;
use App\Http\Controllers\Pasien\PembayaranController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) return redirect()->route('login');

    return match ($user->role) {
        'admin'  => redirect()->route('admin.dashboard'),
        'dokter' => redirect()->route('dokter.dashboard'),
        'pasien' => redirect()->route('pasien.dashboard'),
        default  => abort(403),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        
        Route::get('/dokter/export', [AdminDokterCtrl::class, 'export'])->name('dokter.export');
        Route::resource('dokter', AdminDokterCtrl::class);
        
        Route::get('/pasien/export', [AdminPasienCtrl::class, 'export'])->name('pasien.export');
        Route::resource('pasien', AdminPasienCtrl::class);
        
        Route::get('/obat/export', [ObatController::class, 'export'])->name('obat.export');
        Route::resource('obat', ObatController::class);
        
        Route::resource('polis', PoliController::class);
        
        Route::get('/verifikasi_pembayaran', [VerifikasiPembayaranController::class, 'index'])->name('verifikasi_pembayaran.index');
        Route::post('/verifikasi_pembayaran/{id}', [VerifikasiPembayaranController::class, 'verifikasi'])->name('verifikasi_pembayaran.verifikasi');
    });

/*
|--------------------------------------------------------------------------
| DOKTER ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter') 
    ->name('dokter.')   
    ->group(function () {
        Route::get('/dashboard', [DokterDashboard::class, 'index'])->name('dashboard');
        
        Route::get('/jadwal_periksa/export', [JadwalPeriksaController::class, 'export'])->name('jadwal_periksa.export');
        Route::resource('jadwal_periksa', JadwalPeriksaController::class);
        
        Route::resource('periksa_pasien', PeriksaPasienController::class);
        
        Route::get('/riwayat_pasien/export', [RiwayatPasienController::class, 'export'])->name('riwayat_pasien.export');
        Route::get('riwayat_pasien/create/{id}', [RiwayatPasienController::class, 'create'])->name('riwayat_pasien.create_with_id');
        Route::resource('riwayat_pasien', RiwayatPasienController::class)->except(['create']);
    });

/*
|--------------------------------------------------------------------------
| PASIEN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pasien'])
    ->prefix('pasien')
    ->name('pasien.')
    ->group(function () {
        Route::get('/dashboard', [PasienDashboard::class, 'index'])->name('dashboard');
        Route::get('/daftar_poli', [DaftarPoliController::class, 'index'])->name('daftar_poli.index');
        Route::post('/daftar_poli', [DaftarPoliController::class, 'store'])->name('daftar_poli.store');
        Route::get('/get-jadwal/{id_poli}', [DaftarPoliController::class, 'getJadwalByPoli']);
        
        Route::get('/riwayat_pendaftaran', [RiwayatPendaftaranController::class, 'index'])->name('riwayat_pendaftaran.index');
        Route::get('/riwayat_pendaftaran/{id}', [RiwayatPendaftaranController::class, 'show'])->name('riwayat_pendaftaran.show');
        
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
        Route::post('/pembayaran/{id}', [PembayaranController::class, 'upload'])->name('pembayaran.upload');
    });