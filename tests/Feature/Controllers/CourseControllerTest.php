<?php

namespace Tests\Feature\Controllers;

use App\Models\Admin;
use App\Models\Bookmark;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use phpDocumentor\Reflection\Types\This;
use Tests\TestCase;

class CourseControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

    }

    /**
     * @test
     */
    public function コース一覧ページにアクセスするとコース一覧を表示()
    {
        factory(Course::class, 20)->create();

        $url = route('courses.index');

        $response = $this->get($url);

        $response->assertStatus(200);

    }

    /**
     * @test
     */
    public function ログインした状態でコース詳細ページにアクセスするとコース詳細を表示()
    {
        $user = factory(User::class)->create();

        $couese = factory(Course::class)->create();

        $url = route('courses.show', $couese);

        $response = $this->actingAs($user)->get($url);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function ログインしていない状態でコース詳細ページにアクセスするとコース詳細を表示()
    {
        $couese = factory(Course::class)->create();

        $url = route('courses.show', $couese);

        $response = $this->get($url);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function 管理者ログインした状態でコース作成ページにアクセスにするとコース作成ページを作成()
    {
        $admin = factory(Admin::class)->create();

        $url = route('courses.create');

        $response = $this->actingAs($admin, 'admin')->get($url);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function Webログインした状態でコース作成ページにアクセスにするとログインページをリダイレクト()
    {
        $user = factory(User::class)->create();

        $url = route('courses.create');

        $response = $this->actingAs($user, 'web')->get($url);

        $redirectToUrl = route('admins.login');

        $response->assertRedirect($redirectToUrl);
    }

    /**
    * @test
    */
   public function ログインしていない状態でコース作成ページにアクセスにすると管理者ログインページをリダイレクト()
   {
       $url = route('courses.create');

       $response = $this->get($url);

       $redirectToUrl = route('admins.login');

       $response->assertRedirect($redirectToUrl);
   }

   /**
    * @test
    */
    public function 管理者ログインした状態でコースをPOSTするとコースとレッスンを作成()
    {
        $admin = factory(Admin::class)->create();
        
        $url = route('courses.store');

        $lesson_title = [
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
        ];

        $lesson_link = [
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
        ];

        $request = [
            'tags' => $this->faker->word . ',' . $this->faker->word . ',' .  $this->faker->word . ',', 
            'course_title' => $this->faker->sentence,
            'course_link' => $this->faker->url,
            'lesson_title' => $lesson_title,
            'lesson_link' => $lesson_link,
        ];

        $course_data = [
            'title' => $request['course_title'],
            'link' => $request['course_link'],
        ];

        $lesson_data = [
            'title' => $lesson_title[0],
            'link' => $lesson_link[0]
        ];

        $redirectToUrl = route('admins.index');

        $response = $this->actingAs($admin, 'admin')->post($url, $request);

        $response->assertRedirect($redirectToUrl);

        $this->assertDatabaseHas('courses', $course_data);

        $this->assertDatabaseHas('lessons', $lesson_data);
    }

    /**
     * @test
     */
    public function Webログインした状態でログインした状態でコースをPOSTすると管理者ログインページへリダイレクト()
    {
        $user = factory(User::class)->create();

        $url = route('courses.store');

        $lesson_title = [
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
        ];

        $lesson_url = [
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
        ];

        $request = [
            'tags' => $this->faker->word . ',' . $this->faker->word . ',' .  $this->faker->word . ',', 
            'title' => $this->faker->sentence,
            'link' => $this->faker->url,
            'lesson_title' => $lesson_title,
            'lesson_link' => $lesson_url,
        ];


        $redirectToUrl = route('admins.login');

        $response = $this->actingAs($user, 'web')->post($url, $request);

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function ログインしていない状態でログインした状態でコースをPOSTすると管理者ログインページへリダイレクト()
    {
        $url = route('courses.store');

        $lesson_title = [
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
            $this->faker->sentence,
        ];

        $lesson_url = [
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
            $this->faker->url,
        ];

        $request = [
            'tags' => $this->faker->word . ',' . $this->faker->word . ',' .  $this->faker->word . ',', 
            'title' => $this->faker->sentence,
            'link' => $this->faker->url,
            'lesson_title' => $lesson_title,
            'lesson_link' => $lesson_url,
        ];


        $redirectToUrl = route('admins.login');

        $response = $this->post($url, $request);

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function 管理者ログインした状態でコースの編集ページへアクセスするとコースの編集を表示()
    {
        $admin = factory(Admin::class)->create();

        $course = factory(Course::class)->create();

        $url = route('courses.edit', $course);

        $response = $this->actingAs($admin, 'admin')->get($url);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function Webログインした状態でコースの編集ページへアクセスすると管理者ログインページへリダイレクト()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create();

        $url = route('courses.edit', $course);

        $response = $this->actingAs($user, 'web')->get($url);

        $redirectToUrl = route('admins.login');

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function ログインしていない状態でコースの編集ページへアクセスすると管理者ログインページへリダイレクト()
    {
        $course = factory(Course::class)->create();

        $url = route('courses.edit', $course);

        $response = $this->get($url);

        $redirectToUrl = route('admins.login');

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function 管理者ログインした状態でコースをDELETEするとコースが削除される()
    {
        $admin = factory(Admin::class)->create();

        $course = factory(Course::class)->create();

        $bookmark = factory(Bookmark::class)->create([
            'course_id' => $course->id
        ]);

        $course_user = factory(CourseUser::class)->create([
            'course_id' => $course->id
        ]);

        $lesson_user = factory(LessonUser::class)->create([
            'course_id' => $course->id
        ]);

        $lesson = factory(Lesson::class)->create([
            'course_id' => $course->id
        ]);

        $url = route('courses.delete', $course);

        $redirectToUrl = route('courses.index');

        $response = $this->actingAs($admin, 'admin')->delete($url);

        $response->assertRedirect($redirectToUrl);

        $this->assertDeleted('courses', $course->toArray());

        $this->assertDeleted('bookmarks', $bookmark->toArray());

        $this->assertDeleted('course_user', $course_user->toArray());

        $this->assertDeleted('lesson_user', $lesson_user->toArray());

        $this->assertDeleted('lessons', $lesson->toArray());

    }

    /**
     * @test
     */
    public function Webログインした状態でコースをDELETEすると管理者ログインページへリダイレクト()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create();

        $url = route('courses.delete', $course);

        $redirectToUrl = route('admins.login');

        $response = $this->actingAs($user, 'web')->delete($url);

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function ログインしていない状態でコースをDELETEすると管理者ログインページへリダイレクト()
    {
        $course = factory(Course::class)->create();

        $url = route('courses.delete', $course);

        $redirectToUrl = route('admins.login');

        $response = $this->delete($url);

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function Webログインしておりコースをブックマークしていない状態でブックマークするとお気に入りとして保存してコース詳細にリダイレクト()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create();

        $url = route('courses.bookmark', $course);

        $redirectToUrl = route('courses.show', $course);

        $response = $this->actingAs($user, 'web')->post($url);

        $bookmark = Bookmark::where('course_id', $course->id)->where('user_id', $user->id)->first();

        $response->assertRedirect($redirectToUrl);

        $this->assertDatabaseHas('bookmarks', $bookmark->toArray());

    }

    /**
     * @test
     */
    public function Webログインしておりコースをブックマークしている状態でブックマークするとそれが削除されてコース詳細にリダイレクト()
    {
        $user = factory(User::class)->create();

        $course = factory(Course::class)->create();

        $bookmark = factory(Bookmark::class)->create([
            'user_id' => $user->id,
            'course_id' => $course->id
        ]);

        $url = route('courses.bookmark', $course);

        $redirectToUrl = route('courses.show', $course);

        $response = $this->actingAs($user, 'web')->post($url);

        $response->assertRedirect($redirectToUrl);

        $this->assertDatabaseMissing('bookmarks', $bookmark->toArray());

    }

    /**
     * @test
     */
    public function ログインしていない状態でブックマークするとWebログインページにリダイレクト()
    {
        $course = factory(Course::class)->create();

        $url = route('courses.bookmark', $course);

        $redirectToUrl = route('login');

        $response = $this->post($url);

        $response->assertRedirect($redirectToUrl);

    }
}
