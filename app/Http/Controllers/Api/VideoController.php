<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyVideoCollection;
use App\Http\Resources\VideoCollection;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{

    public function getVideos(Request $request)
    {
        $user = User::find($request->user_id);
        $videos = Video::where('company_id', $user->company_id)
            ->where('user_id', '!=', $user->id)->where('status', 'approved')->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('D d M');
        });
        $user_videos = Video::where('user_id', $user->id)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('D d M');
        });
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

                ];
                $videos_by_date['video'][] = $record;
            }

            $user_records[] = $videos_by_date;
        }
        return response()->json(['status' => true, 'message' => 'Record Found', 'data' => $records,'userData'=>$user_records], 200);
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
}
