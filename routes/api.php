<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\TestController;
use App\Http\Middleware\CheckRole;
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
    Route::apiResource('/products', ProductController::class)->except('/index', '/show')
        ->middleware(CheckRole::class.':admin');   // All routes in /products
//    Route::post('/products', [ProductController::class, 'store']);
//    Route::get('/products/{product}', [ProductController::class, 'show']);
//    Route::put('/products/{product}', [ProductController::class, 'update']);
//    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::middleware(CheckRole::class.':user')->group(function() {
       Route::get('/cart/{cart}', [CartController::class, 'show']);
       Route::post('/cart', [CartController::class, 'add']);
       Route::put('/cart/{cart}', [CartController::class, 'update']);
       Route::patch('/cart/{cart}', [CartController::class, 'remove']);
       Route::delete('/cart/{cart}', [CartController::class, 'clear']);
    });

});

Route::get('/products', [ProductController::class, 'index']);   // Route goes after apiResource because of errors
Route::get('/products/{product}', [ProductController::class, 'show']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
