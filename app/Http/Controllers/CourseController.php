<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Courses\StoreRequest;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Bookmark;
use App\Models\LessonUser;
use App\Models\CourseUser;
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
        $word = $request->get('query');
        $tag = $request->get('tag');

        if ($request->has('query')) {
            
            $courses = $course
            ->where('title', 'like', '%'.$word.'%')
            ->paginate(15);

        } elseif ($request->has('tag')) {

            $courses = $course->withAnyTag($tag)->paginate(15);

        } else {

            $courses = $course->paginate(15);

        }

        return view('courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load(['tagged', 'lessons']);

        $lessons = [];
        $checkedCount = 0;

        if (Auth::guard('web')->check()) {

            $bookmark = Bookmark::where('course_id', $course->id)
            ->where('user_id', Auth::guard('web')->id())
            ->first();

            if ($bookmark) {
                $bookmark_flag = true;
            } else {
                $bookmark_flag = false;
            }

            $lessons_array = LessonUser::where('course_id', $course->id)
            ->where('user_id', Auth::guard('web')->id())
            ->orderBy('lesson_id', 'asc')
            ->get('lesson_id')
            ->toArray();

            $checkedLessons = [];

            foreach($lessons_array as $lesson_array) {
                $checkedLessons[] = $lesson_array['lesson_id'];
            }

            foreach($course->lessons as $lesson) {

                if (in_array($lesson->id, $checkedLessons)) {

                    $checked_flag = true;
                    $checkedCount++;
                    
                } else {

                    $checked_flag = false;

                }

                $lesson = [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'link' => $lesson->link,
                    'checked' => $checked_flag,
                ];

                $lessons[] = $lesson;
            }

        } else {
            $bookmark_flag = false;
        }

        $lessons = json_encode($lessons);

        return view('courses.show', compact('course', 'bookmark_flag', 'lessons', 'checkedCount'));
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
