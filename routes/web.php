<?php

use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Route publik
// Route::get('/, [PengajuanController::class, 'create'])->name('pengajuan.landing');
Route::get('/pengajuan', [PengajuanController::class, 'create'])->name('pengajuan.form');
Route::post('/pengajuan', [PengajuanController::class, 'store'])->name('pengajuan.store');
Route::get('/cek-status', [PengajuanController::class, 'cekStatusForm'])->name('pengajuan.cek-status');
Route::post('/cek-status', [PengajuanController::class, 'cekStatus'])->name('pengajuan.cek-status.proses');

// Route admin (dilindungi middleware 'admin')
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/pengajuan/{pengajuan}/status', [AdminController::class, 'updateStatus'])->name('admin.update-status');
    });
});
