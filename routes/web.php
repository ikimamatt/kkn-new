<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\Superadmin\FinanceController as SuperadminFinanceController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\WargaController;
use App\Http\Middleware\CheckRole;

// Route untuk halaman login
Route::get('/', function () {
    // Jika pengguna belum login, mereka akan diarahkan ke halaman login
    return redirect()->route('login');
});

// Route untuk halaman login (hanya bisa diakses oleh pengguna yang belum login)
Route::middleware('guest')->get('/login', function () {
    return view('auth.login');
})->name('login');

// Post route untuk login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Routes yang sudah login, terproteksi dengan middleware auth
Route::middleware('auth')->group(function () {

    // Routes untuk Superadmin
    Route::middleware([CheckRole::class . ':superadmin'])->group(function () {

        Route::resource('/superadmin/keuangan', SuperadminFinanceController::class)
            ->except(['create', 'edit', 'show'])
            ->names([
                'index' => 'superadmin.finance.index',
                'store' => 'superadmin.finance.store',
                'update' => 'superadmin.finance.update',
                'destroy' => 'superadmin.finance.destroy',
            ]);

        Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
        // Route::get('/superadmin/dashboard/blok', [BlokController::class, 'index'])->name('superadmin.blok');
        // Route resource untuk Block
        Route::resource('superadmin/dashboard/block', BlockController::class);
        Route::resource('superadmin/dashboard/house', HouseController::class)->except(['show']);

    });

    // Routes untuk Administrator
    Route::middleware([CheckRole::class . ':administrator'])->group(function () {
        Route::get('/administrator/dashboard', [AdministratorController::class, 'index'])->name('administrator.dashboard');
    });

    // Routes untuk Warga
    Route::middleware([CheckRole::class . ':warga'])->group(function () {
        Route::get('/warga/dashboard', [WargaController::class, 'index'])->name('warga.dashboard');
    });

});

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    // Route::get('', [RoutingController::class, 'index'])->name('root');

    Route::get('/keuangan', [FinanceController::class, 'index'])->name('keuangan');

    Route::get('/keuangan', function () {
    })->middleware(['auth', 'redirect.by.role'])->name('keuangan');

    Route::get('/home', fn() => view('index'))->name('home');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});
