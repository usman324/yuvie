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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
