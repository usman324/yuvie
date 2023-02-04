<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable=[
        'state_id',
        'city_id',
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'zip',
        'description',
    ];
    public function companyDetail(){
        return $this->hasOne(CompanyDetail::class,'company_id');
    }
    public function companyBranding()
    {
        return $this->hasOne(CompanyBranding::class, 'company_id');
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
