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

<<<<<<< HEAD
use App\Http\Controllers\AdminController;

Route::get('/admin', [AdminController::class, 'index']);
Route::get('/admin/detail/{id}', [AdminController::class, 'detail'])->middleware('admin');
Route::post('/admin/detail/{id}', [AdminController::class, 'updateStatus'])->middleware('admin');

use App\Http\Controllers\AuthController;

// login
Route::get('/admin/login', [AuthController::class, 'showLogin']);
Route::post('/admin/login', [AuthController::class, 'login']);

// logout
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/cek-status', function () {
    return view('cek-status');
});

Route::get('/admin/download/{file}', [AdminController::class, 'download'])
    ->middleware('admin');
=======
    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::patch('/pengajuan/{pengajuan}/status', [AdminController::class, 'updateStatus'])->name('admin.update-status');
    });
});
>>>>>>> af9bbc9e36b2eae0fc97d1836c4959577fd3144b
