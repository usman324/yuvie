<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BackgroundMusic extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'user_id',
        'company_id',
        'file_manager_id',
        'audio',
        'name',
        'order_sort',
    ];
    public function user()
    {

        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    } 
    public function fileManager()
    {

        return $this->belongsTo(FileManager::class, 'file_manager_id')->withDefault();
    }
    public function scopeByCompany($query, $id)
    {
        if (isset($id)) {
            return  $query->where('company_id', $id);
        }
        // return $query->whereHas('company', function ($q) {
        //     $q->where('name', 'YuVie');
        //     // $q->where('name', 'LIKE', "%" . 'YuVie' . "%");
        // });
        return  $query->where('company_id', null);
    }
}
