<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Models\Video;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }
    public function login(Request $request)
    {
        $this->validateLogin($request);
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $user = User::where('email', $request->email)->first();
        if (!is_null($user) && $user?->getRoleNames()->first() == 'Mobile User' || $user?->getRoleNames()->first() == 'Manager' && $user->is_admin != true) {
            if ($this->attemptLogin($request)) {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }

                return $this->sendLoginResponse($request);
            }
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }
    protected function sendLoginResponse(Request $request)
    {
        if ($request->is('api/*') == false) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
        }

        if ($request->is('api/*')) {
            $this->attemptLogin($request);
            $companies = Company::with('companyDetail', 'companyBranding')->get();
            $user = auth()->user();
            $token = auth()->user()->createToken('Personal Access Token')->accessToken;
            // $user->update(['device_token' => $request->device_token ? $request->device_token : $user->device_token,
            // ]);
            $user_type = $user?->getRoleNames()->first();
            $pending_records=[];
            if ($user_type == 'Manager') {
                $videos = Video::where('company_id', $user->company_id)
                    ->where('user_id', '!=', $user->id)->where('status', 'pending')
                    ->orderBy('created_at', 'desc')
                    // ->paginate(20, ['*'], 'page', $request->company_counter)
                    ->get()
                    ->skip($request->company_counter ?? 0)
                    ->take($request->company_counter != null && $request->company_counter != 0 ? $request->company_counter : 5)
                    ->groupBy(function ($date) {
                        return Carbon::parse($date->created_at)->format('D d M');
                    });
                $compnay_counts = 0;
                foreach ($videos as $key => $datas) {
                    $now = Carbon::now();
                    $yesterday = Carbon::yesterday();
                    $compnay_counts += count($datas);
                    // $date_object = $now->format('D d M') == $key ? 'Today' : $key;
                    $date_object = '';
                    if ($now->format('D d M') == $key) {
                        $date_object = 'Today';
                    } elseif ($yesterday->format('D d M') == $key) {
                        $date_object = 'Yesterday';
                    } else {
                        $date_object = $key;
                    }
                    $videos_by_date = [
                        'date' => $date_object,
                    ];
                    foreach ($datas as $video) {
                        $record = [
                            'id' => $video->id,
                            'user' => [
                                "id" => $video->user->id,
                                "company_id" => $video->user->company_id,
                                "first_name" => isset($video->user->first_name) ? $video->user->first_name : '',
                                "last_name" => isset($video->user->last_name) ? $video->user->last_name : '',
                                "email" => isset($video->user->email) ? $video->user->email : '',
                                "image" => isset($video->user->image) ? $video->user->image : '',
                                "email_verified_at" => isset($video->user->email_verified_at) ? $video->user->email_verified_at : "",
                                "is_admin" => $video->user->is_admin,
                                "created_at" => $video->user->created_at,
                                "updated_at" => $video->user->updated_at,
                                "total_videos" => count($video->user->videos),

                            ],
                            "video_share_counts" => count($video->videoShare),
                            "video_view_counts" => count($video->videoView),
                            'company' => $video->company?->name,
                            'title' => $video->title,
                            'description' => $video->description,
                            'status' => $video->status,
                            'video' => env('APP_IMAGE_URL') . 'video/' . $video->video,
                            'share_link' => url('video/share/' . base64_encode($video->id)),

                        ];
                        $videos_by_date['video'][] = $record;
                    }

                    $pending_records[] = $videos_by_date;
                }
            } else {
                $pending_records=[];
            }
            $user['user_type'] = $user_type;
            $user['token'] = $token;
            if ($user->image) {
                $user['image'] = env('APP_IMAGE_URL') . 'user/' . $user->image;
            } else {
                $user['image'] = asset('theme/img/avatar.png');
            }
            $user['companies'] = $companies;

            $user['is_admin'] = $user->is_admin;
            $user['pending'] = $pending_records;


            return response()->json(['status' => true, 'message' => 'Login Successfully', 'data' => $user], 200);
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended($this->redirectPath());
    }
    public function adminlogin(Request $request)
    {
        $this->validateLogin($request);
        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        $user = User::where('email', $request->email)->first();
        if ($user?->is_admin == true) {
            if ($this->attemptLogin($request)) {
                if ($request->hasSession()) {
                    $request->session()->put('auth.password_confirmed_at', time());
                }
                return $this->adminSendLoginResponse($request);
            }
            $this->incrementLoginAttempts($request);
            return $this->sendFailedLoginResponse($request);
        } else {
            return $this->sendFailedLoginResponse($request);
        }
    }

    protected function adminSendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('admin/dashboard');
    }
    public function logout(Request $request)
    {
        if (!$request->header('Authorization')) {
            $this->guard()->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        if ($request->header('Authorization')) {

            if (!is_null(auth()->guard('api')->user())) {
                auth()->guard('api')->user()->token()->revoke();
            }
            return response()->json(['status' => true, 'message' => 'Logout Successfully'], 200);
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
