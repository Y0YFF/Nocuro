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
        return $query->where('course_id', $course_id)
            ->where('user_id', $user_id);
    }
}
