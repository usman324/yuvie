<?php

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

Route::namespace('Api')->middleware('user')->group(function(){

    // videos controller api's
    Route::post('get_videos', [VideoController::class, 'getVideos']);
    Route::post('upload_video', [VideoController::class, 'uploadVideo']);
    Route::post('get_company_videos', [VideoController::class, 'getCompanyVideos']);
    Route::post('change_status_video', [VideoController::class, 'changeStatusVideo']);
    Route::post('update_video', [VideoController::class, 'updateVideo']);
});

