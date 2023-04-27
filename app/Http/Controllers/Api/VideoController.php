<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyVideoCollection;
use App\Http\Resources\VideoCollection;
use App\Models\Company;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoShare;
use App\Models\Notification;
use App\Models\VideoView;
use App\Traits\Main;
use Carbon\Carbon;
use Exception;
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
        if ($request->company_filter == 'shared') {
            $video_shares = VideoShare::all();
            $videos = Video::whereIn('id', $video_shares->pluck('video_id'))->where('company_id', $user->company_id)
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
            $videos = Video::whereIn('id', $video_view->pluck('video_id'))->where('company_id', $user->company_id)
                ->where('user_id', '!=', $user->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->company_filter == 'pending') {
            $videos = Video::where('company_id', $user->company_id)
                ->where('user_id', '!=', $user->id)->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->company_counter)
                ->get()
                ->skip($request->company_counter ?? 0)
                ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } else {
            $videos = Video::where('company_id', $user->company_id)
                ->where('user_id', '!=', $user->id)->where('status', 'approve')
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
            $user_videos = Video::whereIn('id', $video_shares->pluck('video_id'))->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->user_filter == 'view') {
            $video_view = VideoView::all();
            $user_videos = Video::whereIn('id', $video_view->pluck('video_id'))->where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->skip($request->user_counter ?? 0)
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } elseif ($request->user_filter == 'pending') {
            $user_videos = Video::where('user_id', $user->id)->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                // ->paginate(20, ['*'], 'page', $request->user_counter)
                ->get()
                ->skip($request->user_counter ?? 0)
                ->take($request->user_counter != null && $request->user_counter != 0 ? $request->user_counter : 5)
                ->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
        } else {

            $user_videos = Video::where('user_id', $user->id)
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
                        "id" => $video->user->id,
                        "company_id" => $video->user->company_id,
                        "first_name" => isset($video->user->first_name) ? $video->user->first_name : '',
                        "last_name" => isset($video->user->last_name) ? $video->user->last_name : '',
                        "email" => isset($video->user->email) ? $video->user->email : '',
                        "image" => isset($video->user->image) ? env('APP_IMAGE_URL') . 'user/' . $video->user->image : '',
                        "email_verified_at" => isset($video->user->email_verified_at) ? $video->user->email_verified_at : "",
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
                        "image" => isset($video->user->image) ? env('APP_IMAGE_URL') . 'user/' . $video->user->image : '',
                        "email_verified_at" => isset($video->user->email_verified_at) ? $video->user->email_verified_at : "",
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
            // $user_records = $videos_by_date;
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
            'status' => true, 'message' => 'Record Found',
            'user_next_video_exist' => $user_records_check,
            'company_next_video_exist' => $company_records_check != [] ? true : false,
            'data' => $records,
            'userData' => $user_records
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
                "image" => isset($video->user->image) ? env('APP_IMAGE_URL') . 'user/' . $video->user->image : '',
                "email_verified_at" => $video->user->email_verified_at ? $video->user->email_verified_at : '',
                "is_admin" => $video->user->is_admin ? $video->user->is_admin : '',
                "created_at" => $video->user->created_at ? $video->user->created_at : '',
                "updated_at" => $video->user->updated_at ? $video->user->updated_at : '',
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
        return response()->json([
            'status' => true, 'message' => 'Record Found', 'data' => $record,
        ], 200);
    }
    public function getCompanyVideos(Request $request)
    {
        // $videos = Video::all();
        // $records=[];
        // foreach($videos as $record){
        //     if($record->user->getRoleNames()->first() != 'Mobile User'){
        //         $records[] = $record;
        //     }
        // }
        $users = User::where('is_admin', true)->get();
        return new CompanyVideoCollection(
            Video::where('company_id', $request->company_id)
                ->whereIn('user_id', $users->pluck('id'))
                ->get(),
        );
    }
    public function uploadVideo(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            'user_id' => 'required',
            'video_file' => 'required',
            'title' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);
        $video = $request->video_file;
        $thumbnail_image = $request->thumbnail_image;
        $user = User::find($request->user_id);
        $video_name = '';
        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
        }
        $record = Video::create([
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'video' => $video_name ? $video_name : null,
            'status' => $user->getRoleNames()->first() == 'Manager' ? 'approve' : 'pending',
        ]);
        $users = User::all();
        $managers = [];
        foreach ($users as $user) {
            if ($user->getRoleNames()->first() == 'Manager') {
                $managers[] = $user;
            }
        }
        $this->sendNotification('Video Created - Awaiting Approval', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $managers, $record);
        return response()->json(['status' => true, 'message' => 'Video Add Successfully'], 200);
    }
    public function updateVideo(Request $request)
    {
        $record = Video::find($request->video_id);
        $video = $request->video_file;
        $video_name = '';
        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
        }
        $record->update([
            'title' => $request->title ? $request->title : $record->title,
            'video' => $video_name ? $video_name : $record->video,
            'description' => $request->description ? $request->description : $record->description,
        ]);
        return response()->json(['status' => true, 'message' => 'Video Update Successfully', 'data' => $record], 200);
    }
    public function videoShare(Request $request)
    {
        $record = VideoShare::where('video_id', $request->video_id)->first();
        $video = Video::find($request->video_id);
        $user = User::find($record->user_id);;
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
        $this->notification('Video Created - Shared', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $video);
        Notification::create([
            'user_id' => $user->id,
            'video_id' => $record->id,
            'title' => 'Video Created - Shared',
            'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
        ]);
        return response()->json(['status' => true, 'message' => 'Video View Add Successfully'], 200);
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
        return response()->json(['status' => true, 'message' => 'Video Delete Successfully'], 200);
    }
    public function getCounts(Request $request)
    {
        $user = User::find($request->user_id);
        $company_users = User::where('company_id', $request->company_id)
            ->where('id', '!=', $request->user_id)->get();
        $company_records = [];
        foreach ($company_users as $company_user) {
            if ($company_user->getRoleNames()->first() == 'Mobile User') {
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
                    'image' => $company_user->image ? env('APP_IMAGE_URL') . 'user/' . $company_user->image : asset('theme/img/avatar.png'),
                    'videos' => $company_user->videos->count(),
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
            'videos' => $user->videos->count(),
            'pending' => $user->videos->where('status', 'pending')->count(),
            'views' => $user_video_total,
            'shares' => $user_share_total,

        ];
        $records[] = ['user' => $data, 'company' => $company_records];
        return response()->json(['status' => true, 'message' => 'Count Record', 'data' => $records], 200);
    }
    public function getFilterByStatus(Request $request)
    {
        $status = $request->status;
    }
}
