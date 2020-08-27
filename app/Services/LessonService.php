<?php

namespace App\Services;

use App\Models\CourseUser;
use App\Models\LessonUser;

class LessonService
{
	function updateCompletedCourseCount($before_progress, $after_progress, $user)
	{
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
		
		return;
	}

	public function updateOrCreate($course_user, $checked_count, $web_auth_id, $course_id)
	{
		if ($course_user) {

            $course_user->fill([
                'checked_count' => $checked_count
            ])->save();

        } else {

            CourseUser::create([
                'user_id' => $web_auth_id,
                'course_id' => $course_id,
                'checked_count' => $checked_count,
            ]);

		}
		
		return;
	}

	public function deleteOrCreateCheckedLesson($lesson, $course_id, $lesson_id, $web_auth_id)
	{
		if ($lesson) {

            $lesson->delete();

        } else {

            LessonUser::create([
                'course_id' => $course_id,
                'lesson_id' => $lesson_id,
                'user_id' => $web_auth_id
            ]);
            
		}
		
		return;
	}
}