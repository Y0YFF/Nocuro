<?php

namespace Tests\Feature\Models;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Coursetest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    const CHECKED_LESSONS_COUNT = 5;

    const LESSONS_COUNT = 10;

    protected function setUp(): void
    {
        parent::setUp();

    }

    /**
     * @test
     */
    // public function progressの算出()
    // {
    //     $progress = $this->course->progress;

    //     $expected_progress = intval(floor((self::CHECKED_LESSONS_COUNT / self::LESSONS_COUNT) * 100));

    //     $this->assertSame($expected_progress, $progress);
    // }

    /**
     * @test
     */
    public function ワードでの検索()
    {
        $prefix_title = $this->faker->word;
        $suffix_title = $this->faker->word;
        $search_word = $this->faker->word;
        $title = $prefix_title . $search_word . $suffix_title;

        $course = factory(Course::class)->create([
            'title' => $title
        ]);

        $result = $course->searchByWord(true, $search_word)->first();

        $this->assertSame($title, $result->title);
    }

    /**
     * @test
     */
    public function タグでの検索()
    {
        $tag = $this->faker->word;

        $course = factory(Course::class)->create();

        $course->tag($tag);

        $actual_tag = $course->tags->first()->slug;

        $this->assertSame($tag, $actual_tag);

    }
}
