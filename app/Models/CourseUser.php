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
}
