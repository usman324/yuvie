<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'company_id',
        'video',
        'title',
        'description',
        'status',
        'type',
        'thumbnail_image',
    ];

    public function user(){
        
        return $this->belongsTo(User::class, 'user_id');
    }
    public function company(){
        
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function videoView(){

        return $this->hasMany(VideoView::class);
    }
    public function videoShare(){

        return $this->hasMany(VideoShare::class);
    }
    public function totalCounts(){
        $total=0;
        foreach($this->videoView as $data){
            $total += $data->total_counts;
        }
        return $total;
    }
    public function totalShareCounts(){
        $total=0;
        foreach($this->videoShare as $data){
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
}
