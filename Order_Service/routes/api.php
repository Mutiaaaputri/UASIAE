<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;



Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('{id}', [OrderController::class, 'show']);
    Route::put('{id}', [OrderController::class, 'update']);
    Route::delete('{id}', [OrderController::class, 'destroy']);
});

Route::get('/order-details', [OrderController::class, 'getOrderWithUserAndProduct']);
Route::get('/order-details/{id}', [OrderController::class, 'getOrderDetail']);

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

Route::get('/orders/{orderId}/user', [OrderController::class, 'getUser']);
Route::get('/orders/{orderId}/product', [OrderController::class, 'getProduct']);
Route::get('/users', [OrderController::class, 'getAllUsers']);   // Get all users
Route::get('/products', [OrderController::class, 'getAllProducts']); // Get all products
