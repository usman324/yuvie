<?php

use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\NotificationController;
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
});
