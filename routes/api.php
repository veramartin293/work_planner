<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UniformController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Protected routes by authorization and role 
Route::group(['middleware' => ['auth:sanctum', 'checkUserRole']], function () {
    // Order routes
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
    Route::post('/orders', [OrderController::class, 'store']);

    // Uniform routes
    Route::post('/uniforms', [UniformController::class, 'store']);
});

// Protected routes just by authorization
Route::group(['middleware' => ['auth:sanctum']], function () {
    // Auth routes
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/authenticated', [AuthController::class, 'getAuthenticated']);
});

// Public routes

// Order routes
Route::get('/orders', [OrderController::class, 'index']);
Route::get('/orders/{id}', [OrderController::class, 'show']);

// Uniform routes
Route::get('/uniforms/{orderId}', [UniformController::class, 'index']);

// Authentication routes
Route::post('/registration', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
