<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonUser extends Model
{
    protected $fillable = [
        'course_id',
        'lesson_id',
        'user_id'
    ];

    protected $table = 'lesson_user';

    public function scopeUserHasCheckedLessonsOnCourse($query, $course_id, $user_id)
    {
        return $query->where('course_id', $course_id)->where('user_id', $user_id);
    }

    public function scopeUserHasLessonOnLessonUser($query, $web_auth_id, $lesson_id)
    {
        return $query->where('user_id', $web_auth_id)->where('lesson_id', $lesson_id);
    }
}
