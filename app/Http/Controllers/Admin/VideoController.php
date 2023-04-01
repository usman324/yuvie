<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use App\Models\Video;
use App\Traits\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{
    use Main;
    const TITLE = 'Videos';
    const VIEW = 'admin/video';
    const URL = 'admin/videos';

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            'video_url' => env('APP_IMAGE_URL') . 'video',
        ]);
    }
    public function index(Request $request)
    {
        $records = Video::latest()->get();
        return view(self::VIEW . '.index', get_defined_vars());
    }
    public function create(Request $request)
    {
        $companies=Company::all();
        return view(self::VIEW . '.create', get_defined_vars());
    }
    public function store(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            'company_id' => 'required',
            'video' => 'required|file', 'mimes:mp4',
            'thumbnail_image' => 'required|file', 'mimes:jpg,png',
        ]);
        $video = $request->video;
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
            'user_id' => Auth::id(),
            'company_id' => $request->company_id,
            'video' => $video_name ? $video_name : null,
            'thumbnail_image' => $thumbnail_image_name ? $thumbnail_image_name : null,
        ]);
        return response()->json(['status' => true, 'message' => 'Video Add Successfully'], 200);
    }
    public function edit($id)
    {
        $companies=Company::all();
        $record = Video::find($id);
        return view(self::VIEW . '.edit', get_defined_vars());
    }
    public function show($id)
    {
        $record = Video::find($id);
        return view(self::VIEW . '.show', get_defined_vars());
    }
    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '1000M');
        $record = Video::find($id);
        $request->validate([
            'company_id' => 'required',
            'video' => 'nullable|file', 'mimes:mp4',
            // 'thumbnail_image' => 'nullable|file', 'mimes:jpg,png',
        ]);
        $video = $request->video;
        // $thumbnail_image = $request->thumbnail_image;

        $video_name = '';
        // $thumbnail_image_name = '';

        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
        }
        // if ($thumbnail_image) {
        //     $name = rand(10, 100) . time() . '.' . $thumbnail_image->getClientOriginalExtension();
        //     $thumbnail_image->storeAs('public/video', $name);
        //     $thumbnail_image_name = $name;
        // }
        $record->update([
            'company_id' => $request->company_id ? $request->company_id : $record->company_id,
            'video' => $video_name ? $video_name : $record->video,
            'title' => $request->title?$request->title:$request->title,
            'type' => $request->type,
            'description' => $request->description ? $request->description : $request->description,
            // 'thumbnail_image' => $thumbnail_image_name ? $thumbnail_image_name : $record->thumbnail_image,
        ]);
        return response()->json(['status' => true, 'message' => 'Video Update Successfully'], 200);
    }
    public function videoApproved(Request $request, $id)
    {
        $record = Video::find($id);
        $record->update(['status' => $request->is_approve,
        ]);
        $user = User::find($record->user_id);
        $users = User::where('company_id', $user->company_id)->get();
        if($record->status == 'approved'){
            $this->notification('YuVie LLC', $record->title . ' Video Approved',$user);
            // $this->sendNotification('YuVie LLC', $record->name . ' Video Approved',$users);
            Notification::create([
                'user_id'=>$user->id,
                'video_id' => $record->id,
                'title'=>'Video Approved',
                'description' => $record->title . ' Video Approved',
            ]);
        }
        
        return response()->json(['status' => true, 'message' => 'Status Change'], 200);
    }
    public function destroy($id)
    {
        $record = Video::find($id);
        if ($record) {
            $record->delete();
            return 1;
        }
    }
}
