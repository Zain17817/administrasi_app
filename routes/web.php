<?php

use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// =======================
// ROUTE PUBLIK
// =======================
Route::get('/', [PengajuanController::class, 'create'])->name('pengajuan.form');
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

    // area admin (protected)
    Route::middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/detail/{id}', [AdminController::class, 'detail']);
        Route::post('/detail/{id}', [AdminController::class, 'updateStatus']);
        Route::get('/download/{file}', [AdminController::class, 'download']);
    });
});