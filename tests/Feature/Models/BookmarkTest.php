<?php

namespace Tests\Feature\Models;

use App\Models\Bookmark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookmarkTest extends TestCase
{
    use RefreshDatabase;

    private $bookmarkModel;

    const COURSE_ID = 1;

    const USER_ID = 1;

    protected function setUp() : void
    {
        parent::setUp();

        $this->bookmarkModel = factory(Bookmark::class)->create([
            'course_id' => self::COURSE_ID,
            'user_id' => self::USER_ID,
        ]);

        
    }

    /**
     * @test
     */

    public function ユーザーがコースで持つブックマークの取得()
    {
        $bookmark = $this->bookmarkModel
        ->userHasBookmarkOnCourse(self::COURSE_ID, self::USER_ID)
        ->first();

        $this->assertSame(self::COURSE_ID, $bookmark->course_id);

        $this->assertSame(self::USER_ID, $bookmark->user_id);


    }
}
