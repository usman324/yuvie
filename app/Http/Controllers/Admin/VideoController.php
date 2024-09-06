<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\NoiseVideo;
use App\Models\Notification;
use App\Models\User;
use App\Models\Video;
use App\Traits\Main;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    use Main;
    const TITLE = 'Videos';
    const VIEW = 'admin/video';
    const URL = 'admin/videos';
    protected $ffmpeg;

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            'video_url' => env('APP_IMAGE_URL') . 'video',
        ]);
    }


    public function toString($value)
    {
        return '"' . (string)($value) . '"';
    }
    public function index(Request $request)
    {

        // $records = Video::byCompany($request->company)
        //     ->byUser($request->user)
        //     ->latest()
        //     ->get();
        if ($request->ajax()) {
            $q_length = $request->length;
            $q_start = $request->start;
            $user = auth()->user();
            $records_q =  Video::byCompany($request->company)
                ->byUser($request->user)
                ->byRole(['Manager'])
                ->latest();

            $total_records = $records_q->count();
            // if ($q_length > 0) {
            //     $records_q = $records_q->limit($q_start + $q_length);
            // }
            $records = $records_q->get()->sortBy('order_sort');
            return DataTables::of($records)
                ->addColumn('title', function ($record) {
                    return str_replace('@', '#', $record->title);
                })->addColumn('user', function ($record) {
                    return $record->user?->first_name . ' ' . $record->user?->last_name;
                })->addColumn('status', function ($record) {
                    $status = $record->status;
                    $url = $this->toString(url('admin/video_approved/' . $record->id));
                    $ck = $record->status == 'approve' ? 'checked' : '';
                    return "<label class='switch'><input type='checkbox' value='$status' $ck  onchange='videoApproved(event,$url)'><span class='slider round'></span></label>";
                })->addColumn('video', function ($record) {
                    $url = env('APP_IMAGE_URL') . 'video/' . $record->video;
                    return "<video width='150' loading='lazy' height='100' controls><source src='$url' type='video/mp4'></video>";
                })
                ->addColumn('actions', function ($record) {
                    return view('admin.layout.partials.actions', [
                        'record' => $record
                    ])->render();
                })
                ->rawColumns(['actions', 'video', 'status'])
                ->setTotalRecords($total_records)
                ->make(true);
        }
        // ->paginate(10);
        $companies = Company::all();
        $users = User::whereIsAdmin(false)->byCompany($request->company)->get();
        $company = Company::where('name', 'YuVie')->first();
        return view(self::VIEW . '.index', get_defined_vars());
    }
    public function create(Request $request)
    {
        $companies = Company::all();
        return view(self::VIEW . '.create', get_defined_vars());
    }
    public function addCompanyVideo(Request $request, $id)
    {
        $companies = Company::where('id', $id)->get();
        $company_id = $id;
        return view(self::VIEW . '.add_company_video', get_defined_vars());
    }
    public function store(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            // 'type' => 'required',
            // 'company_id' => 'required',
            // 'title' => 'required',
            // 'description' => 'required',
            // 'video' => 'required|file', 'mimes:mp4',
            'thumbnail_image' => 'nullable|file', 'mimes:jpg,png',
            'video' => 'nullable|file', 'mimes:mp4',
            'outer_video' => 'nullable|file', 'mimes:mp4',
            // 'intro_video' => 'nullable|file', 'mimes:mp4',
        ]);
        try {
           
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
            $outer_video = $request->outer_video;
            $outer_video_name = '';
            if ($outer_video) {
                $name = rand(10, 100) . time() . '.' . $outer_video->getClientOriginalExtension();
                $outer_video->storeAs('public/video', $name);
                $outer_video_name = $name;
            }
            $intro_video = $request->intro_video;
            $intro_video_name_after_noise = '';
            if ($intro_video) {
                $name = rand(10, 100) . time() . '.' . $intro_video->getClientOriginalExtension();
                $intro_video->storeAs('public/video', $name);
                $intro_video_name = $name;
                // $response = $this->noiseReduction($intro_video_name);
                // $intro_video_name_after_noise = $response;
            }
            Video::create([
                'user_id' => Auth::id(),
                'company_id' => $request->company_id,
                'title' => $request->title,
                'description' => $request->description,
                'video' => $video_name ? $video_name : null,
                'thumbnail_image' => $thumbnail_image_name ? $thumbnail_image_name : null,
                'alpha' => is_null($request->alpha) ? 0 : 1,
                'type' => $request->type,
                'outer_video' => $outer_video_name ? $outer_video_name : null,
                'intro_video' => $intro_video_name ? $intro_video_name : null,
                // 'intro_video' => $intro_video_name_after_noise ? $intro_video_name_after_noise : null,

            ]);
            return response()->json(['status' => true, 'message' => 'Video has been created successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
            // Handle saving error
        }
    }
    public function edit($id)
    {
        $companies = Company::all();
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
        // dd(isset($request->alpha));
        ini_set('memory_limit', '1000M');
        $record = Video::find($id);
        $request->validate([
            'company_id' => 'required',
            'video' => 'nullable|file', 'mimes:mp4',
            'outer_video' => 'nullable|file', 'mimes:mp4',
            'intro_video' => 'nullable|file', 'mimes:mp4',
            'thumbnail_image' => 'nullable|file', 'mimes:jpg,png',
        ]);
        $video = $request->video;
        $outer_video = $request->outer_video;
        $intro_video = $request->intro_video;
        $thumbnail_image = $request->thumbnail_image;

        $video_name = '';
        $outer_video_name = '';
        $thumbnail_image_name = '';
        $intro_video_name = '';

        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
        }
        if ($outer_video) {
            $name = rand(10, 100) . time() . '.' . $outer_video->getClientOriginalExtension();
            $outer_video->storeAs('public/video', $name);
            $outer_video_name = $name;
        }
        if ($intro_video) {
            $name = rand(10, 100) . time() . '.' . $intro_video->getClientOriginalExtension();
            $intro_video->storeAs('public/video', $name);
            $intro_video_name = $name;
        }
        if ($thumbnail_image) {
            $name = rand(10, 100) . time() . '.' . $thumbnail_image->getClientOriginalExtension();
            $thumbnail_image->storeAs('public/video', $name);
            $thumbnail_image_name = $name;
        }
        $record->update([
            'company_id' => $request->company_id ? $request->company_id : $record->company_id,
            'video' => $video_name ? $video_name : $record->video,
            'outer_video' => $outer_video_name ? $outer_video_name : $record->outer_video,
            'intro_video' => $intro_video_name ? $intro_video_name : $record->intro_video,
            'title' => $request->title ? $request->title : $request->title,
            'alpha' => is_null($request->alpha) ? 0 : 1,
            'type' => $request->type,
            'description' => $request->description,
            'thumbnail_image' => $thumbnail_image_name ? $thumbnail_image_name : $record->thumbnail_image,
        ]);
        return response()->json(['status' => true, 'message' => 'Video has been updated successfully'], 200);
    }
    public function videoApproved(Request $request, $id)
    {

        $record = Video::find($id);
        $record->update([
            'status' => $request->is_approve,
        ]);
        // dd($request->all());
        $user = User::find($record->user_id);
        $users = User::where('company_id', $user->company_id)->get();
        if ($record->status == 'approve') {
            $this->notification('Video Created - Approved', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $record);
            // $this->sendNotification('YuVie LLC', $record->name . ' Video Approved',$users);
            Notification::create([
                'user_id' => $user->id,
                'video_id' => $record->id,
                'title' => 'Video Created - Approved',
                'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
            ]);
        }
        if ($record->status == 'reject') {
            $this->notification('Video Created - Rejected', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $record);

            Notification::create([
                'user_id' => $user->id,
                'video_id' => $record->id,
                'title' => 'Video Created - Rejected',
                'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
            ]);
        }
        if ($record->status == 'pending') {
            // $users=User::all();
            $this->notification('Video Created - Not Approved', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $record);
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

    public function getCompanyUser(Request $request)
    {
        $records = User::where('company_id', $request->company_id)->get();
        return view(self::VIEW . '.partial.user', get_defined_vars());
    }
}
