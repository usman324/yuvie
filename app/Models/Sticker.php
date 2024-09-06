<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sticker extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'company_id',
        'image',
        'file_name',
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
        if (isset($id)) {
            return  $query->where('company_id', $id);
        }
        return  $query->where('company_id', null);
    }
}
