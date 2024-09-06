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

    public function getVideoWatermarkAttribute($value)
    {
        return is_null($value) ? '' : $value;
    }
    public function getSocialMediaLogoSmallAttribute($value)
    {
        return is_null($value) ? '' : $value;
    }

    public function getSocialMediaLogoLargeAttribute($value)
    {
        return is_null($value) ? '' : $value;
    }
     public function getBackgroundMusicAttribute($value)
    {
        return is_null($value) ? '' : $value;
    }
    public function getProfileLogoAttribute($value)
    {
        return is_null($value) ? '' : $value;
    }
}
