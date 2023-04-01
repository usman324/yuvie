<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
class UserController extends Controller
{
    
    public function getUserNotification(Request $request)
    {
        $records=[];
        $notifications= Notification::where('user_id', $request->user_id)
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
                $record=[
                    'id'=>$notification->id,
                    'user' => $notification?->user,
                    'video' => $notification?->video,
                    'title' => $notification->title,
                    'description' => $notification->description,
                ];
                $notification_by_date['notification'][] = $record;
            }
            $records[] = $notification_by_date;
        }
        // dd($records);
        return response()->json(
            [
                'status' => true,
                'message' => 'Record Found',
                'data'=>$records,
            ],
            200
        );
        // return new NotificationCollection(
        //     Notification::where('user_id', $request->user_id)->get(),
        // );
    }
    public function profileUpdate(Request $request)
    {
        // dd($request->all());
        $image = $request->image;
        $image_name = '';
        if ($image) {
            $name = rand(10, 100) . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/user', $name);
            $image_name = $name;
        }
        $record=User::find($request->user_id);
        $record->update([
            'first_name'=>$request->first_name?$request->first_name:$record->first_name,
            'last_name'=>$request->last_name?$request->last_name:$record->last_name,
            'device_token'=>$request->device_token?$request->device_token:$record->device_token,
            'image'=>$image_name?$image_name:$record->image,
        ]);
        return response()->json(
            [
                'status' => true,
                'message' => 'Profile Update Successfully',
                'data'=>$record,
            ],
            200
        );
    }
    public function updateDeviceToken(Request $request)
    {
        $record=User::find($request->user_id);
        $record->update([
            'device_token'=>$request->device_token?$request->device_token:$record->device_token,
        ]);
        return response()->json(
            [
                'status' => true,
                'message' => 'Device Token Update Successfully',
                'data'=>$record,
            ],
            200
        );
    }
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'previous_password' => ['required'],
            'current_password' => 'required',
        ]);
        $record=User::find($request->user_id);
        if(Hash::check($request->previous_password, $record->password) == false){
            return response()->json(
                [
                    'status' => false,
                    'message' => 'The previous password is match not with old password',
                ],
                500
            );
        }else{
            $record->update(['password' => $request->current_password ? Hash::make($request->current_password) : $record->password,
            ]);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Password Update Successfully',
                    'data'=>$record,
                ],
                200
            );
        }
        
    }
}
