<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function 未ログイン時にログインページにアクセスするとログインページを表示()
    {
        $url = route('login');

        $response = $this->get($url);

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function ログイン時にログインページにアクセスするとコース一覧ページにリダイレクト()
    {
        $url = route('login');

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'web')->get($url);

        $redirectToUrl = route('courses.index');

        $response->assertRedirect($redirectToUrl);

    }

    /**
     * @test
     */
    public function 登録したユーザーでログインして成功する()
    {
        $url = route('login');

        $user = factory(User::class)->create();

        $redirectToUrl = route('courses.index');

        $request = [
            'account_id' => $user->account_id,
            'password' => $user->password,
        ];

        $response = $this->from($redirectToUrl)->post($url, $request);

        $response->assertRedirect($redirectToUrl);

    }

    /**
     * @test
     */
    public function 登録したユーザーでログインして失敗する()
    {
        $url = route('login');

        $user = factory(User::class)->create();

        $request = [
            'account_id' => 'notCorrect',
            'password' =>  'notCorrect',
        ];

        $response = $this->from($url)->post($url, $request);

        $response->assertRedirect($url);
    }

    /**
     * @test
     */
    public function 登録していないユーザーでログインして失敗する()
    {
        $url = route('login');

        $request = [
            'account_id' => $this->faker->firstName,
            'password' =>  $this->faker->password,
        ];

        $response = $this->from($url)->post($url, $request);

        $response->assertRedirect($url);
    }

    /**
     * @test
     */
    public function ログインしているユーザーがログインしようとするとコース一覧ページへリダイレクト()
    {
        $url = route('login');

        $user = factory(User::class)->create();

        $request = [
            'account_id' => $user->account_id,
            'password' =>  $user->password,
        ];

        $response = $this->actingAs($user, 'web')->post($url, $request);

        $redirectToUrl = route('courses.index');

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function ログインしたユーザーがログアウトするとコース一覧ページへリダイレクト()
    {
        $url = route('logout');

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'web')->post($url);

        $redirectToUrl = route('courses.index');

        $response->assertRedirect($redirectToUrl);
    }

    /**
     * @test
     */
    public function 未管理者ログイン時に管理者ログインページにアクセスすると管理者ログインページを表示()
    {
        $url = route('admins.login');

        $response = $this->get($url);

        $response->assertStatus(200);
    }


    /**
     * @test
     */
    public function 管理者ログイン時に管理者ログインページにアクセスすると管理者コース一覧ページにリダイレクト()
    {
        $url = route('admins.login');

        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin, 'admin')->get($url);
        
        $redirectToUrl = route('admins.index');

        $response->assertRedirect($redirectToUrl);

    }

    /**
     * @test
     */
    public function 登録したユーザーで管理者ログインして成功する()
    {
        $url = route('admins.login');

        $admin = factory(Admin::class)->create();

        $redirectToUrl = route('admins.index');

        $request = [
            'account_id' => $admin->account_id,
            'password' => $admin->password,
        ];

        $response = $this->from($redirectToUrl)->post($url, $request);

        $response->assertRedirect($redirectToUrl);

    }

    /**
     * @test
     */
    public function 登録したユーザーで管理者ログインして失敗する()
    {
        $url = route('admins.login');

        $admin = factory(Admin::class)->create();

        $request = [
            'account_id' => 'notCorrect',
            'password' =>  'notCorrect',
        ];

        $response = $this->from($url)->post($url, $request);

        $response->assertRedirect($url);
    }

    /**
     * @test
     */
    public function 登録していないユーザーで管理者ログインして失敗する()
    {
        $url = route('admins.login');

        $request = [
            'account_id' => $this->faker->firstName,
            'password' =>  $this->faker->password,
        ];

        $response = $this->from($url)->post($url, $request);

        $response->assertRedirect($url);
    }

    /**
     * @test
     */
    public function 管理者ログインしたユーザーがログアウトするとコース一覧ページへリダイレクト()
    {
        $url = route('admins.logout');

        $admin = factory(Admin::class)->create();

        $response = $this->actingAs($admin, 'admin')->post($url);

        $redirectToUrl = route('courses.index');

        $response->assertRedirect($redirectToUrl);
    } 

}
