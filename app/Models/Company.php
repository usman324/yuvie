<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'state_id',
        'city_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'zip',
        'city_name',
        'description',
    ];
    public function companyDetail()
    {
        return $this->hasOne(CompanyDetail::class, 'company_id');
    }
    public function companyBranding()
    {
        return $this->hasOne(CompanyBranding::class, 'company_id');
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    public function stickers()
    {
        return $this->hasMany(Sticker::class);
    }
    public function fonts()
    {
        return $this->hasMany(Font::class);
    }
    public function backgroundMusics()
    {
        return $this->hasMany(BackgroundMusic::class);
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
    public function getDescriptionAttribute($value)
    {
        return is_null($value) ? '' : $value;
    }

    public function companyWaterMark()
    {
        return $this->hasMany(WaterMark::class)->first();
    }
    public function getLogo()
    {
        return $this?->companyWaterMark()?->video_watermark;
    }
}
