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
    ];
}
