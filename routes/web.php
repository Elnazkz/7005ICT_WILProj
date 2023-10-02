<?php

use App\Http\Controllers\InpDetailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectUserController;
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
Route::post('/custom-login', [WilAuthController::class, 'custom_login'])->name('login.custom');
Route::get('/registration', [WilAuthController::class, 'registration'])->name('register-user');
Route::post('/custom-registration', [WilAuthController::class, 'custom_registration'])->name('register.custom');

Route::get('/change-profile', [WilAuthController::class, 'change_profile']);
Route::post('/profile-changing', [WilAuthController::class, 'profile_changing']);
Route::post('/user_profile_changing', [WilAuthController::class, 'user_profile_changing']);

Route::get('/dispatch', [WilAuthController::class, 'dispatch']);
Route::get('/signout', [WilAuthController::class, 'signout'])->name('signout');

Route::post('/approve-inp', [WilAuthController::class, 'approve_inp']);
Route::get('/approve-inps', [WilAuthController::class, 'approve_inps']);

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
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/apply_to_project/{project}', [ProjectController::class, 'apply_to_project']);
Route::post('/project_user_update', [ProjectUserController::class, 'apply']);

// Default home route
Route::get('/', [WilAuthController::class, 'dispatch'])->name('home');
