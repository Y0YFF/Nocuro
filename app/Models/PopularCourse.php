<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PopularCourse extends Model
{
    protected $fillable = [
        'course_id'
    ];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
