<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Socialite;
use Tests\TestCase;

class SocialAccountControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $providerName;

    private $user;

    private $provider;

    protected function setUp(): void
    {
        parent::setUp();

        Mockery::getConfiguration()->allowMockingNonExistentMethods(false);

        $this->providerName = 'twitter';

        $this->user = Mockery::mock('Laravel\Socialite\Two\User');

        $this->user
        ->shouldReceive('getId')
        ->andReturn(uniqid())
        ->shouldReceive('getEmail')
        ->andReturn($this->faker->email)
        ->shouldReceive('getName')
        ->andReturn($this->faker->name)
        ->shouldReceive('getNickname')
        ->andReturn($this->faker->firstName);

        $this->provider = Mockery::mock('Laravel\Socialite\Contracts\Provider');
        $this->provider->shouldReceive('user')->andReturn($this->user);

    }

    public static function tearDownAfterClass(): void
    {
        Mockery::getConfiguration()->allowMockingNonExistentMethods(true);
    }

    /**
     * @test
     */
    public function Twitterログインボタンを押すと認証画面にリダイレクト()
    {
        $url = route('twitter.auth');

        $response = $this->get($url);

        $response->assertStatus(302);

        $target = parse_url($response->headers->get('location'));

        $this->assertSame('api.twitter.com', $target['host']);
    }

    /**
     * @test
     */
    public function Twitterログインするとユーザーを登録する()
    {
        Socialite::shouldReceive('driver')->with($this->providerName)->andReturn($this->provider);

        $response = $this->get(route('twitter.oauthCallback'));

        $response->assertStatus(302)->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('users', [
            'name' => $this->user->getName(),
            'account_id' => $this->user->getNickName(),
            'email' => $this->user->getEmail(),
        ]);

        $this->assertAuthenticated();
    }
    
}
