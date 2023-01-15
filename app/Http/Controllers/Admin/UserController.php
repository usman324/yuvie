<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
class UserController extends Controller
{
    const TITLE = 'Users';
    const VIEW = 'admin/user';
    const URL = 'admin/users';


    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            // 'image_url' => env('APP_IMAGE_URL') . 'class',
        ]);
    }
    public function toString($value)
    {
        return '"' . (string)($value) . '"';
    }
    public function index(Request $request)
    {
            $records = User::whereIsAdmin(false)->get();
                
        return view(self::VIEW . '.index', get_defined_vars());
    }

   
    public function create()
    {
        return view(self::VIEW . '.create', get_defined_vars());
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user=User::create([
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'email'=>$request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->roles()->attach(2);
        return response()->json(
            [
                'success' => true,
                'message' => 'User Add Successfully'
            ],
            200
        );
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $record=User::find($id);
        return view(self::VIEW . '.edit', get_defined_vars());
    }

   
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'first_name' => 'required|string|min:2|max:200',
            'last_name' => 'required|string|min:2|max:200',
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users',
        ]);
        $record=User::find($id);
        $record->update([
            'first_name'=>$request->first_name?$request->first_name:$record->first_name,
            'last_name'=>$request->last_name?$request->last_name:$record->last_name,
            'email' => $request->email ? $request->email : $record->email,
            'password' => $request->password ? Hash::make($request->password) : $record->password,
        ]);
        return response()->json(
            [
                'success' => true,
                'message' => 'User Update Successfully'
            ],
            200
        );
    }

   
    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return 1;
        }
    }
}
