<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaterMark extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_id',
        'video_watermark',
        'white_logo',
    ];
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }

    public function scopeByCompany($query, $id)
    {
        if (isset($id) && $id != 7) {
            return  $query->where('company_id', $id);
        }
        return  $query;
        // return $query->whereHas('company', function ($q) {
        //     $q->where('name', 'YuVie');
        //     // $q->where('name', 'LIKE', "%" . 'YuVie' . "%");
        // });
    }
}
