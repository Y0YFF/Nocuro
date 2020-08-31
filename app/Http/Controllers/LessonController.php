<?php

namespace App\Http\Controllers;

use App\Models\CourseUser;
use Illuminate\Http\Request;
use App\Models\LessonUser;
use App\Models\User;
use App\Services\LessonService;

class LessonController extends Controller
{
    public function check(Request $request, $lesson_id, User $userModel, LessonUser $lessonUserModel, CourseUser $courseUserModel, LessonService $lessonService)
    {
        $auth_id = $request->authId;
        $course_id = $request->courseId;
        $checked_count = $request->checkedCount;
        $before_progress = $request->beforeProgress;
        $after_progress = $request->afterProgress;

        $user = $userModel->where('id', $auth_id)->first();

        $lessonUser = $lessonUserModel->userHasLessonOnLessonUser($auth_id, $lesson_id)->first();

        $course_user = $courseUserModel->userHasCourseOnCourseUser($auth_id, $course_id)->first();

        $lessonService->updateCompletedCourseCount($before_progress, $after_progress, $user);

        $lessonService->updateOrCreate($course_user, $checked_count, $auth_id, $course_id);

        $lessonService->deleteOrCreateCheckedLesson($lessonUser, $course_id, $lesson_id, $auth_id);

        return response('check sucessful!', 200);

    }
}
