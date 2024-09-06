<?php

use App\Http\Controllers\Admin\BackgroundMusicController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\FontController;
use App\Http\Controllers\Admin\NotificationControler;
use App\Http\Controllers\Admin\StickerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Admin\WaterMarkController;
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
Route::get('images/{dir}/{filename}', [DashboardController::class, 'getImage']);
Route::get('/', [DashboardController::class, 'login']);
Route::get('video/share/{id}', [DashboardController::class, 'showVideo']);
Route::get('show-video-notify/{id}', [DashboardController::class, 'showVideoNotify']);
Route::view('/detail', 'detail');
Route::get('admin/login', [DashboardController::class, 'login']);
Route::post('admin/login', [LoginController::class, 'adminlogin']);
Route::post('music-reorder', [DashboardController::class, 'musicReorder']);

Route::middleware('prevent-back-history', 'super_admin')->prefix('admin')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index']);
    // users
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/create', [UserController::class, 'create']);
    Route::post('users', [UserController::class, 'store']);
    Route::get('users/{id}/edit', [UserController::class, 'edit']);
    Route::post('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    // end users
    // companies
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('companies/create', [CompanyController::class, 'create']);
    Route::post('companies', [CompanyController::class, 'store']);
    Route::get('companies/{id}/edit', [CompanyController::class, 'edit']);
    Route::post('companies/{id}', [CompanyController::class, 'update']);
    Route::delete('companies/{id}', [CompanyController::class, 'destroy']);
    Route::post('get-cities', [CompanyController::class, 'getCities']);
    // end companies 
    // videos
    Route::get('videos', [VideoController::class, 'index']);
    Route::get('videos/create', [VideoController::class, 'create']);
    Route::post('videos', [VideoController::class, 'store']);
    Route::get('add_company_video/{id}', [VideoController::class, 'addCompanyVideo']);
    Route::get('videos/{id}/edit', [VideoController::class, 'edit']);
    Route::get('videos/{id}', [VideoController::class, 'show']);
    Route::post('videos/{id}', [VideoController::class, 'update']);
    Route::delete('videos/{id}', [VideoController::class, 'destroy']);
    Route::post('get-company-user', [VideoController::class, 'getCompanyUser']);
    Route::post('video_approved/{id}', [VideoController::class, 'videoApproved']);
    // file-managers
    Route::get('file-managers', [FileManagerController::class, 'index']);
    Route::get('file-managers/create', [FileManagerController::class, 'create']);
    Route::post('file-managers', [FileManagerController::class, 'store']);
    Route::get('file-managers/{id}/edit', [FileManagerController::class, 'edit']);
    Route::post('file-managers/{id}', [FileManagerController::class, 'update']);
    Route::delete('file-managers/{id}', [FileManagerController::class, 'destroy']);
    // background-musics
    Route::get('background-musics', [BackgroundMusicController::class, 'index']);
    Route::get('background-musics/create', [BackgroundMusicController::class, 'create']);
    Route::post('background-musics', [BackgroundMusicController::class, 'store']);
    Route::get('background-musics/{id}/edit', [BackgroundMusicController::class, 'edit']);
    Route::get('background-musics/{id}', [BackgroundMusicController::class, 'show']);
    Route::post('background-musics/{id}', [BackgroundMusicController::class, 'update']);
    Route::delete('background-musics/{id}', [BackgroundMusicController::class, 'destroy']);
    Route::post('background-multiple', [BackgroundMusicController::class, 'backgroundMusic']); 
    // stickers
    Route::get('stickers', [StickerController::class, 'index']);
    Route::get('stickers/create', [StickerController::class, 'create']);
    Route::post('stickers', [StickerController::class, 'store']);
    Route::get('stickers/{id}/edit', [StickerController::class, 'edit']);
    Route::get('stickers/{id}', [StickerController::class, 'show']);
    Route::post('stickers/{id}', [StickerController::class, 'update']);
    Route::delete('stickers/{id}', [StickerController::class, 'destroy']);

     // fonts
     Route::get('fonts', [FontController::class, 'index']);
     Route::get('fonts/create', [FontController::class, 'create']);
     Route::post('fonts', [FontController::class, 'store']);
     Route::get('fonts/{id}/edit', [FontController::class, 'edit']);
     Route::get('fonts/{id}', [FontController::class, 'show']);
     Route::post('fonts/{id}', [FontController::class, 'update']);
     Route::delete('fonts/{id}', [FontController::class, 'destroy']);
    // Route::post('background-multiple', [BackgroundMusicController::class, 'backgroundMusic']);
    // watermarks
    Route::get('watermarks', [WaterMarkController::class, 'index']);
    Route::get('watermarks/create', [WaterMarkController::class, 'create']);
    Route::post('watermarks', [WaterMarkController::class, 'store']);
    Route::get('watermarks/{id}/edit', [WaterMarkController::class, 'edit']);
    Route::post('watermarks/{id}', [WaterMarkController::class, 'update']);
    Route::delete('watermarks/{id}', [WaterMarkController::class, 'destroy']);
    // notification
    Route::get('notifications', [NotificationControler::class, 'index']);
    Route::post('notifications', [NotificationControler::class, 'store']);

    // end videos
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
