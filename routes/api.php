<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Settings\AddressController;
use App\Http\Controllers\Settings\BranchController;
use App\Http\Controllers\Settings\RolesComtroller;
use App\Http\Controllers\Settings\UserController;
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
    Route::get('/get_function_available_by_role', [RolesComtroller::class, 'get_function_available_by_role']);
    //branches
    Route::get('/branches', [BranchController::class, 'index']);
    Route::post('/update_branches/{id}', [BranchController::class, 'update']);
    //users
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/create_users', [UserController::class, 'store']);
    Route::post('/update_users/{id}', [UserController::class, 'update']);
    //address
    Route::get('/villages', [AddressController::class, 'village']);
    Route::get('/districts', [AddressController::class, 'district']);
    Route::get('/provinces', [AddressController::class, 'province']);
});
