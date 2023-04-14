<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationCollection;
use App\Models\Company;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{


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
        $record = User::find($request->user_id);
        $record->update([
            'first_name' => $request->first_name ? $request->first_name : $record->first_name,
            'last_name' => $request->last_name ? $request->last_name : $record->last_name,
            'device_token' => $request->device_token ? $request->device_token : $record->device_token,
            'image' => $image_name ? $image_name : $record->image,
        ]);
        return response()->json(
            [
                'status' => true,
                'message' => 'Profile Update Successfully',
                'data' => $record,
            ],
            200
        );
    }
    public function profileUpdateByDeviceId(Request $request)
    {
        // dd($request->all());
        $image = $request->image;
        $image_name = '';
        if ($image) {
            $name = rand(10, 100) . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/user', $name);
            $image_name = $name;
        }
        try {
            $record = User::where('device_id', $request->device_id)->first();
            if (!is_null($record)) {
                $record->update([
                    'first_name' => $request->first_name ? $request->first_name : $record->first_name,
                    'last_name' => $request->last_name ? $request->last_name : $record->last_name,
                    'device_token' => $request->device_token ? $request->device_token : $record->device_token,
                    'image' => $image_name ? $image_name : $record->image,
                ]);
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Profile Update Successfully',
                        'data' => $record,
                    ],
                    200
                );
            } else {
                return response()->json(['status' => false, 'message' => 'User Not Found'], 500);
            }
        } catch (Exception $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $e,
                ],
                500
            );
        }
    }
    public function updateDeviceToken(Request $request)
    {
        $record = User::find($request->user_id);
        $record->update([
            'device_token' => $request->device_token ? $request->device_token : $record->device_token,
        ]);
        return response()->json(
            [
                'status' => true,
                'message' => 'Device Token Update Successfully',
                'data' => $record,
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
        $record = User::find($request->user_id);
        if (Hash::check($request->previous_password, $record->password) == false) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'The previous password is match not with old password',
                ],
                500
            );
        } else {
            $record->update([
                'password' => $request->current_password ? Hash::make($request->current_password) : $record->password,
            ]);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Password Update Successfully',
                    'data' => $record,
                ],
                200
            );
        }
    }
}
