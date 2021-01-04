<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'role_id',
        'email',
        'userable_id',
        'userable_type',
        'fcm_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'fcm_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $with = ['userable'];

    public function userable()
    {
        return $this->morphTo();
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function forum()
    {
        return $this->hasMany(Forum::class);
    }

    public function getUserRoleAttribute()
    {
        return $this->role->name;
    }

    public function getProfileNameAttribute()
    {
        if ($this->user_role == 'patient') return $this->userable->mother_name;

        return $this->userable->name;
    }

//    public function getHospitalIdAttribute()
//    {
//        return $this->userable->hospital_id;
//    }
}
