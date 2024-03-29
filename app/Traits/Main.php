<?php

namespace App\Traits;

use App\Models\Notification;
use App\Models\User;
use App\Models\UserType;

trait Main
{
    public function sendNotification($title, $notification, $users, $record = null)
    {
        foreach ($users as $user) {

            $SERVER_API_KEY = config('app.firebase_key');
            if ($user->device_token != null ) {
                // dd($user->device_token);
                $data = [
                    "to" => $user->device_token,
                    "notification" => [
                        "title" => $title,
                        "body" => $notification,
                        "id" => $record->id,
                        "status" => $record->status,
                        "sound"=> 'default',
                        'vibrate'=> 1,
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
    public function notification($title, $body, $data,$video)
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
                     "sound"=> 'default',
                     'vibrate'=> 1,
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
    public function allUsers($title,$users, $description)
    {
        foreach ($users as $user) {

            $SERVER_API_KEY = config('app.firebase_key');
            if ($user->device_token != null ) {
                // dd($user->device_token);
                $data = [
                    "to" => $user->device_token,
                    "notification" => [
                        "title" => $title,
                        "body" => $description,
                        "sound"=> 'default',
                        'vibrate'=> 1,
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
