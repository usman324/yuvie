<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
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
        ]);
    }
    public function toString($value)
    {
        return '"' . (string)($value) . '"';
    }
    // public function index(Request $request)
    // {
    //     $records = User::whereIsAdmin(false)
    //         ->byCompany($request->company)
    //         ->latest()->get();
    //     $companies = Company::all();
    //     $company = Company::where('name', 'YuVie')->first();
    //     return view(self::VIEW . '.index', get_defined_vars());
    // }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $q_length = $request->length;
            $q_start = $request->start;
            $user = auth()->user();
            $records_q = User::whereIsAdmin(false)
                ->byCompany($request->company);

            $total_records = $records_q->count();
            // if ($q_length > 0) {
            //     $records_q = $records_q->limit($q_start + $q_length);
            // }
            $records = $records_q->get();
            return DataTables::of($records)
                ->addColumn('country', function ($record) {
                    // return $record->country?->name;
                })->addColumn('image', function ($record) {
                    if ($record->image) {
                        $image = env('APP_IMAGE_URL') . 'user/' . $record->image;
                        return "<img src='$image' style='height:70px'>";
                    }
                    return '';
                })
                ->addColumn('actions', function ($record) {
                    return view('admin.layout.partials.actions', [
                        'record' => $record
                    ])->render();
                })
                ->rawColumns(['actions','image'])
                ->setTotalRecords($total_records)
                ->make(true);
        }
        $companies = Company::all();
        $company = Company::where('name', 'YuVie')->first();
        return view(self::VIEW . '.index', get_defined_vars());
    }

    public function create()
    {
        $companies = Company::all();
        return view(self::VIEW . '.create', get_defined_vars());
    }


    public function store(Request $request)
    {
        $request->validate([
            'company_id' => 'required',
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'user_type' => 'required',
        ]);

        $image = $request->image;
        $image_name = '';
        if ($image) {
            $name = rand(10, 100) . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/user', $name);
            $image_name = $name;
        }

        $user = User::create([
            'company_id' => $request->company_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $image_name,
        ]);
        $user->assignRole($request->user_type);
        return response()->json(
            [
                'success' => true,
                'message' => 'User has been created successfully'
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
        $record = User::find($id);
        $companies = Company::all();
        $roles = Role::where('name', '!=', 'Super Admin')->get();
        return view(self::VIEW . '.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'company_id' => 'required',
            'first_name' => 'required|string|min:2|max:200',
            'last_name' => 'required|string|min:2|max:200',
            'email' => 'required',
            'string',
            'email',
            'max:255',
            'unique:users',
            'user_type' => 'required',
        ]);
        $record = User::find($id);
        $record->removeRole($record->getRoleNames()->first());
        $image = $request->image;
        $image_name = '';
        if ($image) {
            $name = rand(10, 100) . time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/user', $name);
            $image_name = $name;
        }
        $record->update([
            'company_id' => $request->company_id ? $request->company_id : $record->company_id,
            'first_name' => $request->first_name ? $request->first_name : $record->first_name,
            'last_name' => $request->last_name ? $request->last_name : $record->last_name,
            'email' => $request->email ? $request->email : $record->email,
            'password' => $request->password ? Hash::make($request->password) : $record->password,
            'image' => $image_name ? $image_name : $record->image,
        ]);
        $record->assignRole($request->user_type);
        return response()->json(
            [
                'success' => true,
                'message' => 'User has been updated successfully'
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
