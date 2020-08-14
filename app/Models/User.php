<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'account_id', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'account_id';
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\LinkedSocialAccount');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Models\Course')->withPivot('checked_count');
    }

    public function bookmark_courses()
    {
        return $this->belongsToMany('App\Models\Course', 'bookmarks');
    }

    public function userinfo()
    {
        return $this->hasOne('App\Models\Userinfo');
    }

}
