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
        $videos = Video::with('user', 'company')->where('company_id', $user->company_id)->orderBy('created_at', 'desc')->get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('D d M');
        });
        $records = [];
        foreach ($videos as $key => $datas) {
            $videos_by_date = [];
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
            foreach ($datas as $video) {
                $record = [
                    'date' => $date_object,
                    'video' => [
                        [
                            'id' => $video->id,
                            'user' => $video->user,
                            'company' => $video->company?->name,
                            'title' => $video->title,
                            'description' => $video->description,
                            'status' => $video->status,
                            'video' => env('APP_IMAGE_URL') . 'video/' . $video->video,
                        ]
                    ]
                ];
                $videos_by_date = $record;
            }

            $records[] = $videos_by_date;
        }
        return response()->json(['status' => true, 'message' => 'Record Found', 'data' => $records], 200);
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
        return new CompanyVideoCollection(
            Video::where('company_id', $request->company_id)->get(),
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
