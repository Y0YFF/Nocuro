<?php

namespace Tests\Feature\Models;

use App\Models\Bookmark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $bookmarkModel;

    private $course_id;

    private $user_id;

    protected function setUp() : void
    {
        parent::setUp();

        $this->course_id = $this->faker->uuid;

        $this->user_id = $this->faker->randomDigit;

        $this->bookmarkModel = factory(Bookmark::class)->create([
            'course_id' => $this->course_id,
            'user_id' => $this->user_id,
        ]);

    }

    /**
     * @test
     */

    public function ユーザーがコースで持つブックマークの取得()
    {
        $bookmark = $this->bookmarkModel
        ->userHasBookmarkOnCourse($this->course_id, $this->user_id)
        ->first();

        $this->assertSame($this->bookmarkModel->course_id, $bookmark->course_id);

        $this->assertSame($this->bookmarkModel->user_id, $bookmark->user_id);


    }
}
