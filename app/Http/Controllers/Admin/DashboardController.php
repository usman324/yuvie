<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackgroundMusic;
use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoShare;
use App\Models\VideoView;
use App\Traits\Main;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Google\Cloud\Speech\V1\SpeechClient;
use Google\Cloud\Speech\V1\RecognitionConfig\AudioEncoding;
use Google\Cloud\Speech\V1\RecognitionConfig;
use Google\Cloud\Speech\V1\StreamingRecognitionConfig;
use Illuminate\Support\Facades\Storage;
use File;

class DashboardController extends Controller
{
    use Main;
    const VIEW = 'admin';

    public function __construct()
    {
        view()->share([
            'url' => url('admin/dashbaord'),
            'image_url' => env('APP_IMAGE_URL') . 'company'
        ]);
    }
    public function index(Request $request)
    {
        $users = User::count();
        $companies = Company::count();
        $videos = Video::count();
        $latest_users = User::whereIsAdmin(false)->latest()->get()->take(5);
        $latest_companies = Company::latest()->get()->take(5);
        $monthly_videos = Video::get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });
        $monthly_users = User::get()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('M');
        });
        $video_records_by_months = [];
        $month = [];
        foreach ($monthly_videos as $key => $monthly_video) {
            // dd($key);
            $monthly_data = 0;
            $monthly_data += count($monthly_video);
            $video_records_by_months[$key] = $monthly_data;
        }
        $user_records_by_months = [];
        // $month = [];
        foreach ($monthly_users  as $key => $monthly_user) {
            $monthly_user_data = 0;
            $monthly_user_data += count($monthly_user);
            $user_records_by_months[$key] = $monthly_user_data;
        }
        $video_records = [
            '0' => isset($video_records_by_months['Jan']) ? $video_records_by_months['Jan'] : 0,
            '1' => isset($video_records_by_months['Feb']) ? $video_records_by_months['Feb'] : 0,
            '2' => isset($video_records_by_months['Mar']) ? $video_records_by_months['Mar'] : 0,
            '3' => isset($video_records_by_months['Apr']) ? $video_records_by_months['Apr'] : 0,
            '4' => isset($video_records_by_months['May']) ? $video_records_by_months['May'] : 0,
            '5' => isset($video_records_by_months['Jun']) ? $video_records_by_months['Jun'] : 0,
            '6' => isset($video_records_by_months['Jul']) ? $video_records_by_months['Jul'] : 0,
            '7' => isset($video_records_by_months['Aug']) ? $video_records_by_months['Aug'] : 0,
            '8' => isset($video_records_by_months['Sep']) ? $video_records_by_months['Sep'] : 0,
            '9' => isset($video_records_by_months['Oct']) ? $video_records_by_months['Oct'] : 0,
            '10' => isset($video_records_by_months['Nov']) ? $video_records_by_months['Nov'] : 0,
            '11' => isset($video_records_by_months['Dec']) ? $video_records_by_months['Dec'] : 0,
        ];
        $user_records = [
            '0' => isset($user_records_by_months['Jan']) ? $user_records_by_months['Jan'] : 0,
            '1' => isset($user_records_by_months['Feb']) ? $user_records_by_months['Feb'] : 0,
            '2' => isset($user_records_by_months['Mar']) ? $user_records_by_months['Mar'] : 0,
            '3' => isset($user_records_by_months['Apr']) ? $user_records_by_months['Apr'] : 0,
            '4' => isset($user_records_by_months['May']) ? $user_records_by_months['May'] : 0,
            '5' => isset($user_records_by_months['Jun']) ? $user_records_by_months['Jun'] : 0,
            '6' => isset($user_records_by_months['Jul']) ? $user_records_by_months['Jul'] : 0,
            '7' => isset($user_records_by_months['Aug']) ? $user_records_by_months['Aug'] : 0,
            '8' => isset($user_records_by_months['Sep']) ? $user_records_by_months['Sep'] : 0,
            '9' => isset($user_records_by_months['Oct']) ? $user_records_by_months['Oct'] : 0,
            '10' => isset($user_records_by_months['Nov']) ? $user_records_by_months['Nov'] : 0,
            '11' => isset($user_records_by_months['Dec']) ? $user_records_by_months['Dec'] : 0,
        ];
        // dd($user_records, $video_records);


        // dd($video_records);
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
        // $video_id = base64_decode($id);
        $record = Video::find($id);
        $user = $record->user;
        $lat = $user->company->companyDetail->latitude;
        $lng = $user->company->companyDetail->longitude;
        $url = env('APP_IMAGE_URL') . 'video/' . $record->video;
        $url_thumbnail = env('APP_IMAGE_URL') . 'video/' . $record->thumbnail_image;
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

        // $speechClient = new SpeechClient([
        //     'keyFilePath' => 'AIzaSyCAdz2aB-ktO3eNQw9G-p_b1pKSpjhA4LA',
        //     // 'keyFilePath' => storage_path('path/to/your/service-account-key.json'),
        //     'languageCode' => 'en-US', // Adjust the language code as needed
        // ]);

        // // Replace 'path/to/your/video.mp4' with the actual path to your video file
        // $audioFile = storage_path('video/121681449215.mp4');
        // // $audioFile = storage_path('video/'.$record->video);

        // $config = [
        //     'encoding' => 'LINEAR16',
        //     'sampleRateHertz' => 16000,
        // ];

        // $audio = ['content' => file_get_contents($audioFile)];

        // $response = $speechClient->recognize($config, $audio);
        // $captions = [];

        // foreach ($response->getResults() as $result) {
        //     foreach ($result->getAlternatives() as $alternative) {
        //         $captions[] = $alternative->getTranscript();
        //     }
        // }

        // $recognitionConfig = new RecognitionConfig();
        // $recognitionConfig->setEncoding(AudioEncoding::FLAC);
        // $recognitionConfig->setSampleRateHertz(44100);
        // $recognitionConfig->setLanguageCode('en-US');
        // $config = new StreamingRecognitionConfig();
        // $config->setConfig($recognitionConfig);

        // $audioResource = $audioFile = storage_path('video/121681449215.mp4');;
        // dd($config,$audioResource);
        // $responses = $speechClient->recognizeAudioStream($config, $audioResource);

        // foreach ($responses as $element) {
        //     // doSomethingWith($element);
        // }
        // $this->notification('Video Created - Viewed', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $record);
        // Notification::create([
        //     'user_id' => $user->id,
        //     'video_id' => $record->id,
        //     'title' => 'Video Created - Viewed',
        //     'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
        // ]);
        return view('detail', get_defined_vars());
    }
    public function showVideoNotify($id)
    {
        $video_id = base64_decode($id);
        $record = Video::find($video_id);
        $user = $record->user;
        // $this->notification('Video Created - Viewed', $record->title . PHP_EOL . $record->created_at->format('M d Y'), $user, $record);
        Notification::create([
            'user_id' => $user->id,
            'video_id' => $record->id,
            'title' => 'Video Created - Viewed',
            'description' => $record->title . PHP_EOL . $record->created_at->format('M d Y'),
        ]);
    }
    public function musicReorder(Request $request)
    {
        // dd($request->all());
        $records = BackgroundMusic::all();
        foreach ($records as $record) {
            foreach ($request->order as $order) {
                if ($order['id'] == $record->id) {
                    $record->update(['order_sort' => $order['position']]);
                }
            }
        }
        return response(['message' => 'Update Successfully'], 200);
    }

    public function getImage($dir, $filename)
    {

        $path = storage_path("app/public/{$dir}/{$filename}");

        if (!Storage::exists("public/{$dir}/{$filename}")) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response()->make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
