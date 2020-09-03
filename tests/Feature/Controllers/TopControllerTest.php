<?php

namespace Tests\Feature\Controllers;

use App\Models\Course;
use App\Models\PopularCourse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $popular_courses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->popular_courses = factory(Course::class, 20)
        ->create()
        ->each(function ($popular_course) {
            $popular_course->popular_course()->save(factory(PopularCourse::class)->make());
        });
    }

    /**
     * @test
     */
    public function トップページにアクセスしたら表示する()
    {
        $url = route('top');

        $popular_courses = PopularCourse::all();

        $response = $this->get($url);

        $response->assertStatus(200);

    }
}
