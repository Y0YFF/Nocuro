<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkedSocialAccount extends Model
{
    protected $fillable = [
        'user_id',
        'provider_id',
        'provider_name',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
