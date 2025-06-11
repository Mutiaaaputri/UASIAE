<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Di sini kamu bisa mendaftarkan semua route API untuk aplikasimu.
| Route berikut ini akan diakses tanpa perlu autentikasi.
|
*/

// Route yang hanya digunakan jika kamu menggunakan Sanctum (opsional)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route API untuk Payment tanpa autentikasip
Route::apiResource('/payments', PaymentController::class);

Route::put('/users/{id}', [PaymentController::class, 'update']);
Route::post('/payments', [PaymentController::class, 'store']);
