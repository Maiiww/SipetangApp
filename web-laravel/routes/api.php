<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TangkapanController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CuacaController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/tangkapan/riwayat', [TangkapanController::class, 'riwayat']);
Route::get('/tangkapan', [TangkapanController::class, 'index']);
Route::post('/tangkapan', [TangkapanController::class, 'store']);

Route::get('/total-produksi', [TangkapanController::class, 'totalProduksi']);

Route::post('/tangkapan/kirim', [TangkapanController::class, 'sendToStaff']);
Route::get('/tangkapan/count-revisi', [TangkapanController::class, 'countRevisi']);

Route::get('/cuaca', [CuacaController::class, 'getCuaca']);

//Foto Profile
Route::get('/profile/{id}', [ProfileController::class, 'show']);
Route::post('/profile/{id}/update-foto', [ProfileController::class, 'updateFoto']);



