<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\FamilyCardController;
use App\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\Superadmin\FinanceController as SuperadminFinanceController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\UserController;
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

        // Route resource untuk Block
        Route::resource('superadmin/dashboard/block', BlockController::class);

        // Route  untuk House
        Route::get('superadmin/dashboard/house/{block}', [HouseController::class, 'index'])->name('house.index');  // Menampilkan rumah berdasarkan blok
        Route::get('superadmin/dashboard/house/{block}/create', [HouseController::class, 'create'])->name('house.create');  // Menampilkan form tambah rumah
        Route::post('superadmin/dashboard/house/{block}', [HouseController::class, 'store'])->name('house.store');  // Menyimpan rumah baru
        Route::get('superadmin/dashboard/house/{house}/edit', [HouseController::class, 'edit'])->name('house.edit');  // Menampilkan form edit rumah
        Route::put('superadmin/dashboard/house/{house}', [HouseController::class, 'update'])->name('house.update');  // Memperbarui rumah
        Route::delete('superadmin/dashboard/house/{house}', [HouseController::class, 'destroy'])->name('house.destroy');  // Menghapus rumah

        // Route familycard
        Route::get('superadmin/dashboard/family-card/{house}', [FamilyCardController::class, 'index'])->name('familyCard.index');  // Menampilkan Kartu Keluarga
        Route::get('superadmin/dashboard/family-card/{house}/create', [FamilyCardController::class, 'create'])->name('familyCard.create');  // Form untuk membuat Kartu Keluarga
        Route::post('superadmin/dashboard/family-card/{house}', [FamilyCardController::class, 'store'])->name('familyCard.store');  // Menyimpan Kartu Keluarga
        Route::get('superadmin/dashboard/family-card/{familyCard}/edit', [FamilyCardController::class, 'edit'])->name('familyCard.edit');  // Form untuk edit Kartu Keluarga
        Route::put('superadmin/dashboard/family-card/{familyCard}', [FamilyCardController::class, 'update'])->name('familyCard.update');  // Memperbarui Kartu Keluarga
        Route::delete('superadmin/dashboard/family-card/{familyCard}', [FamilyCardController::class, 'destroy'])->name('familyCard.destroy');  // Menghapus Kartu Keluarga

        // route untuk user
        Route::get('superadmin/dashboard/family-card/{familyCard}/user', [UserController::class, 'index'])->name('user.index');  // Menampilkan anggota keluarga
        Route::get('superadmin/dashboard/family-card/{familyCard}/user/create', [UserController::class, 'create'])->name('user.create');  // Menampilkan form modal create anggota keluarga
        Route::post('superadmin/dashboard/family-card/{familyCard}/user', [UserController::class, 'store'])->name('user.store');  // Menyimpan anggota keluarga
        Route::get('superadmin/dashboard/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');  // Menampilkan form modal edit anggota keluarga
        Route::put('superadmin/dashboard/user/{user}', [UserController::class, 'update'])->name('user.update');  // Memperbarui anggota keluarga
        Route::delete('superadmin/dashboard/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');  // Menghapus anggota keluarga



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
