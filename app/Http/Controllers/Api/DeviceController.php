<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoShare;
use App\Models\VideoView;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class DeviceController extends Controller
{
    public  function loginByDeviceId(Request $request)
    {
        $user = User::where('device_id', $request->device_id)->first();
        $companies = Company::with('companyDetail', 'companyBranding')->get();
        if ($user) {
            auth()->login($user);
            $token = auth()->user()->createToken('Personal Access Token')->accessToken;
            $record = [
                "id" => $user->id,
                "device_id" => $user->device_id ? $user->device_id : '',
                "company_id" => $user->company_id ? $user->company_id : '',
                "first_name" => $user->first_name ? $user->first_name : '',
                "last_name" => $user->last_name ? $user->last_name : '',
                "email" => $user->email ? $user->email : '',
                "image" => $user->image ? env('APP_IMAGE_URL') . 'user/' . $user->image : asset('theme/img/avatar.png'),
                "device_token" => $user->device_token ? $user->device_token : '',
                "email_verified_at" => $user->email_verified_at ? $user->email_verified_at : '',
                "is_admin" => $user->is_admin ? $user->is_admin : '',
                "created_at" => $user->created_at ? $user->created_at : '',
                "updated_at" => $user->updated_at ? $user->updated_at : '',
                "user_type" => $user?->getRoleNames()->first(),
                'token' => $token,
                'companies' => $companies,
            ];
            return response()->json(['status' => true, 'message' => 'Login Successfully', 'data' => $record], 200);
        } else {
            $user = User::create([
                'device_id' => $request->device_id,
            ]);
            $user->assignRole(6);
            auth()->login($user);
            $token = auth()->user()->createToken('Personal Access Token')->accessToken;
            $record = [
                "id" => $user->id,
                "device_id" => $user->device_id ? $user->device_id : '',
                "company_id" => '',
                "first_name" => '',
                "last_name" => '',
                "email" => '',
                "image" => $user->image ? env('APP_IMAGE_URL') . 'user/' . $user->image : asset('theme/img/avatar.png'),
                "device_token" => '',
                "email_verified_at" => '',
                "is_admin" => '',
                "created_at" => '',
                "updated_at" => '',
                "user_type" => '',
                "user_type" => $user?->getRoleNames()->first(),
                'token' => $token,
                'companies' => $companies,
            ];
        }
        return response()->json(['status' => true, 'message' => 'Login Successfully', 'data' => $record], 200);
    }
    public function getVideoByDeviceId(Request $request)
    {
        $user = User::where('device_id', $request->device_id)->first();
        if ($request->company_filter == 'shared') {
            $video_shares = VideoShare::all();
            $videos = Video::whereIn('id', $video_shares->pluck('video_id'))->where('company_id', $user?->company_id)
                ->where('user_id', '!=', $user->id)->where('status', 'approve')->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->company_filter == 'view') {
            $video_view = VideoView::all();
            $videos = Video::whereIn('id', $video_view->pluck('video_id'))->where('company_id', $user?->company_id)
                ->where('user_id', '!=', $user?->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->company_filter == 'pending') {
            $videos = Video::where('company_id', $user?->company_id)
                ->where('user_id', '!=', $user?->id)->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } else {
            $videos = Video::where('company_id', $user?->company_id)
                ->where('user_id', '!=', $user?->id)->where('status', 'approve')
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        }
        if ($request->user_filter == 'shared') {
            $video_shares = VideoShare::all();
            $user_videos = Video::whereIn('id', $video_shares->pluck('video_id'))->where('user_id', $user?->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->user_filter == 'view') {
            $video_view = VideoView::all();
            $user_videos = Video::whereIn('id', $video_view->pluck('video_id'))->where('user_id', $user?->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->skip($request->user_counter ?? 0)
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->user_filter == 'pending') {
            $user_videos = Video::where('user_id', $user?->id)->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->skip($request->user_counter ?? 0)
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } else {

            $user_videos = Video::where('user_id', $user?->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->skip($request->user_counter ?? 0)
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
            //    dd($user_videos);
        }
        $records = [];
        $user_records = [];
        $compnay_counts = 0;
        foreach ($videos as $key => $datas) {
            $now = Carbon::now();
            $yesterday = Carbon::yesterday();
            $compnay_counts += count($datas);
            // $date_object = $now->format('D d M') == $key ? 'Today' : $key;
            $date_object = '';
            if ($now->format('D d M') == $key) {
                $date_object = 'Today';
            } elseif ($yesterday->format('D d M') == $key) {
                $date_object = 'Yesterday';
            } else {
                $date_object = $key;
            }
            $videos_by_date = [
                'date' => $date_object,
            ];
            foreach ($datas as $video) {
                $record = [
                    'id' => $video->id,
                    'user' => [
                        "id" => $video->user?->id,
                        "company_id" => $video->user?->company_id,
                        "first_name" => $video->user?->first_name,
                        "last_name" => $video->user?->last_name,
                        "email" => $video->user?->email,
                        "image" => $video->user?->image,
                        "email_verified_at" => $video->user?->email_verified_at,
                        "is_admin" => $video->user?->is_admin,
                        "created_at" => $video->user->created_at,
                        "updated_at" => $video->user->updated_at,
                        "total_videos" => count($video->user->videos),

                    ],
                    "video_share_counts" => count($video->videoShare),
                    "video_view_counts" => count($video->videoView),
                    'company' => $video->company?->name,
                    'title' => $video->title,
                    'description' => $video->description,
                    'status' => $video->status,
                    'video' => env('APP_IMAGE_URL') . 'video/' . $video->video,
                    'share_link' => url('video/share/' . base64_encode($video->id)),

                ];
                $videos_by_date['video'][] = $record;
            }

            $records[] = $videos_by_date;
        }
        $user_counts = 0;
        foreach ($user_videos as $key => $datas) {

            $now = Carbon::now();
            $yesterday = Carbon::yesterday();
            $user_counts += count($datas);
            // $date_object = $now->format('D d M') == $key ? 'Today' : $key;
            $date_object = '';
            if ($now->format('D d M') == $key) {
                $date_object = 'Today';
            } elseif ($yesterday->format('D d M') == $key) {
                $date_object = 'Yesterday';
            } else {
                $date_object = $key;
            }
            $videos_by_date = [
                'date' => $date_object,
            ];
            foreach ($datas as $video) {
                // dd($datas->links());

                $record = [
                    'id' => $video->id,
                    'user' => [
                        "id" => $video->user->id,
                        "company_id" => $video->user->company_id,
                        "first_name" => $video->user->first_name,
                        "last_name" => $video->user->last_name,
                        "email" => $video->user->email,
                        "image" => $video->user->image,
                        "email_verified_at" => $video->user->email_verified_at,
                        "is_admin" => $video->user->is_admin,
                        "created_at" => $video->user->created_at,
                        "updated_at" => $video->user->updated_at,
                        "total_videos" => count($video->user->videos),

                    ],
                    "video_share_counts" => count($video->videoShare),
                    "video_view_counts" => count($video->videoView),
                    'company' => $video->company?->name,
                    'title' => $video->title,
                    'description' => $video->description,
                    'status' => $video->status,
                    'video' => env('APP_IMAGE_URL') . 'video/' . $video->video,
                    'share_link' => url('video/share/' . base64_encode($video->id)),

                ];
                $videos_by_date['video'][] = $record;
            }

            $user_records[] = $videos_by_date;
        }
        // $user_records_check=false;
        if ($request->user_counter != null && $request->user_counter != 0) {
            $user_records_check = $user_counts < $request->user_counter ? false : true;
        } else {
            $user_records_check = $user_counts < 5 ? false : true;
        }
        if ($request->company_counter != null && $request->company_counter != 0) {
            $company_records_check = $compnay_counts < $request->company_counter ? false : true;
        } else {
            $company_records_check = $compnay_counts < 5 ? false : true;
        }

        return response()->json([
            'status' => true, 'message' => 'Record Found', 'user_next_video_exist' => $user_records_check,
            'company_next_video_exist' => $company_records_check != [] ? true : false, 'data' => $records, 'userData' => $user_records
        ], 200);
    }

    public function uploadVideoDeviceId(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            'device_id' => 'required',
            'video_file' => 'required',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);
        $video = $request->video_file;
        $thumbnail_image = $request->thumbnail_image;
        try {
            $user = User::where('device_id', $request->device_id)->first();

            if (!is_null($user)) {
                $video_name = '';
                if ($video) {
                    $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
                    $video->storeAs('public/video', $name);
                    $video_name = $name;
                }
                $record = Video::create([
                    'user_id' => $user->id,
                    'company_id' => $request->company_id,
                    'title' => $request->title,
                    'type' => $request->type,
                    'description' => $request->description,
                    'video' => $video_name ? $video_name : null,
                    'status' => $user->getRoleNames()->first() == 'Manager' ? 'approve' : 'pending',
                ]);
                $users = User::all();
                $managers = [];
                foreach ($users as $record) {
                    if ($record->getRoleNames()->first() == 'Manager') {
                        $managers[] = $record;
                    }
                }
                $this->sendNotification('Video Created - Awaiting Approval', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $managers, $record);
                return response()->json(['status' => true, 'message' => 'Video Add Successfully'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Found'], 500);
            }
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e], 500);
        }
    }
}
