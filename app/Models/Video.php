<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_id',
        'video',
        'title',
        'description',
        'status',
        'type',
        'alpha',
        'thumbnail_image',
        'intro_video',
        'outer_video',
        'alpha',
    ];

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }
    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id')->withDefault();
    }
    public function videoView()
    {

        return $this->hasMany(VideoView::class);
    }
    public function videoShare()
    {

        return $this->hasMany(VideoShare::class);
    }

    public function scopeByUser($query, $id)
    {
        if (isset($id)) {
            return  $query->where('user_id', $id);
        }
        return $query;
    }
    public function scopeByRole($query, $role)
    {
        if (isset($role)) {
            return $query->whereHas('user', function ($query) use ($role) {
                // dd($role);
                $query->whereHas(
                    'roles',
                    function ($q) use ($role) {
                        return $q->whereIn('name', $role);
                    }
                );
            });
            // return  $query->where('user_id', $id);
        }
        // return $query;
    }
    public function totalCounts()
    {
        $total = 0;
        foreach ($this->videoView as $data) {
            $total += $data->total_counts;
        }
        return $total;
    }
    public function totalShareCounts()
    {
        $total = 0;
        foreach ($this->videoShare as $data) {
            $total += $data->total_counts;
        }
        return $total;
    }
    public function totalViewCounts()
    {
        $total = 0;
        foreach ($this->videoView as $data) {
            $total += $data->total_counts;
        }
        return $total;
    }
    public function scopeByUserFilter($query, $title)
    {
        // dd($title);
        if (isset($title)) {
            return  $query->where('title', 'LIKE', "%" . $title . "%");
        }
        return $query;
    }
    public function scopeByCompanyFilter($query, $title)
    {
        if (isset($title)) {
            return  $query->where('title', 'LIKE', "%" . $title . "%");
        }
        return $query;
    }
    public function scopeByTitle($query, $data)
    {
        if (isset($data)) {
            $query->orWhere('title', 'like', "%" . $data . "%")
                ->orWhere('description', 'like', "%" . $data . "%");
        }
        return $query;
    }
    public function scopeByDescription($query, $data)
    {
        if (isset($data)) {
            return  $query->where('description', 'like', "%" . $data . "%");
        }
        return $query;
    }
    public function getAttributeDescription($value)
    {
        return is_null($value) ? '' : $value;
    }
    public function scopeByCompany($query, $id)
    {
        if (isset($id)) {
            return  $query->where('company_id', $id);
        }
        return $query->whereHas('company', function ($q) {
            $q->where('name', 'YuVie');
            // $q->where('name', 'LIKE', "%" . 'YuVie' . "%");
        });
    }
}
