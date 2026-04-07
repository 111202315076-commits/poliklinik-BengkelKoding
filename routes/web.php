<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'));

Route::get('/login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);

Route::get('/register', [AuthController::class,'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class,'register'])->name('register.post');

Route::post('/logout', [AuthController::class,'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    if (Auth::user()->role == 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (Auth::user()->role == 'dokter') {
        return redirect()->route('dokter.dashboard');
    }

    if (Auth::user()->role == 'pasien') {
        return redirect()->route('pasien.dashboard');
    }

    abort(403);

})->middleware('auth');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/dashboard', fn () => view('admin.dashboard'))
            ->name('admin.dashboard');

        Route::resource('polis', App\Http\Controllers\Admin\PoliController::class);
});


/*
|--------------------------------------------------------------------------
| DOKTER
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:dokter'])
    ->prefix('dokter')
    ->group(function () {

        Route::get('/dashboard', fn () => view('dokter.dashboard'))
            ->name('dokter.dashboard');
});


/*
|--------------------------------------------------------------------------
| PASIEN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','role:pasien'])
    ->prefix('pasien')
    ->group(function () {

        Route::get('/dashboard', fn () => view('pasien.dashboard'))
            ->name('pasien.dashboard');
});