<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class CourseUser extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
        'checked_count',
    ];

    protected $table = 'course_user';

    public function scopeUserHasCourseOnCourseUser($query, $web_auth_id, $course_id)
    {
        return $query->where('user_id', $web_auth_id)->where('course_id', $course_id);
    }
}
