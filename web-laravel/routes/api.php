<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TangkapanController;
use App\Http\Controllers\Api\ProfileController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/tangkapan', [TangkapanController::class, 'index']);
Route::post('/tangkapan', [TangkapanController::class, 'store']);

//Foto Profile
Route::get('/profile/{id}', [ProfileController::class, 'show']);
Route::post('/profile/{id}/update-foto', [ProfileController::class, 'updateFoto']);

Route::post('/tangkapan/kirim', [TangkapanController::class, 'sendToStaff']);


