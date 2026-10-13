<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// register : fungsinya buat akunn baru 
// login : belum punya token makannya harus login dulu biar dapet token
// logout : berarti user udah punya token hasil di dapat dari login,
// jadi intinya kita bakal dapet token baru karna token bisa. expired
Route::post('/register', [AuthController::class,'register']);
Route::post('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('/login', [AuthController::class,'login']);

Route::post('/categories', [CategoryController::class,'createCategory'])->middleware('auth:sanctum');
Route::get('/categories', [CategoryController::class,'index'])->middleware('auth:sanctum');
Route::put('/categories/{id}', [CategoryController::class,'updateCategory'])->middleware('auth:sanctum');
Route::delete('/categories/{id}', [CategoryController::class,'deleteCategory'])->middleware('auth:sanctum');

Route::apiResource('/product',ProductController::class)->middleware('auth:sanctum');

Route::post('/orders', [OrderController::class,'createOrder'])->middleware('auth:sanctum');