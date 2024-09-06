<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackgroundMusic;
use App\Models\Company;
use App\Models\FileManager;
use App\Models\Image;
use App\Traits\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class BackgroundMusicController extends Controller
{
    use Main;
    const TITLE = 'Background Music';
    const VIEW = 'admin/background_music';
    const URL = 'admin/background-musics';

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            'music_url' => env('APP_IMAGE_URL') . 'background-music',
        ]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $q_length = $request->length;
            $q_start = $request->start;
            $user = auth()->user();
            $records_q =  BackgroundMusic::byCompany($request->company);

            $total_records = $records_q->count();
            // if ($q_length > 0) {
            //     $records_q = $records_q->limit($q_start + $q_length);
            // }
            $records = $records_q->get()->sortBy('order_sort');
            return DataTables::of($records)
                ->addColumn('company', function ($record) {
                    return $record->company?->name;
                })->addColumn('audio', function ($record) {
                    $url = env('APP_IMAGE_URL') . 'background-music/' . $record->audio;
                    return "<audio controls> <source src='$url' type='audio/ogg'> </audio>";
                })
                ->addColumn('actions', function ($record) {
                    return view('admin.background_music.partial.actions', [
                        'record' => $record
                    ])->render();
                })
                ->rawColumns(['actions', 'audio'])
                ->setTotalRecords($total_records)
                ->make(true);
        } 
        $records = BackgroundMusic::byCompany($request->company)
            ->get()->sortBy('order_sort');
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
            // 'name' => 'required',
            'company_id' => 'required',
            // 'file_manager_id' => 'required',
            // 'audio' => 'required|file', 'mimes:mp3',
        ]);
        $audio = $request->audio;
        $audio_name = '';
        $file_name = '';
        if ($audio) {
            $name = rand(10, 100) . time() . '.' . $audio->getClientOriginalExtension();
            $file_name = $audio->getClientOriginalName();
            $audio->storeAs('public/background-music', $name);
            $audio_name = $name;
        }
        $image_ids = explode(',', $request->images);
        $records = Image::whereIn('id', $image_ids)->get();
        foreach ($records as $record) {
            $record = BackgroundMusic::create([
                'user_id' => Auth::id(),
                'company_id' => $request->company_id,
                // 'file_manager_id' => $request->file_manager_id,
                'name' => $record->file_name,
                'audio' => $record->image,
            ]);
        }
        // if ($request->images) {
        //     $image_ids = explode(',', $request->images);
        //     Image::whereIn('id', $image_ids)->update([
        //         'imageable_id' => $record->id,
        //     ]);
        // }
        return response()->json(['status' => true, 'message' => 'Background Music has been created successfully'], 200);
    }
    public function edit($id)
    {
        $companies = Company::all();
        $record = BackgroundMusic::find($id);
        $file_managers = FileManager::all();
        return view(self::VIEW . '.edit', get_defined_vars());
    }
    public function show($id)
    {
        $companies = Company::all();
        $record = BackgroundMusic::find($id);
        $file_managers = FileManager::all();
        return view(self::VIEW . '.show', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '1000M');
        // dd($request->all());
        $record = BackgroundMusic::find($id);
        $request->validate([
            // 'name' => 'required',
            'company_id' => 'required',
            // 'file_manager_id' => 'required',
            'audio' => 'nullable|file', 'mimes:mp3',
        ]);
        $audio = $request->audio;
        $audio_name = '';
        $file_name = '';
        if ($audio) {
            $name = rand(10, 100) . time() . '.' . $audio->getClientOriginalExtension();
            $file_name = $audio->getClientOriginalName();
            $audio->storeAs('public/background-music', $name);
            $audio_name = $name;
        }
        $record->update([
            'name' => $file_name ? $file_name : $record->name,
            // 'company_id' => $request->company_id ? $request->company_id : $record->company_id,
            'company_id' => $request->company_id,
            // 'file_manager_id' => $request->file_manager_id ? $request->file_manager_id : $record->file_manager_id,
            'audio' => $audio_name ? $audio_name : $record->audio,
        ]);
        // if ($request->images) {
        //     $image_ids = explode(',', $request->images);
        //     Image::whereIn('id', $image_ids)->update([
        //         'imageable_id' => $record->id,
        //     ]);
        // }
        return response()->json(['status' => true, 'message' => 'Background Music has been updated successfully'], 200);
    }
    public function destroy(Request $request, $id)
    {
        if ($request->file) {
            $image = Image::find($request->file);
            if ($image) {
                $image->delete();
                return 1;
            }
        } else {
            $record = BackgroundMusic::find($id);
            if ($record) {
                $record->delete();
                return 1;
            }
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
