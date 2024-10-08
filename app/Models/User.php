<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_id',
        'first_name',
        'last_name',
        'email',
        'is_admin',
        'image',
        'password',
        'device_token',
        'device_id',
        'color',
        'photo_remove',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Scope a query get user who have roles.
     *
     * @param Builder $query
     * @param string $role
     * @return Builder
     */
    public function scopeWhereRole(Builder $query, string $role): Builder
    {
        $query->whereHas(
            'roles',
            function ($q) use ($role) {
                return $q->where('name', $role);
            }
        );

        return $query;
    }
    public function company()
    {

        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function videos()
    {

        return $this->hasMany(Video::class);
    }
    public function approvedVideo()
    {

        return $this->hasMany(Video::class)->where('status', 'approve');
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
    // public function scopeByUser($query, $id)
    // {
    //     if (isset($id)) {
    //         return  $query->where('id', $id);
    //     }
    //     return $query;
    // }
}
