<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyBranding extends Model
{
    use HasFactory;

    protected $fillable=[
        'company_id',
        'profile_logo',
        'social_media_logo_small',
        'social_media_logo_large',
        'background_music',
        'video_watermark',
    ];
}
