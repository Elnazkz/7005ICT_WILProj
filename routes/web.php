<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\WilAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth routes
Route::get('/login', [WilAuthController::class, 'index'])->name('login');
Route::post('/custom-login', [WilAuthController::class, 'customLogin'])->name('login.custom');
Route::get('/registration', [WilAuthController::class, 'registration'])->name('register-user');
Route::post('/custom-registration', [WilAuthController::class, 'customRegistration'])->name('register.custom');

Route::get('dashboard', [WilAuthController::class, 'dashboard']);
Route::get('signout', [WilAuthController::class, 'signOut'])->name('signout');

// Default home route
Route::get('/', [WilAuthController::class, 'dashboard'])->name('home');
