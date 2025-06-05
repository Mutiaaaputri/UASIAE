<?php

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */
// use App\Http\Controllers\UserServiceController;

// Route::apiResource('/user-services', UserServiceController::class);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserServiceController;

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [UserServiceController::class, 'index']);  // Hanya admin yang bisa mengakses route ini
    // Route lainnya untuk admin
});

// routes/api.php (User Service)

Route::middleware('verify.service.token')->get('/users/{id}', [UserServiceController::class, 'show']);

Route::get('/users', [UserServiceController::class, 'index']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/users', [UserServiceController::class, 'index']);
    Route::post('/users', [UserServiceController::class, 'store']);
    Route::get('/users/{id}', [UserServiceController::class, 'show']);
    Route::put('/users/{id}', [UserServiceController::class, 'update']); // ✅ UPDATE USER
    Route::delete('/users/{id}', [UserServiceController::class, 'destroy']);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);

    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return response()->json(['message' => 'Welcome Admin!']);
        });
    });
});
