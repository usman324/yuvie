<?php

namespace App\Console;

use App\Models\NoiseVideo;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected $commands = [
        Commands\DeleteVideo::class,
    ];
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            $backendUrl = "https://api.audo.ai/v1";
            $audoApiKey = config('app.noise_api_key');
            $client = new Client();
            $noise_videos = NoiseVideo::where('status', 'pending')->get();
            foreach ($noise_videos as $noise_video) {
                $response_get_video_url = $client->get($backendUrl . '/' . 'remove-noise/' . $noise_video->job_id . '/status', [
                    'headers' => [
                        'x-api-key' => $audoApiKey,
                    ],
                ]);
                $json_response_video_upload_url = $response_get_video_url->getBody()->getContents();
                $response = json_decode($json_response_video_upload_url);
                $download_url = $backendUrl . $response->downloadPath;
                if ($response->state === 'succeeded') {
                    Storage::put('public/video/' . $noise_video->video_name, file_get_contents($download_url));
                    $noise_video->update(['status' => 'completed']);
                }
            }
        })->everyMinute();

        $schedule->command('delete:video')->twiceMonthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
