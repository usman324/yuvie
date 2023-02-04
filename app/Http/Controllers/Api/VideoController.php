<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyVideoCollection;
use App\Http\Resources\VideoCollection;
use App\Models\User;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{

    public function getVideos(Request $request)
    {
        $user=User::find($request->user_id);
        return new VideoCollection(
            Video::where('company_id', $user->company_id)->get(),
        );
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
                // 'thumbnail_image' => $thumbnail_image_name ? $thumbnail_image_name : null,
            ]);
        return response()->json(['status' => true, 'message' => 'Video Add Successfully'], 200);
    }
    public function updateVideo(Request $request)
    {
        $record=Video::find($request->video_id);
        $video = $request->video_file;
            // $video_name = '';
            //     if ($video) {
            //         $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            //         $video->storeAs('public/video', $name);
            //         $video_name = $name;
            //     }
        $record->update([
                'title' => $request->title?$request->title:$record->title,
            'description' => $request->description ? $request->description : $record->description,
        ]);
        return response()->json(['status' => true, 'message' => 'Video Update Successfully', 'data' => $record], 200);
    }

    public function destroy(Request $request){

        $record = Video::find($request->video_id);
        $record->delete();
        return response()->json(['status' => true, 'message' => 'Video Delete Successfully'], 200);
    }
}
