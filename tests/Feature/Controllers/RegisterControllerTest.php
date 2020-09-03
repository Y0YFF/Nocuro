<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
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
    public function Webログインした状態でユーザー登録ページにアクセスするとコース一覧ページにリダイレクト()
    {
        $user = factory(User::class)->create();

        $url = route('register');

        $redirectToUrl = route('courses.index');

        $response = $this->actingAs($user, 'web')->get($url);

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function Webログインしていない状態でユーザー登録ページにアクセスするとユーザー登録ページを表示()
    {
        $url = route('register');

        $response = $this->get($url);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function Webログインした状態でユーザー登録するとコース一覧ページにリダイレクト()
    {
        $user = factory(User::class)->create();

        $url = route('register');

        $password = $this->faker->password;

        $request = [
            'name' => $this->faker->name,
            'account_id' => $this->faker->firstName,
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirm' => $password,
        ];

        $redirectToUrl = route('courses.index');

        $response = $this->actingAs($user, 'web')->post($url, $request);

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function Webログインしていない状態でユーザー登録するとユーザーを登録してコース一覧へリダイレクト()
    {
        $url = route('register');

        $password = $this->faker->password;

        $request = [
            'name' => $this->faker->regexify('[a-zA-Z0-9_]{2,30}'),
            'account_id' => $this->faker->regexify('[a-zA-Z0-9_]{4,15}'),
            'email' => $this->faker->email,
            'password' => $password,
            'password_confirmation' => $password,
        ];

        $user_data = [
            'name' => $request['name'],
            'account_id' => $request['account_id'],
            'email' => $request['email'],
        ];

        $redirectToUrl = route('courses.index');

        $response = $this->from($redirectToUrl)->post($url, $request);

        $response->assertRedirect($redirectToUrl);

        $this->assertDatabaseHas('users', $user_data);

    }
}

