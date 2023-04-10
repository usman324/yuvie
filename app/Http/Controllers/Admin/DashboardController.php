<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoShare;
use App\Models\VideoView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    const VIEW = 'admin';

    public function __construct()
    {
        view()->share([
            'url' => url('admin/dashbaord'),
            'image_url' => env('APP_IMAGE_URL') . 'user'
        ]);
    }
    public function index(Request $request)
    {
        $users = User::count();
        $companies = Company::count();
        $videos = Video::count();
        $latest_users = User::whereIsAdmin(false)->latest()->get()->take(5);
        $monthly_videos = Video::get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });
        $monthly_users = User::get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });
        $video_records = [];
        $month = [];
        foreach ($monthly_videos as $key => $monthly_video) {
            $monthly_data = 0;
            $monthly_data += count($monthly_video);
            $video_records[] = $monthly_data;
        }
        $user_records = [];
        // $month = [];
        foreach ($monthly_users as $key => $monthly_user) {
            $monthly_user_data = 0;
            $monthly_user_data += count($monthly_user);
            $user_records[] = $monthly_user_data;
        }
        return view(self::VIEW . '.dashboard.index', get_defined_vars());
    }
    public function login()
    {
        if (auth()->user() && auth()->user()->is_admin == true) {
            return redirect('admin/dashboard');
        } else {
            return view(self::VIEW . '.auth.login');
        }
    }
    public function showVideo($id)
    {
        $video_id = base64_decode($id);
        $record = Video::find($video_id);
        $user = $record->user;
        $lat = $user->company->companyDetail->latitude;
        $lng = $user->company->companyDetail->longitude;
        $url = env('APP_IMAGE_URL') . 'video/' . $record->video;
        $video_view = VideoView::where('video_id', $record->id)->first();
        if (isset($video_view)) {
            $video_view->update([
                'total_counts' => $video_view->total_counts + 1,
            ]);
            
        } else {
            VideoView::create([
                'video_id' => $record->id,
                'total_counts' => 1,
            ]);
        }
        $this->notification('Video Created - Viewed', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user,$record);
            Notification::create([
                'user_id' => $user->id,
                'video_id' => $record->id,
                'title' => 'Video Created - Viewed',
                'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
            ]);
        return view('detail', get_defined_vars());
    }
}
