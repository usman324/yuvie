<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BackgroundMusic;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanyBranding;
use App\Models\CompanyDetail;
use App\Models\Font;
use App\Models\State;
use App\Models\Sticker;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class CompanyController extends Controller
{
    const TITLE = 'Companies';
    const VIEW = 'admin/company';
    const URL = 'admin/companies';

    public function __construct()
    {
        view()->share([
            'url' => url(self::URL),
            'title' => self::TITLE,
            'image_url' => env('APP_IMAGE_URL') . 'company_branding',
            'video_url' => env('APP_IMAGE_URL') . 'video',
            'sticker_url' => env('APP_IMAGE_URL') . 'sticker',
            'music_url' => env('APP_IMAGE_URL') . 'background-music',
        ]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $q_length = $request->length;
            $q_start = $request->start;
            $user = auth()->user();
            $records_q = Company::latest();

            $total_records = $records_q->count();
            // if ($q_length > 0) {
            //     $records_q = $records_q->limit($q_start + $q_length);
            // }
            $records = $records_q->get();
            return DataTables::of($records)
                ->addColumn('state', function ($record) {
                    return $record->state?->name;
                })
                ->addColumn('actions', function ($record) {
                    return view('admin.layout.partials.actions', [
                        'record' => $record
                    ])->render();
                })
                ->rawColumns(['actions'])
                ->setTotalRecords($total_records)
                ->make(true);
        }
        $records = Company::all();

        return view(self::VIEW . '.index', get_defined_vars());
    }

    public function create()
    {
        $states = State::all();
        return view(self::VIEW . '.create', get_defined_vars());
    }
    public function getCities(Request $request)
    {
        $records = City::where('state_id', $request->state_id)->get();
        return view(self::VIEW . '.partial.city', get_defined_vars());
    }


    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'state_id' => 'required',
            'city_name' => 'required',
            // 'city_id' => 'required',
            'zip' => 'required',
            'description' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'profile_logo' => ['nullable', 'file', 'mimes:jpg,png'],
            'social_media_logo_small' => ['nullable', 'file', 'mimes:jpg,png'],
            'social_media_logo_large' => ['nullable', 'file', 'mimes:jpg,png'],
            'video_watermark' => ['nullable', 'file', 'mimes:jpg,png'],
            // 'background_music' => ['nullable', 'file', 'mimes:mp3'],
            'audio' => ['nullable', 'file', 'mimes:mp3'],
            'video' => 'nullable|file', 'mimes:mp4',
            'outer_video' => 'nullable|file', 'mimes:mp4',
            'intro_video' => 'nullable|file', 'mimes:mp4',
            'font' => 'nullable|file|mimes:ttf,eot,otf,woff,woff2',
        ]);
        $profile_logo = $request->profile_logo;
        $sticker_image = $request->sticker_image;
        $social_media_logo_small = $request->social_media_logo_small;
        $social_media_logo_large = $request->social_media_logo_large;
        $video_watermark = $request->video_watermark;
        $background_music = $request->background_music;
        $font = $request->font;
        $audio = $request->audio;
        $profile_logo_name = "";
        $social_media_logo_small_name = "";
        $social_media_logo_large_name = "";
        $video_watermark_name = "";
        $background_music_name = "";
        $sticker_image_name = "";
        $sticker_file_name = "";
        $font_file_name = "";
        $font_image_name = "";
        $audio_file_name = "";
        $audio_image_name = "";

        if ($sticker_image) {
            $name = rand(10, 100) . time() . '.' . $sticker_image->getClientOriginalExtension();
            $sticker_image->storeAs('public/sticker', $name);
            $sticker_file_name = $sticker_image->getClientOriginalName();
            $sticker_image_name = $name;
        }
        if ($font) {
            $name = rand(10, 100) . time() . '.' . $font->getClientOriginalExtension();
            $font->storeAs('public/font', $name);
            $font_file_name = $font->getClientOriginalName();
            $font_image_name = $name;
        }
        if ($audio) {
            $name = rand(10, 100) . time() . '.' . $audio->getClientOriginalExtension();
            $audio->storeAs('public/background-music', $name);
            $audio_file_name = $audio->getClientOriginalName();
            $audio_image_name = $name;
        }
        if ($profile_logo) {
            $name = rand(10, 100) . time() . '.' . $profile_logo->getClientOriginalExtension();
            $profile_logo->storeAs('public/company_branding', $name);
            $profile_logo_name = $name;
        }
        if ($social_media_logo_small) {
            $name = rand(10, 100) . time() . '.' . $social_media_logo_small->getClientOriginalExtension();
            $social_media_logo_small->storeAs('public/company_branding', $name);
            $social_media_logo_small_name = $name;
        }
        if ($social_media_logo_large) {
            $name = rand(10, 100) . time() . '.' . $social_media_logo_large->getClientOriginalExtension();
            $social_media_logo_large->storeAs('public/company_branding', $name);
            $social_media_logo_large_name = $name;
        }
        if ($video_watermark) {
            $name = rand(10, 100) . time() . '.' . $video_watermark->getClientOriginalExtension();
            $video_watermark->storeAs('public/company_branding', $name);
            $video_watermark_name = $name;
        }
        if ($background_music) {
            $name = rand(10, 100) . time() . '.' . $background_music->getClientOriginalExtension();
            $background_music->storeAs('public/company_branding', $name);
            $background_music_name = $name;
        }
        $video = $request->video;
        $video_name = '';
        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
        }
        $outer_video = $request->outer_video;
        $outer_video_name = '';
        if ($outer_video) {
            $name = rand(10, 100) . time() . '.' . $outer_video->getClientOriginalExtension();
            $outer_video->storeAs('public/video', $name);
            $outer_video_name = $name;
        }
        $intro_video = $request->intro_video;
        $intro_video_name = '';
        $intro_video_name_after_noise = '';
        if ($intro_video) {
            $name = rand(10, 100) . time() . '.' . $intro_video->getClientOriginalExtension();
            $intro_video->storeAs('public/video', $name);
            $intro_video_name = $name;
            // $response = $this->noiseReduction($intro_video_name);
            // $intro_video_name_after_noise = $response;
        }
        $company = Company::create([
            'name' => $request->name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'state_id' => $request->state_id,
            'city_name' => $request->city_name,
            'zip' => $request->zip,
            'email' => $request->email,
            'description' => $request->description,
            'password' => Hash::make($request->password),
        ]);

        CompanyDetail::create([
            'company_id' => $company->id,
            'company_location_state' => $request->company_location_state,
            'company_location_title' => $request->company_location_title,
            'company_location_event' => $request->company_location_event,
            'company_group' => $request->company_group,
            'phone' => $request->phone,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'company_website_url' => $request->company_website_url,
            'company_destination_url' => $request->company_destination_url,
            'company_button_text' => $request->company_button_text,
            'company_ftp_protocol' => $request->company_ftp_protocol,
            'company_ftp_host' => $request->company_ftp_host,
            'company_ftp_username' => $request->company_ftp_username,
            'company_ftp_password' => Hash::make($request->company_ftp_password),
            'company_ftp_directory' => $request->company_ftp_directory,
        ]);
        CompanyBranding::create([
            'company_id' => $company->id,
            'profile_logo' => $profile_logo_name ? $profile_logo_name : null,
            'social_media_logo_small' => $social_media_logo_small_name ? $social_media_logo_small_name : null,
            'social_media_logo_large' => $social_media_logo_large_name ? $social_media_logo_large_name : null,
            'video_watermark' => $video_watermark_name ? $video_watermark_name : null,
            'background_music' => $background_music_name ? $background_music_name : null,
        ]);
        if ($intro_video_name) {
            Video::create([
                'user_id' => Auth::id(),
                'company_id' => $company->id,
                'title' => $request->title,
                'description' => $request->video_description,
                'type' => $request->type,
                'alpha' => is_null($request->alpha) ? 0 : 1,
                'video' => $video_name ? $video_name : null,
                'outer_video' => $outer_video_name ? $outer_video_name : null,
                // 'intro_video' => $intro_video_name_after_noise ? $intro_video_name_after_noise : null,
                'intro_video' => $intro_video_name ? $intro_video_name : null,
            ]);
        }
        if ($sticker_image_name) {
            Sticker::create([
                'user_id' => Auth::id(),
                'company_id' => $company->id,
                'file_name' => $sticker_file_name,
                'image' => $sticker_image_name,
            ]);
        }
        if ($font_image_name) {
            Font::create([
                'user_id' => Auth::id(),
                'company_id' => $company->id,
                'file_name' => $request->font_name,
                // 'file_name' => $font_file_name,
                'image' => $font_image_name,
            ]);
        }
        if ($audio_image_name) {
            BackgroundMusic::create([
                'user_id' => Auth::id(),
                'company_id' => $company->id,
                'name' => $audio_file_name,
                'image' => $audio_image_name,
            ]);
        }

        return response()->json(['status' => true, 'message' => 'Company has been created successfully'], 200);
    }
    public function edit($id)
    {
        $record = Company::find($id);
        $states = State::all();
        $cities = City::where('state_id', $record->state_id)->get();
        return view(self::VIEW . '.edit', get_defined_vars());
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'state_id' => 'required',
            // 'city_id' => 'required',
            'city_name' => 'required',
            'zip' => 'required',
            // 'description' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email,' . $id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'profile_logo' => ['nullable', 'file', 'mimes:jpg,png'],
            'social_media_logo_small' => ['nullable', 'file', 'mimes:jpg,png'],
            'social_media_logo_large' => ['nullable', 'file', 'mimes:jpg,png'],
            'video_watermark' => ['nullable', 'file', 'mimes:jpg,png'],
            'background_music' => ['nullable', 'file', 'mimes:mp3'],
        ]);
        $record = Company::find($id);
        $profile_logo = $request->profile_logo;
        $social_media_logo_small = $request->social_media_logo_small;
        $social_media_logo_large = $request->social_media_logo_large;
        $video_watermark = $request->video_watermark;
        $background_music = $request->background_music;
        $profile_logo_name = "";
        $social_media_logo_small_name = "";
        $social_media_logo_large_name = "";
        $video_watermark_name = "";
        $background_music_name = "";

        if ($profile_logo) {
            $name = rand(10, 100) . time() . '.' . $profile_logo->getClientOriginalExtension();
            $profile_logo->storeAs('public/company_branding', $name);
            $profile_logo_name = $name;
        }
        if ($social_media_logo_small) {
            $name = rand(10, 100) . time() . '.' . $social_media_logo_small->getClientOriginalExtension();
            $social_media_logo_small->storeAs('public/company_branding', $name);
            $social_media_logo_small_name = $name;
        }
        if ($social_media_logo_large) {
            $name = rand(10, 100) . time() . '.' . $social_media_logo_large->getClientOriginalExtension();
            $social_media_logo_large->storeAs('public/company_branding', $name);
            $social_media_logo_large_name = $name;
        }
        if ($video_watermark) {
            $name = rand(10, 100) . time() . '.' . $video_watermark->getClientOriginalExtension();
            $video_watermark->storeAs('public/company_branding', $name);
            $video_watermark_name = $name;
        }
        if ($background_music) {
            $name = rand(10, 100) . time() . '.' . $background_music->getClientOriginalExtension();
            $background_music->storeAs('public/company_branding', $name);
            $background_music_name = $name;
        }
        $record->update([
            'name' => $request->name ? $request->name : $record->name,
            'first_name' => $request->first_name ? $request->first_name : $record->first_name,
            'last_name' => $request->last_name ? $request->last_name : $record->last_name,
            'state_id' => $request->state_id ? $request->state_id : $record->state_id,
            'city_name' => $request->city_name ? $request->city_name : $record->city_name,
            // 'city_id' => $request->city_id ? $request->city_id : $record->city_id,
            'zip' => $request->zip ? $request->zip : $record->zip,
            'description' => $request->description,
            'email' => $request->email ? $request->email : $record->email,
            'password' => $request->password ? Hash::make($request->password) : $record->password,
        ]);

        if (!is_null($record->companyDetail)) {
            $record->companyDetail->update([
                'company_location_state' => $request->company_location_state ? $request->company_location_state : $record?->companyDetail->company_location_state,
                'company_location_title' => $request->company_location_title ? $request->company_location_title : $record?->companyDetail->company_location_title,
                'company_location_event' => $request->company_location_event ? $request->company_location_event : $record?->companyDetail->company_location_event,
                'company_group' => $request->company_group ? $request->company_group : $record?->companyDetail->company_group,
                'latitude' => $request->latitude ? $request->latitude : $record?->companyDetail->latitude,
                'longitude' => $request->longitude ? $request->longitude : $record?->companyDetail->longitude,
                'address' => $request->address ? $request->address : $record?->companyDetail->address,
                'phone' => $request->phone ? $request->phone : $record?->companyDetail->phone,
                'company_website_url' => $request->company_website_url ? $request->company_website_url : $record?->companyDetail->company_website_url,
                'company_destination_url' => $request->company_destination_url ? $request->company_destination_url : $record?->companyDetail->company_destination_url,
                'company_button_text' => $request->company_button_text ? $request->company_button_text : $record?->companyDetail->company_button_text,
                'company_ftp_protocol' => $request->company_ftp_protocol ? $request->company_ftp_protocol : $record?->companyDetail->company_ftp_protocol,
                'company_ftp_host' => $request->company_ftp_host ? $request->company_ftp_host : $record?->companyDetail->company_ftp_host,
                'company_ftp_username' => $request->company_ftp_username ? $request->company_ftp_username : $record?->companyDetail->company_ftp_username,
                'company_ftp_password' => $request->company_ftp_password ? Hash::make($request->company_ftp_password) : $record?->companyDetail->company_ftp_password,
                'company_ftp_directory' => $request->company_ftp_directory ? $request->company_ftp_directory : $record?->companyDetail->company_ftp_directory,
            ]);
        } else {
            CompanyDetail::create([
                'company_id' => $record->id,
                'company_location_state' => $request->company_location_state,
                'company_location_title' => $request->company_location_title,
                'company_location_event' => $request->company_location_event,
                'company_group' => $request->company_group,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'address' => $request->address,
                'phone' => $request->phone,
                'company_website_url' => $request->company_website_url,
                'company_destination_url' => $request->company_destination_url,
                'company_button_text' => $request->company_button_text,
                'company_ftp_protocol' => $request->company_ftp_protocol,
                'company_ftp_host' => $request->company_ftp_host,
                'company_ftp_username' => $request->company_ftp_username,
                'company_ftp_password' => Hash::make($request->company_ftp_password),
                'company_ftp_directory' => $request->company_ftp_directory,
            ]);
        }
        if (!is_null($record->companyBranding)) {
            $record->companyBranding->update([
                'profile_logo' => $profile_logo_name ? $profile_logo_name : $record?->companyBranding->profile_logo,
                'social_media_logo_small' => $social_media_logo_small_name ? $social_media_logo_small_name : $record?->companyBranding->social_media_logo_small,
                'social_media_logo_large' => $social_media_logo_large_name ? $social_media_logo_large_name : $record?->companyBranding->social_media_logo_large,
                'video_watermark' => $video_watermark_name ? $video_watermark_name : $record?->companyBranding->video_watermark,
                'background_music' => $background_music_name ? $background_music_name : $record?->companyBranding->background_music,
            ]);
        } else {
            CompanyBranding::create([
                'company_id' => $record->id,
                'profile_logo' => $profile_logo_name ? $profile_logo_name : null,
                'social_media_logo_small' => $social_media_logo_small_name ? $social_media_logo_small_name : null,
                'social_media_logo_large' => $social_media_logo_large_name ? $social_media_logo_large_name : null,
                'video_watermark' => $video_watermark_name ? $video_watermark_name : null,
                'background_music' => $background_music_name ? $background_music_name : null,
            ]);
        }
        return response()->json(['status' => true, 'message' => 'Company has been updated successfully'], 200);
    }
    public function destroy($id)
    {
        $record = Company::find($id);
        if ($record) {
            $record->delete();
            return 1;
        }
    }
}
