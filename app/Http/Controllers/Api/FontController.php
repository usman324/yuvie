<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FontCollection;
use App\Http\Resources\FontResource;
use App\Http\Resources\StickerCollection;
use App\Models\Font;
use App\Models\Sticker;
use App\Models\WaterMark;
use Illuminate\Http\Request;

class FontController extends Controller
{
    public function getFont(Request $request)
    {
        // $request->validate([
        //     'company_id',
        // ]);
        $records = Font::when($request->company_id, function ($query) use ($request) {
            $query->where('company_id', $request->company_id);
        })->where('company_id', '!=', null)
            ->get();
        $menu_records = Font::where('company_id', null)
            ->get();
        $music_records = [
            'menu_fonts' => [],
            'company_fonts' => [],
        ];
        foreach ($menu_records as  $data) {
            $music_records['menu_fonts'][] = [
                'id' => $data->id,
                'name' => $data->file_name ? $data->file_name : '',
                'company' => $data?->company?->name ? $data?->company?->name : '',
                'font' => $data->image ? env('APP_IMAGE_URL') . 'font/' . $data->image : '',
            ];
        }
        foreach ($records as  $company_record) {
            $music_records['company_fonts'][] = [
                'id' => $company_record->id,
                'name' => $company_record->file_name ? $company_record->file_name : '',
                'company' => $company_record?->company?->name ? $company_record?->company_record?->name : '',
                'font' => $company_record->image ? env('APP_IMAGE_URL') . 'font/' . $company_record->image : '',
            ];
        }
        return response()->json(['status' => true, 'message' => 'Record Found', 'data' => $music_records]);
    }
    public function getCompanyFont(Request $request)
    {
        $records = Font::where('company_id', $request->company_id)->get();
        return new FontCollection($records);
    }
}
