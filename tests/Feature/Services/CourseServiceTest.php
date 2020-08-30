<?php

namespace Tests\Feature\Services;

use App\Models\Bookmark;
use App\Models\Lesson;
use App\Models\LessonUser;
use App\Services\CourseService;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $course_service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->course_service = new CourseService;
    }

    /**
     * @test
     */
    public function コースをブックマークしている時trueフラグを返す()
    {
        $course_id = $this->faker->uuid;
        $user_id = $this->faker->randomDigit;

        $bookmark_model = factory(Bookmark::class)->create([
            'course_id' => $course_id,
            'user_id' => $user_id,
        ]);

        $flag = $this->course_service->getBookmarkFlag($course_id, $user_id, $bookmark_model);

        $this->assertTrue($flag);

    }

    /**
     * @test
     */
    public function コースをブックマークしていない時falseフラグを返す()
    {
        $course_id = $this->faker->uuid;
        $user_id = $this->faker->randomDigit;
        $got_user_id = $this->faker->randomDigitNot($user_id);

        $bookmark_model = factory(Bookmark::class)->create([
            'course_id' => $course_id,
            'user_id' => $user_id,
        ]);

        $flag = $this->course_service->getBookmarkFlag($course_id, $got_user_id, $bookmark_model);

        $this->assertFalse($flag);

    }

    /**
     * @test
     */
    public function 完了したレッスンの連想配列を得る()
    {
        $course_id = $this->faker->uuid;
        $user_id = $this->faker->randomDigit;

        $lesson_user_model = factory(LessonUser::class)->create([
            'course_id' => $course_id,
            'user_id' => $user_id,
        ]);

        $expected_asso_array = [
            ['lesson_id' => $lesson_user_model->lesson_id]
        ];

        $lesson_asso_array = $this->course_service->getCheckedLessonsAssociativeArray($course_id, $user_id, $lesson_user_model);

        $this->assertSame($expected_asso_array, $lesson_asso_array);
    }

    /**
     * @test
     */
    public function 完了したレッスンの数を得る()
    {
        $checked_lessons = [
            ['lesson_id' => $this->faker->randomDigit],
            ['lesson_id' => $this->faker->randomDigit],
            ['lesson_id' => $this->faker->randomDigit],
            ['lesson_id' => $this->faker->randomDigit],
        ];

        $expected_count = count($checked_lessons);

        $actual_count = $this->course_service->getCheckedCount($checked_lessons);

        $this->assertSame($expected_count, $actual_count);

    }

    /**
     * @test
     */
    public function 連想配列を配列化する()
    {
        $lesson_id_1 = $this->faker->randomDigit;
        $lesson_id_2 = $this->faker->randomDigit;
        $lesson_id_3 = $this->faker->randomDigit;
        $lesson_id_4 = $this->faker->randomDigit;

        $expected_array = [
            $lesson_id_1,
            $lesson_id_2,
            $lesson_id_3,
            $lesson_id_4
        ];

        $associative_array = [
            ['lesson_id' => $lesson_id_1],
            ['lesson_id' => $lesson_id_2],
            ['lesson_id' => $lesson_id_3],
            ['lesson_id' => $lesson_id_4],
        ];

        $actual_array = $this->course_service->getCheckedLessonsIdArray($associative_array);

        $this->assertSame($expected_array, $actual_array);
        
    }

    /**
     * @test
     */
    public function 完了または未完了のフラグを立てたレッスンの配列を得る()
    {
        $lessons = factory(Lesson::class, 5)->create();

        $checked_lessons_id_array = [
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
            $this->faker->randomDigit,
        ];

        $lesson_array = $this->course_service->getLessonsArray($checked_lessons_id_array, $lessons);

        $this->assertIsArray($lesson_array);
    }

    /**
     * @test
     */
    public function ブックマークの削除()
    {
        $bookmark_count = $this->faker->randomDigit;

        $course = factory(Course::class)->create([
            'bookmark_count' => $bookmark_count
        ]);

        $bookmark = factory(Bookmark::class)->create();

        $message = $this->course_service->deleteBookmark($bookmark, $course);

        $deleted_bookmark = Bookmark::where('id', $bookmark->id)->first();

        $this->assertSame($message, 'お気に入りを削除しました');

        $this->assertSame($course->bookmark_count, $bookmark_count - 1);

        $this->assertNull($deleted_bookmark);
    }

    /**
     * @test
     */
    public function ブックマークの追加()
    {
        $bookmark_count = $this->faker->randomDigit;

        $course = factory(Course::class)->create([
            'bookmark_count' => $bookmark_count,
        ]);

        $web_auth_id = $this->faker->randomDigit;

        $message = $this->course_service->createBookmark($web_auth_id, $course);

        $created_bookmark = Bookmark::where('course_id', $course->id)->where('user_id', $web_auth_id)->first();

        $this->assertSame($message, 'お気に入りに追加しました');

        $this->assertSame($course->bookmark_count, $bookmark_count + 1);

        $this->assertNotNull($created_bookmark);


    }
}
