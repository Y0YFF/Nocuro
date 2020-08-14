<?php

namespace App\Http\Controllers;

use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Models\LessonUser;
use App\Models\User;

class LessonController extends Controller
{
    public function check(Request $request, $lesson_id)
    {
        $auth_id = $request->authId;
        $course_id = $request->courseId;
        $checked_count = $request->checkedCount;
        $before_progress = $request->beforeProgress;
        $after_progress = $request->afterProgress;

        $user = User::where('id', $auth_id)->first();

        $lesson = LessonUser::where('user_id', $auth_id)
        ->where('lesson_id', $lesson_id)
        ->first();

        $course_user = CourseUser::where('user_id', $auth_id)
        ->where('course_id', $course_id)
        ->first();

        if ($before_progress === 100) {

            $completed_course_count = $user->userinfo->completed_course_count - 1;

            $user->userinfo->fill([
                'completed_course_count' => $completed_course_count,
            ])->save();

        }

        if ($after_progress === 100) {

            $completed_course_count = $user->userinfo->completed_course_count + 1;

            $user->userinfo->fill([
                'completed_course_count' => $completed_course_count,
            ])->save();
            
        }

        if ($course_user) {

            $course_user->fill([
                'checked_count' => $checked_count
            ])->save();

        } else {

            CourseUser::create([
                'user_id' => $auth_id,
                'course_id' => $course_id,
                'checked_count' => $checked_count,
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
