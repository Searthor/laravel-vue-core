<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/products',[ProductController::class , 'store']);
Route::post('/products/{id}',[ProductController::class , 'update']);
Route::get('/products',[ProductController::class , 'index']);
Route::post('/recommend', [ProductController::class, 'queryWitAi']);