<?php

use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

<<<<<<< HEAD
// =======================
// ROUTE PUBLIK
// =======================
Route::get('/', [PengajuanController::class, 'create'])->name('pengajuan.form');
=======
// Route publik
// Route::get('/, [PengajuanController::class, 'create'])->name('pengajuan.landing');
Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('pengajuan.form');
>>>>>>> 2b1d437735edf109d94ea976914d3cbfcbbe91d3
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');

Route::get('/cek-status', [PengajuanController::class, 'cekStatusForm'])->name('pengajuan.cek-status');
Route::post('/cek-status', [PengajuanController::class, 'cekStatus'])->name('pengajuan.cek-status.proses');


// =======================
// ROUTE ADMIN
// =======================
Route::prefix('admin')->group(function () {

    // login logout
    Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

<<<<<<< HEAD
    // area admin (protected)
=======
>>>>>>> 2b1d437735edf109d94ea976914d3cbfcbbe91d3
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/detail/{id}', [AdminController::class, 'detail']);
        Route::post('/detail/{id}', [AdminController::class, 'updateStatus']);
        Route::get('/download/{file}', [AdminController::class, 'download']);
    });
<<<<<<< HEAD
});
=======
});
>>>>>>> 2b1d437735edf109d94ea976914d3cbfcbbe91d3
