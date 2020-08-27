<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = [
        'course_id', 
        'user_id',
    ];

    public function scopeUserHasBookmarkOnCourse($query, $course_id, $user_id)
    {
        return $query->where('course_id', $course_id)
        ->where('user_id', $user_id);
    }

}
