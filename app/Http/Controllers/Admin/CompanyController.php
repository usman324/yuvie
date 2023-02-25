<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Company;
use App\Models\CompanyBranding;
use App\Models\CompanyDetail;
use App\Models\State;
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
        ]);
    }
    public function index(Request $request)
    {
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
            'background_music' => ['nullable', 'file', 'mimes:mp3'],
            'video' => 'nullable|file', 'mimes:mp4',
        ]);
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
        $video = $request->video;
        $video_name = '';
        if ($video) {
            $name = rand(10, 100) . time() . '.' . $video->getClientOriginalExtension();
            $video->storeAs('public/video', $name);
            $video_name = $name;
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
        if($video_name){
            Video::create([
                'user_id' => Auth::id(),
                'company_id' => $company->id,
                'title' => $request->title,
                'description' => $request->video_description,
                'type' => $request->type,
                'video' => $video_name ? $video_name : null,
            ]);
        }
        
        return response()->json(['status' => true, 'message' => 'Company Add Successfully'], 200);
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
            'description' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:companies,email,'.$id],
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
            'description' => $request->description ? $request->description : $record->description,
            'email' => $request->email ? $request->email : $record->email,
            'password' => $request->password ? Hash::make($request->password) : $record->password,
        ]);

        if (!is_null($record->companyDetail)) {
            $record->companyDetail->update(['company_location_state' => $request->company_location_state ? $request->company_location_state : $record?->companyDetail->company_location_state,
                'company_location_title' => $request->company_location_title?$request->company_location_title:$record?->companyDetail->company_location_title,
                'company_location_event' => $request->company_location_event ? $request->company_location_event : $record?->companyDetail->company_location_event,
                'company_group' => $request->company_group?$request->company_group:$record?->companyDetail->company_group,
                'latitude' => $request->latitude?$request->latitude:$record?->companyDetail->latitude,
                'longitude' => $request->longitude?$request->longitude:$record?->companyDetail->longitude,
                'address' => $request->address ? $request->address : $record?->companyDetail->address,
                'phone' => $request->phone?$request->phone:$record?->companyDetail->phone,
                'company_website_url' => $request->company_website_url?$request->company_website_url:$record?->companyDetail->company_website_url,
                'company_destination_url' => $request->company_destination_url?$request->company_destination_url:$record?->companyDetail->company_destination_url,
                'company_button_text' => $request->company_button_text?$request->company_button_text:$record?->companyDetail->company_button_text,
                'company_ftp_protocol' => $request->company_ftp_protocol?$request->company_ftp_protocol:$record?->companyDetail->company_ftp_protocol,
                'company_ftp_host' => $request->company_ftp_host?$request->company_ftp_host:$record?->companyDetail->company_ftp_host,
                'company_ftp_username' => $request->company_ftp_username?$request->company_ftp_username:$record?->companyDetail->company_ftp_username,
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
                'address' => $request->address ,
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
            $record->companyBranding->update(['profile_logo' => $profile_logo_name ? $profile_logo_name : $record?->companyBranding->profile_logo,
            'social_media_logo_small' => $social_media_logo_small_name ? $social_media_logo_small_name : $record?->companyBranding->social_media_logo_small,
            'social_media_logo_large' => $social_media_logo_large_name ? $social_media_logo_large_name : $record?->companyBranding->social_media_logo_large,
            'video_watermark' => $video_watermark_name ? $video_watermark_name : $record?->companyBranding->video_watermark,
            'background_music' => $background_music_name ? $background_music_name : $record?->companyBranding->background_music,
            ]);

        }else{
            CompanyBranding::create(['company_id' => $record->id,
            'profile_logo' => $profile_logo_name ? $profile_logo_name : null,
            'social_media_logo_small' => $social_media_logo_small_name ? $social_media_logo_small_name : null,
            'social_media_logo_large' => $social_media_logo_large_name ? $social_media_logo_large_name : null,
            'video_watermark' => $video_watermark_name ? $video_watermark_name : null,
            'background_music' => $background_music_name ? $background_music_name : null,
            ]);
        }
        return response()->json(['status' => true, 'message' => 'Company Update Successfully'], 200);
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
