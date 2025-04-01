<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/test', [TestController::class, 'store']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/products', ProductController::class)->except('/index');   // All routes in /products
//    Route::post('/products', [ProductController::class, 'store']);
//    Route::get('/products/{product}', [ProductController::class, 'show']);
//    Route::put('/products/{product}', [ProductController::class, 'update']);
//    Route::delete('/products/{product}', [ProductController::class, 'destroy']);


});

Route::get('/products', [ProductController::class, 'index']);   // Route goes after apiResource because of errors



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
