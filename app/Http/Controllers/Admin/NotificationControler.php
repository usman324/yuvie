<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use App\Traits\Main;
use Illuminate\Http\Request;

class NotificationControler extends Controller
{
    use Main;
    const TITLE = 'Notification';
    const VIEW = 'admin/notification';
    const URL = 'admin/notifications';


    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
        ]);
    }
    public function toString($value)
    {
        return '"' . (string)($value) . '"';
    }
    public function index(Request $request)
    {
        $companies=Company::all();
        return view(self::VIEW . '.index', get_defined_vars());
    }
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'company_id'=>'required',
            'description' => 'required',
        ]);
        $users = User::where('company_id', $request->company_id)->get();
        $this->allUsers($request->title, $users, $request->description);
        return response()->json(['status' => true, 'message' => 'Notification has been sent successfully'], 200);
    }
}
