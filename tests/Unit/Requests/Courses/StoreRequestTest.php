<?php

namespace Tests\Unit\Requests\Courses;

use PHPUnit\Framework\TestCase;
use App\Http\Requests\Courses\StoreRequest as CourseStoreRequest;

class StoreRequestTest extends TestCase
{

	private $request;

	protected function setUp() : void
	{
		parent::setUp();

		$this->request = new CourseStoreRequest();

	}
	/**
	 * @test
	 */
	public function タグを配列に分割()
	{
		$this->request->tags = '数学,国語,英語,理科,社会';

		$tags_array = $this->request->divideTagToArray();

		$expected_tags = ['数学', '国語', '英語', '理科', '社会']; 

		$this->assertSame($expected_tags, $tags_array);
	}

	/**
	 * @test
	 */

	 public function Lessonの配列の取得()
	 {
		 $this->request->lesson_title = [
			 'title1', 
			 'title2',
			 'title3', 
			 'title4',
			 'title5'
		 ];

		 $this->request->lesson_link = [
			'link1', 
			'link2',
			'link3', 
			'link4',
			'link5'
		];

		$expected_lessons_array = [
			[
				'title' => 'title1',
				'link' => 'link1',
			],
			[
				'title' => 'title2',
				'link' => 'link2',
			],
			[
				'title' => 'title3',
				'link' => 'link3',
			],
			[
				'title' => 'title4',
				'link' => 'link4',
			],
			[
				'title' => 'title5',
				'link' => 'link5',
			],

		];

		$actual_lessons_array = $this->request->getLessonsArray();

		$this->assertSame($expected_lessons_array, $actual_lessons_array);
	 }
}
