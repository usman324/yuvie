<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StickerCollection;
use App\Models\Sticker;
use App\Models\WaterMark;
use Illuminate\Http\Request;

class StickerController extends Controller
{
    public function getCompanySticker(Request $request)
    {
        $request->validate([
            'company_id',
        ]);
        $records = Sticker::where('company_id', $request->company_id)
            ->get();

        return new StickerCollection($records);
    }
    public function getSticker(Request $request)
    {
        $records = Sticker::where('company_id', null)->get();
        return new StickerCollection($records);
    }
}
