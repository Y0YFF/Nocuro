<?php

namespace Tests\Feature\Services;

use App\Models\CourseUser;
use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\User;
use App\Models\Userinfo;
use App\Services\LessonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LessonServiceTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private $lesson_service;

    protected  function setUp(): void
    {
        parent::setUp();

        $this->lesson_service = new LessonService;
    }

    /**
     * @test
     */
    public function コースが修了から未修了に変わる時completed_course_countを1減らす()
    {
        $before_progress = 100;

        $after_progress = $this->faker->numberBetween(0, 99);

        $completed_course_count = $this->faker->randomDigitNot(0);

        $user = factory(User::class)->create();
        $userinfo = factory(Userinfo::class)->create([
            'user_id' => $user->id,
            'completed_course_count' => $completed_course_count,
        ]);

        $this->lesson_service->updateCompletedCourseCount($before_progress, $after_progress, $user);

        $this->assertSame($completed_course_count - 1, $user->userinfo->completed_course_count);

    }

    /**
     * @test
     */
    public function コースが未修了から修了に変わる時completed_course_countを1増やす()
    {
        $before_progress = $this->faker->numberBetween(0, 99);

        $after_progress = 100;

        $completed_course_count = $this->faker->randomDigit;

        $user = factory(User::class)->create();
        $userinfo = factory(Userinfo::class)->create([
            'user_id' => $user->id,
            'completed_course_count' => $completed_course_count,
        ]);

        $this->lesson_service->updateCompletedCourseCount($before_progress, $after_progress, $user);

        $this->assertSame($completed_course_count + 1, $user->userinfo->completed_course_count);

    }

    /**
     * @test
     */
    public function コースの完了したレッスンの数の更新()
    {
        $checked_count = $this->faker->randomDigit;

        $course_user = factory(CourseUser::class)->create();

        $this->lesson_service->updateOrCreate($course_user, $checked_count, $course_user->user_id, $course_user->course_id);

        $this->assertSame($checked_count, $course_user->checked_count);

    }

    /**
     * @test
     */
    public function コースを初めて完了した時にCourseUserモデルを作成()
    {
        $course_user = null;

        $checked_count = $this->faker->randomDigit;

        $web_auth_id = $this->faker->randomDigit;

        $course_id = $this->faker->uuid;

        $this->lesson_service->updateOrCreate($course_user, $checked_count, $web_auth_id, $course_id);

        $expected_course_user = factory(CourseUser::class)->create([
            'checked_count' => $checked_count,
            'user_id' => $web_auth_id,
            'course_id' => $course_id,
        ])->toArray();

        $this->assertDatabaseHas('course_user', $expected_course_user);
    }

    /**
     * @test
     */
    public function ユーザーの完了したレッスンの削除()
    {
        $lessonUser = factory(LessonUser::class)->create();

        $course_id = $this->faker->uuid;

        $lesson_id = $this->faker->randomDigit;

        $web_auth_id = $this->faker->randomDigit;

        $this->lesson_service->deleteOrCreateCheckedLesson($lessonUser, $course_id, $lesson_id, $web_auth_id);

        $this->assertDeleted('lesson_user', $lessonUser->toArray());
    }

    /**
     * @test
     */
    public function ユーザーがコースでは初めてレッスンを完了した時LessonUserモデルを作成()
    {
        $lessonUser = null;

        $course_id = $this->faker->uuid;

        $lesson_id = $this->faker->randomDigit;

        $web_auth_id = $this->faker->randomDigit;

        $this->lesson_service->deleteOrCreateCheckedLesson($lessonUser, $course_id, $lesson_id, $web_auth_id);

        $expected_lesson_user = factory(LessonUser::class)->create([
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'user_id' => $web_auth_id,
        ])->toArray();

        $this->assertDatabaseHas('lesson_user', $expected_lesson_user);

    }
}
