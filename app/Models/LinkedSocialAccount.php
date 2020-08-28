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

    public function scopeAppHasAccountOnProvider($query, $provider_name, $provider_id)
    {
        return $query
        ->where('provider_name', $provider_name)
        ->where('provider_id', $provider_id);
    }
}
