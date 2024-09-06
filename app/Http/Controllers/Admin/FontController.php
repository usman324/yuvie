<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackgroundMusic;
use App\Models\Company;
use App\Models\FileManager;
use App\Models\Image;
use App\Models\Font;
use App\Traits\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class FontController extends Controller
{
    use Main;
    const TITLE = 'Font';
    const VIEW = 'admin/font';
    const URL = 'admin/fonts';

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            'music_url' => env('APP_IMAGE_URL') . 'font',
        ]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $q_length = $request->length;
            $q_start = $request->start;
            $user = auth()->user();
            $records_q =  Font::byCompany($request->company)->latest();

            $total_records = $records_q->count();
            // if ($q_length > 0) {
            //     $records_q = $records_q->limit($q_start + $q_length);
            // }
            $records = $records_q->get()->sortBy('order_sort');
            return DataTables::of($records)
                ->addColumn('company', function ($record) {
                    return $record->company?->name;
                })->addColumn('image', function ($record) {
                    $url = env('APP_IMAGE_URL') . 'font/' . $record->image;
                    $file_name = $record->file_name;
                    // return $url;
                    return "<a href='$url'>$file_name</a>";
                })
                ->addColumn('actions', function ($record) {
                    return view('admin.sticker.partial.actions', [
                        'record' => $record
                    ])->render();
                })
                ->rawColumns(['actions', 'image'])
                ->setTotalRecords($total_records)
                ->make(true);
        }
        $records = Font::byCompany($request->company)->get()->sortBy('order_sort');
        $companies = Company::all();

        $company = Company::where('name', 'YuVie')->first();
        return view(self::VIEW . '.index', get_defined_vars());
    }
    public function create(Request $request)
    {
        $companies = Company::all();
        $file_managers = FileManager::all();
        return view(self::VIEW . '.create', get_defined_vars());
    }
    public function store(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            // 'file' => 'required|file|mimes:ttf,eot,otf,woff,woff2|ends_with:.ttf,.eot,.otf,.woff,.woff2',

            'file' => 'required',
            // 'image' => 'required|file|mimes:ttf,eot,otf,woff,woff2',
        ]);
        $image = $request->file;
        $image_name = '';
        $file_name = '';
        if ($image) {
            $name = rand(10, 100) . time() . '.' . $image->getClientOriginalExtension();
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/font', $name);
            $image_name = $name;
        }
        $record = Font::create([
            'user_id' => Auth::id(),
            'company_id' => $request->company_id,
            'file_name' => $request->name,
            // 'file_name' => $file_name,
            'image' => $image_name,
        ]);
        return response()->json(['status' => true, 'message' => 'Font has been created successfully'], 200);
    }
    public function edit($id)
    {
        $companies = Company::all();
        $record = Font::find($id);
        $file_managers = FileManager::all();
        return view(self::VIEW . '.edit', get_defined_vars());
    }
    public function show($id)
    {
        $companies = Company::all();
        $record = Font::find($id);
        $file_managers = FileManager::all();
        return view(self::VIEW . '.show', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '1000M');
        // dd($request->all());
        $request->validate([
            // 'file' => 'nullable|file|mimes:ttf,eot,otf,woff,woff2',
        ]);
        $record = Font::find($id);

        $image = $request->file;
        $image_name = '';
        $file_name = '';
        if ($image) {
            $name = rand(10, 100) . time() . '.' . $image->getClientOriginalExtension();
            $file_name = $image->getClientOriginalName();
            $image->storeAs('public/font', $name);
            $image_name = $name;
        }

        $record->update([
            // 'file_name' => $file_name ? $file_name : $record->file_name,
            'file_name' => $request->name,
            'company_id' => $request->company_id,
            // 'file_manager_id' => $request->file_manager_id ? $request->file_manager_id : $record->file_manager_id,
            'image' => $image_name ? $image_name : $record->image,
        ]);

        return response()->json(['status' => true, 'message' => 'Font has been updated successfully'], 200);
    }
    public function destroy(Request $request, $id)
    {

        $record = Font::find($id);
        if ($record) {
            $record->delete();
            return 1;
        }
    }

    public function backgroundMusic(Request $request)
    {
        $request->validate([
            'file' => 'mimes:mp3',
        ]);
        // dd($request->file);
        $image = $request->file;
        $name = rand(10, 100) . time() . '.' . $image->getClientOriginalExtension();
        $file_name = $image->getClientOriginalName();
        $image->storeAs('public/background-music', $name);
        $image_name = $name;
        // dd($file_name);
        $record = Image::saveImage([
            'image' => $image_name,
            'file_name' => $file_name,
            'imageable_type' => BackgroundMusic::class,
        ]);
        return response()->json([
            'message' => 'File Upload',
            'record' => $record,
        ]);
    }
}
