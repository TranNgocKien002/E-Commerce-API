<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::apiResource('products', ProductController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart/add',        [CartController::class, 'addToCart']);
    Route::get('/cart',             [CartController::class, 'viewCart']);
    Route::put('/cart/{id}',        [CartController::class, 'updateCart']);
    Route::delete('/cart/{id}',     [CartController::class, 'removeItem']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/orders', [OrderController::class, 'placeOrder']);
    Route::get('/orders',  [OrderController::class, 'myOrders']);
});
Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
