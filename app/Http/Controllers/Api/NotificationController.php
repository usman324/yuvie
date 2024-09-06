<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function getUserNotification(Request $request)
    {
        $records = [];
        $notifications = Notification::whereHas('video')->where('user_id', $request->user_id)
            ->orderBy('created_at', 'desc')->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('D d M');
            });
        foreach ($notifications as $key => $datas) {
            $now = Carbon::now();
            $yesterday = Carbon::yesterday();
            $date_object = '';
            if ($now->format('D d M') == $key) {
                $date_object = 'Today';
            } elseif ($yesterday->format('D d M') == $key) {
                $date_object = 'Yesterday';
            } else {
                $date_object = $key;
            }
            $notification_by_date = [
                'date' => $date_object,
            ];
            $datas->load('video');
            foreach ($datas as $key => $notification) {
              
                $record = [
                    'id' => $notification->id,
                    'user' => $notification?->user,
                    
                    'video' => !is_null($notification->video) ? [
                        'id' => $notification->video?->id,
                        'company' => $notification->video?->company?->name,
                        'video_title' => isset($notification->video?->title) ? $notification->video?->title: "",
                        'video_description' => isset( $notification->video?->description)?$notification->video?->description : "",
                        'status' => isset($notification->video?->status)?$notification->video?->status:"",
                        'video' => env('APP_IMAGE_URL') . 'video/' . $notification->video?->video,
                        'share_link' => url('video/share/' . base64_encode($notification->video?->id)),
                    ]:[],
                    'user' => [
                        "id" => $notification->user->id,
                        "company_id" => $notification?->user->company_id,
                        "first_name" => $notification?->user->first_name,
                        "color" => $notification?->user->color,
                        "last_name" => $notification?->user->last_name,
                        "email" => $notification?->user->email,
                        "image" => $notification?->user->image ? env('APP_IMAGE_URL') . 'user/' . $notification?->user->image : "",
                        "email_verified_at" => $notification?->user->email_verified_at,
                        "is_admin" => $notification?->user->is_admin,
                        "created_at" => $notification?->user->created_at,
                        "updated_at" => $notification?->user->updated_at,
                    ],
                    'title' => $notification->title,
                    'description' => str_replace("\n"," ", $notification->description),
                ];
                $notification_by_date['notification'][] = $record;
            }
            $records[] = $notification_by_date;
        }
        return response()->json(
            [
                'status' => true,
                'message' => 'Record Found',
                'data' => $records,
            ],
            200
        );
    }
    public function deleteNotification(Request $request)
    {
        $notification = Notification::find($request->notification_id);
        if ($notification) {
            $notification->delete();
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Notification has been deleted successfully',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'No Record Found',
                ],
                200
            );
        }
    }
}
