<?php

namespace App\Http\Controllers;

use App\Models\PopularCourse;

class TopController extends Controller
{
    public function __invoke()
    {
        $popular_courses = PopularCourse::all();

        return view('top', compact('popular_courses'));
    }
}
