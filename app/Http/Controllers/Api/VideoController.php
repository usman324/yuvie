<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyVideoCollection;
use App\Http\Resources\VideoCollection;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{

    public function getVideos(Request $request)
    {
        $user = auth('api')->user();
        return new VideoCollection(
            Video::where('company_id', $request->company_id)->get(),
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
        ]);
        $video = $request->video_file;
        $thumbnail_image = $request->thumbnail_image;

        $video_name = '';
        $thumbnail_image_name = '';

            if ($video) {
                $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
                $video->storeAs('public/video', $name);
                $video_name = $name;
            }
            if ($thumbnail_image) {
                $name = rand(10, 100) . time() . '.' . $thumbnail_image->getClientOriginalExtension();
                $thumbnail_image->storeAs('public/video', $name);
                $thumbnail_image_name = $name;
            }
            Video::create([
                'user_id' => $request->user_id,
                'company_id' => $request->company_id,
                'video' => $video_name ? $video_name : null,
                'thumbnail_image' => $thumbnail_image_name ? $thumbnail_image_name : null,
            ]);
        return response()->json(['status' => true, 'message' => 'Video Add Successfully'], 200);
    }
}
