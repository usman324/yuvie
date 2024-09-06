<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\WaterMarkCollection;
use App\Models\BackgroundMusic;
use App\Models\Company;
use App\Models\FileManager;
use App\Models\WaterMark;
use App\Traits\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class WaterMarkController extends Controller
{
    use Main;
    const TITLE = 'Watermarks';
    const VIEW = 'admin/watermark';
    const URL = 'admin/watermarks';

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            'video_url' => env('APP_IMAGE_URL') . 'watermark',
        ]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $q_length = $request->length;
            $q_start = $request->start;
            $user = auth()->user();
            $records_q =  WaterMark::byCompany($request->company)
                ->latest();

            $total_records = $records_q->count();
            // if ($q_length > 0) {
            //     $records_q = $records_q->limit($q_start + $q_length);
            // }
            $records = $records_q->get();
            return DataTables::of($records)
                ->addColumn('company', function ($record) {
                    return $record->company?->name;
                })->addColumn('video_watermark', function ($record) {
                    $url = env('APP_IMAGE_URL') . 'watermark/' . $record->video_watermark;
                    return "<img  style='height: 70px !important' src='$url'>";
                })
                ->addColumn('actions', function ($record) {
                    return view('admin.layout.partials.actions', [
                        'record' => $record
                    ])->render();
                })
                ->rawColumns(['actions', 'video_watermark'])
                ->setTotalRecords($total_records)
                ->make(true);
        }
        // $records = WaterMark::byCompany($request->company)
        //     ->latest()->get();
        $companies = Company::all();

        $company = Company::where('name', 'YuVie')->first();
        return view(self::VIEW . '.index', get_defined_vars());
    }
    public function create(Request $request)
    {
        $companies = Company::all();
        return view(self::VIEW . '.create', get_defined_vars());
    }
    public function store(Request $request)
    {
        ini_set('memory_limit', '1000M');
        $request->validate([
            'company_id' => 'required',
            'video_watermark' => ['required', 'file', 'mimes:jpg,png'],
        ]);
        $video_watermark = $request->video_watermark;
        $video_watermark_name = '';
        if ($video_watermark) {
            $name = rand(10, 100) . time() . '.' . $video_watermark->getClientOriginalExtension();
            $video_watermark->storeAs('public/watermark', $name);
            $video_watermark_name = $name;
        }
        $white_logo = $request->white_logo;
        $white_logo_name = '';
        if ($white_logo) {
            $name = rand(10, 100) . time() . '.' . $white_logo->getClientOriginalExtension();
            $white_logo->storeAs('public/watermark', $name);
            $white_logo_name = $name;
        }
        WaterMark::create([
            'user_id' => Auth::id(),
            'company_id' => $request->company_id,
            'video_watermark' => $video_watermark_name ? $video_watermark_name : null,
            'white_logo' => $white_logo_name ? $white_logo_name : null,

        ]);
        return response()->json(['status' => true, 'message' => 'Watermark has been created successfully'], 200);
    }
    public function edit($id)
    {
        $companies = Company::all();
        $record = WaterMark::find($id);
        return view(self::VIEW . '.edit', get_defined_vars());
    }

    public function update(Request $request, $id)
    {
        ini_set('memory_limit', '1000M');
        // dd($request->all());
        $record = WaterMark::find($id);
        $request->validate([
            'company_id' => 'required',
            'video_watermark' => ['nullable', 'file', 'mimes:jpg,png'],
        ]);
        $video_watermark = $request->video_watermark;
        $video_watermark_name = '';
        if ($video_watermark) {
            $name = rand(10, 100) . time() . '.' . $video_watermark->getClientOriginalExtension();
            $video_watermark->storeAs('public/watermark', $name);
            $video_watermark_name = $name;
        }
        $white_logo = $request->white_logo;
        $white_logo_name = '';
        if ($white_logo) {
            $name = rand(10, 100) . time() . '.' . $white_logo->getClientOriginalExtension();
            $white_logo->storeAs('public/watermark', $name);
            $white_logo_name = $name;
        }
        $record->update([
            'company_id' => $request->company_id ? $request->company_id : $record->company_id,
            'video_watermark' => $video_watermark_name ? $video_watermark_name : $record->video_watermark,
            'white_logo' => $white_logo_name ? $white_logo_name : $record->white_logo_name,
        ]);
        return response()->json(['status' => true, 'message' => 'Watermark has been updated successfully'], 200);
    }
    public function destroy($id)
    {
        $record = WaterMark::find($id);
        if ($record) {
            $record->delete();
            return 1;
        }
    }
    public function getWatermark(Request $request)
    {
        return new WaterMarkCollection(
            WaterMark::byCompany($request->company_id)
                ->get(),
        );
    }
}
