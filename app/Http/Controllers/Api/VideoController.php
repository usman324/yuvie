<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyVideoCollection;
use App\Http\Resources\VideoCollection;
use App\Models\Company;
use App\Models\NoiseVideo;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoShare;
use App\Models\Notification;
use App\Models\VideoView;
use App\Traits\Main;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class VideoController extends Controller
{
    use Main;

    public function getVideos(Request $request)
    {
        $user = User::find($request->user_id);
        $users = User::where('company_id', $user?->company_id)
            ->where('id', '!=', 1)
            ->where('id', '!=', $request->user_id)
            ->get();
        $users->prepend($user);
        // dd($request->user_ids);
        if ($request->company_filter == 'shared') {
            $video_shares = VideoShare::all();
            $videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->whereIn('id', $video_shares->pluck('video_id'))
                ->where('company_id', $user?->company_id)
                ->where('user_id', '!=', 1)
                // ->where('user_id', '!=', $user->id)
                ->where('status', 'approve')->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->company_filter == 'view') {
            $video_view = VideoView::all();
            $videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->whereIn('id', $video_view->pluck('video_id'))
                ->where('company_id', $user?->company_id)
                // ->where('user_id', '!=', $user->id)
                ->where('user_id', '!=', 1)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->company_filter == 'pending') {
            $videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->where('status', 'pending')
                ->where('company_id', $user?->company_id)
                // ->orWhere('user_id', '!=', $user->id)
                ->where('user_id', '!=', 1)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->user_ids) {
            $ids = explode('_', $request->user_ids);
            // dd($ids);
            $videos = Video::byTitle($request->title)
                ->whereIn('user_id', $ids)
                ->where('user_id', '!=', 1)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } else {
            // dd($request->title);
            $videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->where('status', 'approve')
                ->where('company_id', $user?->company_id)
                // ->where('user_id', '!=', $user->id)
                ->where('user_id', '!=', 1)
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
            $user_videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->whereIn('id', $video_shares->pluck('video_id'))->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->user_filter == 'view') {
            $video_view = VideoView::all();
            $user_videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->whereIn('id', $video_view->pluck('video_id'))->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->skip($request->user_counter ?? 0)
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->user_filter == 'pending') {
            $user_videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->where('user_id', $user->id)->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->skip($request->user_counter ?? 0)
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } else {

            $user_videos = Video::byTitle($request->title)
                // ->byDescription($request->description)
                ->where('user_id', $user->id)
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
                // if ($video?->user?->is_admin != true) {
                $record = [
                    'id' => $video->id,
                    'user' => [
                        "id" => $video?->user?->id,
                        "company_id" => $video?->user?->company_id ? $video?->user?->company_id : '',
                        "first_name" => isset($video->user->first_name) ? $video->user->first_name : '',
                        "last_name" => isset($video->user->last_name) ? $video->user->last_name : '',
                        "email" => isset($video->user->email) ? $video->user->email : '',
                        "color" => isset($video->user->color) ? $video->user->color : '',
                        "image" => isset($video->user->image) ? env('APP_IMAGE_URL') . 'user/' . $video->user->image : '',
                        "email_verified_at" => isset($video->user->email_verified_at) ? $video->user->email_verified_at : "",
                        "is_admin" => $video->user->is_admin,
                        "created_at" => $video->user->created_at,
                        "updated_at" => $video->user->updated_at,
                        "total_videos" => count($video->user->approvedVideo),

                    ],
                    "video_share_counts" => $video->totalShareCounts(),
                    "video_view_counts" => $video->totalViewCounts(),
                    'company' => $video->company?->name ? $video->company?->name : '',
                    'title' => $video->title ? $video->title : '',
                    'description' => $video->description ? $video->description : '',
                    'status' => $video->status,
                    'video' => $video->video ? env('APP_IMAGE_URL') . 'video/' . $video->video : '',
                    'outer_video' => $video->outer_video ? env('APP_IMAGE_URL') . 'video/' . $video->outer_video : '',
                    'intro_video' => $video->intro_video ? env('APP_IMAGE_URL') . 'video/' . $video->intro_video : '',
                    'thumbnail_image' => $video->thumbnail_image ? env('APP_IMAGE_URL') . 'video/' . $video->thumbnail_image  : '',
                    'share_link' => url('video/share/' . base64_encode($video->id)),

                ];
                $videos_by_date['video'][] = $record;
                // }
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
                        "first_name" => isset($video->user->first_name) ? $video->user->first_name : "",
                        "last_name" => isset($video->user->last_name) ? $video->user->last_name : "",
                        "email" => isset($video->user->email) ? $video->user->email : "",
                        "color" => isset($video->user->color) ? $video->user->color : "",
                        "image" => isset($video->user->image) ? env('APP_IMAGE_URL') . 'user/' . $video->user->image : '',
                        "email_verified_at" => isset($video->user->email_verified_at) ? $video->user->email_verified_at : "",
                        "is_admin" => $video->user->is_admin,
                        "created_at" => $video->user->created_at,
                        "updated_at" => $video->user->updated_at,
                        "total_videos" => count($video->user->approvedVideo),

                    ],
                    "video_share_counts" => $video->totalShareCounts(),
                    "video_view_counts" => $video->totalViewCounts(),
                    'company' => $video->company?->name ? $video->company?->name : '',
                    'title' => $video->title ? $video->title : '',
                    'description' => $video->description ? $video->description : '',
                    'status' => $video->status,
                    'video' => $video->video ? env('APP_IMAGE_URL') . 'video/' . $video->video : '',
                    'outer_video' => $video->outer_video ? env('APP_IMAGE_URL') . 'video/' . $video->outer_video : '',
                    'intro_video' => $video->intro_video ? env('APP_IMAGE_URL') . 'video/' . $video->intro_video : '',
                    'thumbnail_image' => $video->thumbnail_image ? env('APP_IMAGE_URL') . 'video/' . $video->thumbnail_image  : '',
                    'share_link' => url('video/share/' . base64_encode($video->id)),

                ];
                $videos_by_date['video'][] = $record;
            }

            $user_records[] = $videos_by_date;
            // $user_records = $videos_by_date;
        }
        // $user_records_check=false;
        $company_records = [];
        foreach ($users as $company_user_record) {
            $company_record = [
                "id" => $company_user_record->id,
                "company_id" => isset($company_user_record?->company_id) ? $company_user_record?->company_id : "",
                "first_name" => isset($company_user_record->first_name) ? $company_user_record->first_name : "",
                "last_name" => isset($company_user_record->last_name) ? $company_user_record->last_name : "",
                "email" => isset($company_user_record->email) ? $company_user_record->email : "",
                "color" => isset($company_user_record->color) ? $company_user_record->color : "",
                "image" => isset($company_user_record->image) ? env('APP_IMAGE_URL') . 'user/' . $company_user_record->image : "",
                "email_verified_at" => isset($company_user_record->email_verified_at) ? $company_user_record->email_verified_at : "",
                "is_admin" => $company_user_record->is_admin,
                "created_at" => $company_user_record->created_at,
                "updated_at" => $company_user_record->updated_at,
                // "total_videos" => count($company_user->videos),
            ];
            $company_records[] = $company_record;
        }
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
        // users videos according user ids 

        return response()->json([
            'status' => true, 'message' => 'Record Found',
            'user_next_video_exist' => $user_records_check,
            'company_next_video_exist' => $company_records_check != [] ? true : false,
            'data' => $records,
            // 'userData' => $user_records,
            'companyUsers' => $company_records,
        ], 200);
    }
    public function getVideoById(Request $request)
    {
        $video = Video::find($request->video_id);
        $record = [
            'id' => $video->id,
            'user' => [
                "id" => $video->user->id ? $video->user->id : '',
                "company_id" => $video->user->company_id ? $video->user->company_id : '',
                "first_name" => $video->user->first_name ? $video->user->first_name : '',
                "last_name" => $video->user->last_name ? $video->user->last_name : '',
                "email" => $video->user->email ? $video->user->email : '',
                "color" => $video->user->color ? $video->user->color : '',
                "image" => isset($video->user->image) ? env('APP_IMAGE_URL') . 'user/' . $video->user->image : '',
                "email_verified_at" => $video->user->email_verified_at ? $video->user->email_verified_at : '',
                "is_admin" => $video->user->is_admin ? $video->user->is_admin : '',
                "created_at" => $video->user->created_at ? $video->user->created_at : '',
                "updated_at" => $video->user->updated_at ? $video->user->updated_at : '',
                "total_videos" => count($video->user->videos),

            ],
            "video_share_counts" => count($video->videoShare),
            "video_view_counts" => count($video->videoView),
            'company' => $video->company?->name ? $video->company?->name : '',
            'title' => $video->title ? $video->title : '',
            'description' => $video->description ? $video->description : '',
            'status' => $video->status,
            'video' => $video->video ? env('APP_IMAGE_URL') . 'video/' . $video->video : '',
            'outer_video' => $video->outer_video ? env('APP_IMAGE_URL') . 'video/' . $video->outer_video : '',
            'intro_video' => $video->intro_video ? env('APP_IMAGE_URL') . 'video/' . $video->intro_video : '',
            'thumbnail_image' => $video->thumbnail_image ? env('APP_IMAGE_URL') . 'video/' . $video->thumbnail_image  : '',
            'share_link' => url('video/share/' . base64_encode($video->id)),

        ];
        return response()->json([
            'status' => true, 'message' => 'Record Found', 'data' => $record,
        ], 200);
    }
    public function getCompanyVideos(Request $request)
    {
        // $users = User::where('is_admin', true)->get();
        // return new CompanyVideoCollection(
        //     Video::where('company_id', $request->company_id)
        //         ->whereIn('user_id', $users->pluck('id'))
        //         ->get(),
        // );
        $users = User::where('is_admin', true)->get();
        $company = Company::find($request->company_id);
        $videos = Video::whereIn('user_id', $users->pluck('id'));
        if ($company->name != 'YuVie') {
            $records = $videos->where('company_id', $request->company_id)->get();
        } else {
            $records = $videos->get();
        }
        return new CompanyVideoCollection($records);
    }
    public function uploadVideo(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            'user_id' => 'required',
            'video_file' => 'required',
            // 'title' => 'required',
            'type' => 'required',
            // 'description' => 'required',
            // 'thumbnail_image' => 'required',
        ]);

        $video = $request->video_file;
        $thumbnail_image = $request->thumbnail_image;
        $user = User::find($request->user_id);
        $noti_title = $user->hasRole('Manager') ? 'Approved' : 'Awaiting Approval';
        $video_name = '';
        $video_name_after_noise = '';
        $thumbnail_image_name = '';
        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
            // $response = $this->noiseReduction($video_name);
            // $video_name_after_noise = $response;
        }
        if ($thumbnail_image) {
            $name = rand(10, 100) . time() . '.' . $thumbnail_image->getClientOriginalExtension();
            $thumbnail_image->storeAs('public/video', $name);
            $thumbnail_image_name = $name;
        }
        $record = Video::create([
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'title' => str_replace('@', '#', $request->title),
            'type' => $request->type,
            'description' => $request->description,
            'video' => $video_name ? $video_name : null,
            // 'video' => $video_name_after_noise ? $video_name_after_noise : null,
            'thumbnail_image' => $thumbnail_image_name ? $thumbnail_image_name : null,
            'status' => $user->getRoleNames()->first() == 'Manager' ? 'approve' : 'pending',
        ]);
        $users = User::all();
        $managers = [];
        foreach ($users as $user) {
            if ($user->getRoleNames()->first() == 'Manager') {
                $managers[] = $user;
            }
        }
        // $this->sendNotification('Video Created - '.$user->getRoleNames()->first() == 'Manager' ? 'Approved':'Awaiting Approval', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $managers, $record);
        $this->sendNotification('Video Created - ' . $noti_title, $record->title . PHP_EOL . $record->created_at->format('M d Y'), $managers, $record);
        return response()->json(['status' => true, 'message' => 'Video has been created successfully'], 200);
    }
    public function updateVideo(Request $request)
    {
        $record = Video::find($request->video_id);
        $video = $request->video_file;
        $video_name = '';
        $video_name_after_noise = '';
        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
            // $response = $this->noiseReduction($video_name);
            // $video_name_after_noise = $response;
        }
        $record->update([
            'title' => $request->title ? $request->title : $record->title,
            // 'video' => $video_name_after_noise ? $video_name_after_noise : $record->video,
            'video' => $video_name ? $video_name : $record->video,
            'description' => $request->description ? $request->description : $record->description,
        ]);
        return response()->json(['status' => true, 'message' => 'Video has been updated successfully', 'data' => $record], 200);
    }
    public function videoShare(Request $request)
    {
        $record = VideoShare::where('video_id', $request->video_id)->first();
        $video = Video::find($request->video_id);
        $user = User::find($video->user_id);;
        if (isset($record)) {
            $record->update([
                'total_counts' => $record->total_counts + 1,
            ]);
        } else {
            VideoShare::create([
                'video_id' => $request->video_id,
                'total_counts' => 1,
            ]);
        }
        $this->notification('Video Created - Shared', $video->title . PHP_EOL . $video->created_at->format('M d Y'), $user, $video);
        Notification::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'title' => 'Video Created - Shared',
            'description' => $video->title . PHP_EOL . $video->created_at->format('M d Y'),
        ]);
        return response()->json(['status' => true, 'message' => 'Video View has been created successfully'], 200);
    }

    public function changeStatusVideo(Request $request)
    {
        try {

            $record = Video::findOrFail($request->video_id);
            $user = User::findOrFail($record->user_id);
            $record->update([
                'status' => $request->status ? $request->status : $record->status,
            ]);
            if ($record->status == 'archive') {
                // $this->notification('Video Created - Archive', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user);
                // $this->sendNotification('YuVie LLC', $record->name . ' Video Approved',$users);
                // Notification::create([
                //     'user_id' => $user->id,
                //     'video_id' => $record->id,
                //     'title' => 'Video Created - Archive',
                //     'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
                // ]);
                return response()->json(['status' => true, 'message' => 'Status Change'], 200);
            }

            if ($record->status == 'reject') {
                $this->notification('Video Created - Rejected', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $record);
                // $this->sendNotification('YuVie LLC', $record->name . ' Video Approved',$users);
                Notification::create([
                    'user_id' => $user->id,
                    'video_id' => $record->id,
                    'title' => 'Video Created - Rejected',
                    'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
                ]);
                return response()->json(['status' => true, 'message' => 'Status Change'], 200);
            }

            if ($record->status == 'approve') {
                $this->notification('Video Created - Approved', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $record);
                // $this->sendNotification('YuVie LLC', $record->name . ' Video Approved',$users);
                Notification::create([
                    'user_id' => $user->id,
                    'video_id' => $record->id,
                    'title' => 'Video Created - Approved',
                    'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
                ]);
                return response()->json(['status' => true, 'message' => 'Status Change'], 200);
            }

            return response()->json(['status' => true, 'message' => 'Status Change'], 200);
        } catch (Exception $ex) {
            return response()->json(['status' => false, 'message' => 'Something went wrong. Please try later'], 200);
        }
    }

    public function destroy(Request $request)
    {

        $record = Video::find($request->video_id);
        $record->delete();
        return response()->json(['status' => true, 'message' => 'Video has been deleted successfully'], 200);
    }
    public function getCounts(Request $request)
    {
        $user = User::find($request->user_id);
        $company_users = User::where('company_id', $request->company_id)
            ->where('id', '!=', $request->user_id)
            ->get();
        // array_unshift($company_users,$user);  
        // $company_users->prepend($user);
        $company_records = [];
        foreach ($company_users as $company_user) {
            if ($company_user->getRoleNames()->first() == 'Mobile User' || $company_user->getRoleNames()->first() == 'Manager') {
                $company_user_video_total = 0;
                $company_user_share_total = 0;
                foreach ($company_user->videos as $company_user_video) {
                    $company_user_video_total = $company_user_video->totalCounts();
                }
                foreach ($company_user->videos as $company_user_share_video) {

                    $company_user_share_total += $company_user_share_video->totalShareCounts();
                }
                $company_record = [
                    'first_name' => $company_user->first_name ? $company_user->first_name : '',
                    'last_name' => $company_user->last_name ? $company_user->last_name : '',
                    'color' => $company_user->color ? $company_user->color : '',
                    'image' => $company_user->image ? env('APP_IMAGE_URL') . 'user/' . $company_user->image : '',
                    'videos' => count($company_user->approvedVideo),
                    'pending' => $company_user->videos->where('status', 'pending')->count(),
                    'views' => $company_user_video_total,
                    'shares' => $company_user_share_total,
                ];
                $company_records[] = $company_record;
            }
        }

        $user_video_total = 0;
        $user_share_total = 0;
        foreach ($user->videos as $user_video) {
            $user_video_total += $user_video->totalCounts();
        }
        foreach ($user->videos as $user_share_video) {
            $user_share_total += $user_share_video->totalShareCounts();
        }
        $data = [
            'first_name' => $user->first_name ? $user->first_name : '',
            'last_name' => $user->last_name ? $user->last_name : '',
            'color' => $user->color ? $user->color : '',
            'image' => $company_user->image ? env('APP_IMAGE_URL') . 'user/' . $company_user->image : '',
            'videos' => count($user->approvedVideo),
            'pending' => $user->videos->where('status', 'pending')->count(),
            'views' => $user_video_total,
            'shares' => $user_share_total,

        ];
        $sort_company_records = collect($company_records)->sortByDesc('videos');
        $sort_company_records->prepend($data);
        $records[] = ['user' => $data, 'company' => array_values($sort_company_records->toArray())];
        return response()->json(['status' => true, 'message' => 'Count Record', 'data' => $records], 200);
    }
    public function getFilterByStatus(Request $request)
    {
        $status = $request->status;
    }
}
