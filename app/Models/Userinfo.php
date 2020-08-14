<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $fillable = [
        'user_id',
        'completed_course_count',
    ];

    protected $table = 'userinfo';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
