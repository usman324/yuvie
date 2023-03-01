<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyVideoCollection;
use App\Http\Resources\VideoCollection;
use App\Models\Company;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoShare;
use App\Models\VideoView;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{

    public function getVideos(Request $request)
    {
        $user = User::find($request->user_id);
        if ($request->status == 'pending') {
            $videos = Video::where('company_id', $user->company_id)
                ->where('user_id', '!=', $user->id)->where('status', 'pending')
                ->byCompanyFilter($request->compnay_filter)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
            $user_videos = Video::where('user_id', $user->id)->where('status', 'pending')
            ->byUserFilter($request->user_filter)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('D d M');
            });
        } elseif ($request->status == 'shared') {
            $video_shares = VideoShare::all();
            $videos = Video::whereIn('id', $video_shares->pluck('video_id'))->where('company_id', $user->company_id)
                ->where('user_id', '!=', $user->id)->where('status', 'approved')
                ->byCompanyFilter($request->compnay_filter)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });

            $user_videos = Video::whereIn('id', $video_shares->pluck('video_id'))->where('user_id', $user->id)
            ->byUserFilter($request->user_filter)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('D d M');
            });
        } elseif ($request->status == 'view') {
            $video_view = VideoView::all();
            $videos = Video::whereIn('id', $video_view->pluck('video_id'))->where('company_id', $user->company_id)
                ->where('user_id', '!=', $user->id)->where('status', 'approved')->byCompanyFilter($request->compnay_filter)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });

            $user_videos = Video::whereIn('id', $video_view->pluck('video_id'))->where('user_id', $user->id)->byUserFilter($request->user_filter)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('D d M');
            });
        } else {
            $videos = Video::where('company_id', $user->company_id)
                ->where('user_id', '!=', $user->id)->where('status', 'approved')
                ->byCompanyFilter($request->company_filter)
                ->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                    return Carbon::parse($date->created_at)->format('D d M');
                });
            $user_videos = Video::where('user_id', $user->id)
            ->byUserFilter($request->user_filter)
                ->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('D d M');
            });
        }
        $records = [];
        $user_records = [];
        foreach ($videos as $key => $datas) {
            $now = Carbon::now();
            $yesterday = Carbon::yesterday();

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
                    'user' => $video->user,
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
        foreach ($user_videos as $key => $datas) {
            $now = Carbon::now();
            $yesterday = Carbon::yesterday();

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
                    'user' => $video->user,
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
        return response()->json(['status' => true, 'message' => 'Record Found', 'data' => $records, 'userData' => $user_records], 200);
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

        $video_name = '';
        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
        }
        Video::create([
            'user_id' => $request->user_id,
            'company_id' => $request->company_id,
            'title' => $request->title,
            'type' => $request->type,
            'description' => $request->description,
            'video' => $video_name ? $video_name : null,
        ]);
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

        return response()->json(['status' => true, 'message' => 'Video View Add Successfully'], 200);
    }

    public function changeStatusVideo(Request $request)
    {

        $record = Video::find($request->video_id);
        $record->update([
            'status' => $request->status,
        ]);
        return response()->json(['status' => true, 'message' => 'Status Change'], 200);
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
                    'name' => $company_user->first_name,
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
            'name' => $user->first_name,
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
