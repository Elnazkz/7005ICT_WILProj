<?php

use App\Http\Controllers\InpDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
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

Route::get('/change-profile', [WilAuthController::class, 'changeProfile']);
Route::post('/profile-changing', [WilAuthController::class, 'profileChanging']);

Route::get('/dispatch', [WilAuthController::class, 'dispatch']);
Route::get('/signout', [WilAuthController::class, 'signOut'])->name('signout');

Route::post('/approve-inp', [WilAuthController::class, 'approveInp']);
Route::get('/approve-inps', [WilAuthController::class, 'approveInps']);

Route::get('/profiles', [ProfileController::class, 'index']);

Route::get('/inp-details/{id}', [InpDetailController::class, 'show']);

Route::get('/proj-details/{project_id}', [ProjectController::class, 'index']);
Route::get('/create-project', [ProjectController::class, 'create']);
Route::post('/project_creation', [ProjectController::class, 'store']);
Route::get('/project_show/{project}', [ProjectController::class, 'show']);
Route::post('/project_update/{project}', [ProjectController::class, 'update']);
Route::get('/project_del/{project}', [ProjectController::class, 'destroy']);
Route::post('/project_image', [ProjectController::class, 'store_image']);
Route::post('/project_file', [ProjectController::class, 'store_file']);

// Default home route
Route::get('/', [WilAuthController::class, 'dispatch'])->name('home');
