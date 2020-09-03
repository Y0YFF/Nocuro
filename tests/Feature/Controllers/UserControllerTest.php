<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use App\Models\Userinfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function ユーザーページにアクセスしたらユーザーページを表示()
    {
        $user = factory(User::class)->create();

        $userinfo = factory(Userinfo::class)->create([
            'user_id' => $user->id,
        ]);

        $url = route('users.show', $user);

        $response = $this->get($url);

        $response->assertStatus(200);
    }
}
