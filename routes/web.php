<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pengajuan');
});

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
