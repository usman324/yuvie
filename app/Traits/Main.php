<?php

namespace App\Traits;

use App\Models\NoiseVideo;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserType;
use GuzzleHttp\Client;

trait Main
{
    public function sendNotification($title, $notification, $users, $record = null)
    {
        foreach ($users as $user) {

            $SERVER_API_KEY = config('app.firebase_key');
            if ($user->device_token != null) {
                // dd($user->device_token);
                $data = [
                    "to" => $user->device_token,
                    "notification" => [
                        "title" => $title,
                        "body" => $notification,
                        "id" => $record->id,
                        "status" => $record->status,
                        "sound" => 'default',
                        'vibrate' => 1,
                    ],

                ];
                $dataString = json_encode($data);
                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                $response = curl_exec($ch);
                Notification::create([
                    'user_id' => $user->id,
                    'video_id' => $record->id,
                    'title' => $title,
                    'description' => $notification,
                ]);
            }
        }
    }
    public function noiseReduction($video_name)
    {
        $backendUrl = "https://api.audo.ai/v1/remove-noise";
        $audoApiKey = config('app.noise_api_key');
        $client = new Client();
        $url = url('images/video/' . $video_name);
        // $url = "https://yuvie.bhattimobiles.com/storage/app/public/video/561711478098.mp4";
        // Make the HTTP POST request
        $response = $client->post($backendUrl, [
            'json' => [
                'input' => $url,
                'outputExtension' => 'mp4',
            ],
            'headers' => [
                'x-api-key' => $audoApiKey,
            ],
        ]);
        $video_name_after_noise = rand(10, 100) . time() . '.mp4';
        $json_response_video_upload = $response->getBody()->getContents();
        $job_id = json_decode($json_response_video_upload)->jobId;
        NoiseVideo::create([
            'job_id' => $job_id,
            'video_name' =>  $video_name_after_noise,
            'status' => 'pending',
        ]);
        return $video_name_after_noise;
    }
    public function notification($title, $body, $data, $video)
    {
        // dd($data);
        if ($data->device_token != null) {

            $SERVER_API_KEY = $SERVER_API_KEY = config('app.firebase_key');
            $data = [
                "to" => $data->device_token,
                "notification" => [
                    "title" => $title,
                    "body" => $body,
                    "id" => $video?->id,
                    "status" => $video?->status,
                    "sound" => 'default',
                    'vibrate' => 1,
                ],

            ];
            $dataString = json_encode($data);
            $headers = [
                'Authorization: key=' . $SERVER_API_KEY,
                'Content-Type: application/json',
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

            $response = curl_exec($ch);


            //  dd($response);
        }
    }
    public function allUsers($title, $users, $description)
    {
        foreach ($users as $user) {

            $SERVER_API_KEY = config('app.firebase_key');
            if ($user->device_token != null) {
                // dd($user->device_token);
                $data = [
                    "to" => $user->device_token,
                    "notification" => [
                        "title" => $title,
                        "body" => $description,
                        "sound" => 'default',
                        'vibrate' => 1,
                    ],

                ];
                $dataString = json_encode($data);
                $headers = [
                    'Authorization: key=' . $SERVER_API_KEY,
                    'Content-Type: application/json',
                ];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
                $response = curl_exec($ch);
                Notification::create([
                    'user_id' => $user->id,
                    'title' => $title,
                    'description' => $description,
                ]);
            }
        }
    }
}
