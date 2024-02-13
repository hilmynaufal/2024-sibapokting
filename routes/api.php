<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RefController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\DisposisiCreateController;
use App\Http\Controllers\DisposisiListController;
use App\Http\Controllers\LampiranController;
use App\Models\DisposisiLaporan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth
// Route::post('auth/login-sso', [AuthController::class,'auth']);
Route::post('auth/callback', [AuthController::class,'auth']);

Route::post('Login', [UserController::class,'login']);
Route::get('TestApi', [RefController::class,'Test']);

// Master
Route::get('GetJenisDisposisi', [RefController::class,'getJenisDisposisi']);
Route::get('GetJenisSurat', [RefController::class,'getJenisSurat']);
Route::get('GetSifatSurat', [RefController::class,'getSifatSurat']);
Route::get('GetPegawai', [RefController::class,'getPegawai']);
Route::get('GetUnitKerja', [RefController::class,'getUnitKerja']);

// Surat Masuk
Route::post('InsertSuratMasuk', [SuratMasukController::class,'create']);
Route::post('ListSuratMasuk', [SuratMasukController::class,'index']);
Route::post('TrackingVerifikasi', [SuratMasukController::class,'tracking']);

// Disposisi Masuk
Route::post('InsertDisposisi', [DisposisiCreateController::class,'create']);
Route::post('TrackingDisposisi', [DisposisiListController::class,'tracking']);
Route::post('ListDisposisi', [DisposisiListController::class,'index']);
Route::post('LaporanDisposisi', [DisposisiLaporan::class,'create']);

// lampiran
Route::post('UploadLampiran', [LampiranController::class,'uploadLampiran']);

// Dashboard
Route::post('Dashboard', [DashboardController::class,'index']);