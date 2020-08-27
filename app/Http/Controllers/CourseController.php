<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Courses\StoreRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Bookmark;
use App\Models\LessonUser;
use App\Models\CourseUser;
use App\Services\CourseService;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->only(['create', 'store', 'edit', 'delete']);

        $this->middleware('auth:web')->only(['bookmark']);
    }

    public function index(Request $request, Course $course)
    {
        $word = $request->query('query');
        $tag = $request->query('tag');

        $word_flag = $request->has('query');
        $tag_flag = $request->has('tag');

        $courses = $course
        ->searchByWord($word_flag, $word)
        ->searchByTag($tag_flag, $tag)
        ->paginate(15);

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course, CourseService $courseService, Bookmark $bookmark, LessonUser $lessonUser)
    {
        $course->load(['tagged', 'lessons']);

        $web_auth_flag = Auth::guard('web')->check();

        $web_auth_id = $web_auth_flag ? Auth::guard('web')->id() : null;

        $bookmark_flag = $web_auth_flag ? $courseService->getBookmarkFlag($course->id, $web_auth_id, $bookmark) : false; 

        $checked_lessons_asso_array = $web_auth_flag ? $courseService->getCheckedLessonsAssociativeArray($course->id, $web_auth_id, $lessonUser) : [];

        $checked_lessons_array = $courseService->getCheckedLessonsArray($checked_lessons_asso_array);

        $checked_count = $web_auth_flag ? $courseService->getCheckCount($checked_lessons_array) : 0;

        $lessons_array = $web_auth_flag ? $courseService->getLessons($checked_lessons_array, $course->lessons) : [];

        $lessons = json_encode($lessons_array);

        return view('courses.show', compact('course', 'bookmark_flag', 'lessons', 'checked_count'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(StoreRequest $request)
    {
        $tags = explode(',', $request->tags);

        $course = Course::create([
            'title' => $request->course_title,
            'link' => $request->course_link,
        ]);

        $course->tag($tags);

        $lessons = [];

        for ($i=0; $i < count($request->lesson_title) ; $i++) { 
            $lesson = [
                'title' => $request->lesson_title[$i],
                'link' => $request->lesson_link[$i]
            ];

            array_push($lessons, $lesson);
        }

        $course->lessons()->createMany($lessons);

        notify()->success('コースを作成しました', '成功');

        return redirect()->route('admins.index');
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function delete(Request $request, Course $course)
    {
        $course->delete();

        Bookmark::where('course_id', $course->id)->delete();

        CourseUser::where('course_id', $course->id)->delete();

        LessonUser::where('course_id', $course->id)->delete();

        Lesson::where('course_id', $course->id)->delete();

        notify()->success('削除しました', '成功');

        return redirect()->route('courses.index');
    }

    public function bookmark(Request $request, Course $course)
    {
        $bookmark = Bookmark::where('course_id', $course->id)
        ->where('user_id', Auth::guard('web')->id())
        ->first();

        if ($bookmark) {

            $bookmark->delete();

            $bookmark_count = $course->bookmark_count - 1;

            $course->fill([
                'bookmark_count' => $bookmark_count
            ])->save();

            notify()->success('お気に入りを削除しました', '成功');

            return redirect()->route('courses.show', $course);
            

        } else {

            Bookmark::create([
                'course_id' => $course->id,
                'user_id' => Auth::guard('web')->id(),
            ]);

            $bookmark_count = $course->bookmark_count + 1;

            $course->fill([
                'bookmark_count' => $bookmark_count
            ])->save();

            notify()->success('お気に入りに追加しました', '成功');

            return redirect()->route('courses.show', $course);

        }

    }
}
