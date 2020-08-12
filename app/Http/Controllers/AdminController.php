<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PopularCourse;
use App\Http\Requests\PopularCourses\StoreRequest;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function index()
    {
        $popular_courses = PopularCourse::all();

        return view('admins.index', compact('popular_courses'));
    }

    public function addPopularCourse(StoreRequest $request)
    {
        PopularCourse::create([
            'course_id' => $request->id
        ]);

        notify()->success('人気のコースを追加しました', '成功');

        return redirect()->route('admins.index');
    }
}
