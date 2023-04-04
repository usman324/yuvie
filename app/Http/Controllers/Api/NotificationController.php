<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getUserNotification(Request $request)
    {
        $records = [];
        $notifications = Notification::where('user_id', $request->user_id)
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
            foreach ($datas as $key => $notification) {
                $record = [
                    'id' => $notification->id,
                    'user' => $notification?->user,
                    'video' => [
                        'id' => $notification->id,
                        'company' => $notification->video->company?->name,
                        'title' => $notification?->video->title,
                        'description' => $notification?->video->description,
                        'status' => $notification?->video->status,
                        'video' => env('APP_IMAGE_URL') . 'video/' . $notification?->video->video,
                        'share_link' => url('video/share/' . base64_encode($notification?->video->id)),
                    ],
                    'title' => $notification->title,
                    'description' => $notification->description,
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
                    'message' => 'Notification Deleted Successfully',
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
