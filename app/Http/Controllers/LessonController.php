<?php

namespace App\Http\Controllers;

use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Models\LessonUser;

class LessonController extends Controller
{
    public function check(Request $request, $lesson_id)
    {
        $auth_id = $request->authId;
        $course_id = $request->courseId;
        $progress = $request->progress;

        $lesson = LessonUser::where('user_id', $auth_id)
        ->where('lesson_id', $lesson_id)
        ->first();

        $course_user = CourseUser::where('user_id', $auth_id)
        ->where('course_id', $course_id)
        ->first();

        if ($course_user) {

            $course_user->fill([
                'progress' => $progress
            ])->save();

        } else {

            CourseUser::create([
                'user_id' => $auth_id,
                'course_id' => $course_id,
                'progress' => $progress,
            ]);

        }

        if ($lesson) {

            $lesson->delete();

        } else {

            LessonUser::create([
                'course_id' => $course_id,
                'lesson_id' => $lesson_id,
                'user_id' => $auth_id
            ]);
            
        }

        return response('check sucessful!', 200);

    }
}
