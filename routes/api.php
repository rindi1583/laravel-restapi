<?php

use App\Http\Controllers\API\FakultasController;
use App\Http\Controllers\API\MahasiswaController;
use App\Http\Controllers\API\ProdiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('fakultas', [FakultasController::class,'index']);

Route::get('prodi', [ProdiController::class,'index']);

Route::get('mahasiswa', [MahasiswaController::class,'index']);

Route::post('fakultas/store', [FakultasController::class, 'store']);

Route::post('prodi/store', [ProdiController::class, 'store']);

Route::post('mahasiswa/store', [MahasiswaController::class, 'store']);

Route::delete('fakultas/delete{id}', [FakultasController::class, 'destroy']);
