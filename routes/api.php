<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Settings\RolesComtroller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/roles', [RolesComtroller::class, 'index']);
    Route::delete('/roles/{id}', [RolesComtroller::class, 'delete']);
    Route::get('/get_roles/{id}', [RolesComtroller::class, 'show']);
    Route::get('/function_models', [RolesComtroller::class, 'get_function_models']);
    Route::post('/create_roles', [RolesComtroller::class, 'store']);
    Route::post('/update_roles/{id}', [RolesComtroller::class, 'update']);
});
