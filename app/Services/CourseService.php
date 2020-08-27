<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\LessonUser;

class CourseService 
{
	function getBookmarkFlag($course_id, $user_id, Bookmark $bookmarkModel)
	{
		
		$bookmark = $bookmarkModel->userHasBookmarkOnCourse($course_id, $user_id)->first();

		$bookmark_flag = !empty($bookmark) ? true : false;
		
		return $bookmark_flag;

	}
	
	function getCheckedLessonsAssociativeArray($course_id, $user_id, LessonUser $lessonUserModel)
	{
		$lessons_asso_array = $lessonUserModel->userHasCheckedLessonsOnCourse($course_id, $user_id)
		->orderBy('lesson_id', 'asc')
		->get('lesson_id')
		->toArray();

		return $lessons_asso_array;

	}

	function getCheckCount($checked_lessons)
	{
		return count($checked_lessons);
	}

	function getCheckedLessonsArray($associative_array)
	{
		$checked_lessons_array = [];

		foreach($associative_array as $lesson_array) {
			$checked_lessons_array[] = $lesson_array['lesson_id'];
		}

		return $checked_lessons_array;
	}

	function getLessons($checked_lessons, $lessonsCollection)
	{
		$lessons_array = [];

		foreach($lessonsCollection as $lessonCollection) {

			if (in_array($lessonCollection->id, $checked_lessons)) {

				$checked_flag = true;
				
			} else {

				$checked_flag = false;

			}

			$lesson_array = [
				'id' => $lessonCollection->id,
				'title' => $lessonCollection->title,
				'link' => $lessonCollection->link,
				'checked' => $checked_flag,
			];

			$lessons_array[] = $lesson_array;
		}

		return $lessons_array;
	}

}