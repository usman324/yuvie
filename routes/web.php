<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [DashboardController::class, 'login']);
// Route::get('admin/login', [DashboardController::class, 'login']);
Route::post('admin/login', [LoginController::class, 'adminlogin']);
Route::middleware('super_admin')->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    // users
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/create', [UserController::class, 'create']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}/edit', [UserController::class, 'edit']);
    Route::post('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});
Route::get('clear-cache', function () {
    \Artisan::call('optimize:clear');
    return back();
});

Route::get('migrate-fresh', function () {
    \Artisan::call('migrate:fresh');
    dd("Migration Freshed");
});
Route::get('migrate', function () {
    \Artisan::call('migrate');
    dd("Migration Completed");
});

Route::get('seed', function () {
    \Artisan::call('db:seed');
    dd("Seeding Completed");
});

Route::get('storage-link', function () {
    \Artisan::call('storage:link');
    dd("links Completed");
});
Route::get('passport-install', function () {
    \Artisan::call('passport-install');
    dd("links Completed");
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
