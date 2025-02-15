<?php

use App\Http\Controllers\Auth\AuthController;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

// Route for login page
Route::get('/login', function () {
    return view('welcome');
})->name('login');

// Grouped routes that require authentication
Route::get('/', function () {
    return view('welcome');
});

// Catch-all route for single-page applications (SPA)
Route::get('/{pathMatch}', function () {
    return view('welcome');
})->where('pathMatch', '.*');

