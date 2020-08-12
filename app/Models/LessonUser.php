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
}
