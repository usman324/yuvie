<?php

use App\Http\Controllers\Admin\WaterMarkController;
use App\Http\Controllers\Api\BackgroundMusicController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\FontController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\StickerController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::routes();

Route::post('login_by_device_id', [DeviceController::class, 'loginByDeviceId']);
Route::namespace('Api')->middleware('user')->group(function () {
  Route::post('delete_picture', [UserController::class, 'deletePicture']);

  Route::post('get_video_by_device_id', [DeviceController::class, 'getVideoByDeviceId']);
  Route::post('upload_video_by_device_id', [DeviceController::class, 'uploadVideoDeviceId']);
  // videos controller api's
  Route::post('get_videos', [VideoController::class, 'getVideos']);
  Route::post('get_counts', [VideoController::class, 'getCounts']);
  Route::post('upload_video', [VideoController::class, 'uploadVideo']);
  Route::post('get_video_by_id', [VideoController::class, 'getVideoById']);
  Route::post('get_company_videos', [VideoController::class, 'getCompanyVideos']);
  Route::post('change_status_video', [VideoController::class, 'changeStatusVideo']);
  Route::post('update_video', [VideoController::class, 'updateVideo']);
  Route::post('video_share', [VideoController::class, 'videoShare']);
  Route::post('profile_update', [UserController::class, 'profileUpdate']);
  Route::post('profile_update_by_device_id', [UserController::class, 'profileUpdateByDeviceId']);
  Route::post('update_device_token', [UserController::class, 'updateDeviceToken']);
  Route::post('get_user_notification', [NotificationController::class, 'getUserNotification']);
  Route::post('delete_notification', [NotificationController::class, 'deleteNotification']);
  Route::post('password_update', [UserController::class, 'passwordUpdate']);

  // Route::post('get_background_music', [BackgroundMusicController::class, 'getCompanyBackgroundMusic']);
  Route::post('get_background_music', [BackgroundMusicController::class, 'getBackgroundMusic']);
  Route::post('get_company_background_music', [BackgroundMusicController::class, 'getCompanyBackgroundMusic']);

  Route::post('get_stickers', [StickerController::class, 'getSticker']);
  Route::post('get_company_stickers', [StickerController::class, 'getCompanySticker']);

  Route::post('get_fonts', [FontController::class, 'getFont']);
  Route::post('get_company_fonts', [FontController::class, 'getCompanyFont']);

  Route::post('get_watermarks', [WaterMarkController::class, 'getWatermark']);
});
