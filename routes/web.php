<?php

use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlokController;
use App\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoutingController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\WargaController;
use App\Http\Middleware\CheckRole;
use App\Http\Controllers\kegiatan\KegiatanController;

require __DIR__ . '/auth.php';



Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware([CheckRole::class . ':superadmin'])->group(function () {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/superadmin/dashboard/warga', [WargaController::class, 'DataWarga'])->name('superadmin.DataWarga');
    Route::get('/superadmin/dashboard/blok', [BlokController::class, 'index'])->name('superadmin.blok');
    Route::get('/superadmin/dashboard/formwarga', [WargaController::class, 'FormWarga'])->name('superadmin.FormWarga');
    Route::get('/superadmin/dashboard/addwarga', [WargaController::class, 'AddDataWarga'])->name('superadmin.AddDataWarga');
    Route::get('/blok/{block}', [BlokController::class, 'show'])->name('blok.show');
});

Route::middleware([CheckRole::class . ':administrator'])->group(function () {
    Route::get('/administrator/dashboard', [AdministratorController::class, 'index'])->name('administrator.dashboard');
});

Route::middleware([CheckRole::class . ':warga'])->group(function () {
    Route::get('/warga/dashboard', [WargaController::class, 'index'])->name('warga.dashboard');
});

Route::get('/kegiatan/List-Kegiatan', [KegiatanController::class, 'ListKegiatan']);

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    // Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('/keuangan', [FinanceController::class, 'index'])->name('keuangan');
    Route::get('/home', fn() => view('index'))->name('home');
    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])->name('any');
});


// routes/web.php


