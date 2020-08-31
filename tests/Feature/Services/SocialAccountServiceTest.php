<?php

namespace Tests\Feature\Services;

use App\Models\LinkedSocialAccount;
use App\Models\User;
use App\Models\Userinfo;
use App\Services\SocialAccountService;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SocialAccountServiceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    private $social_account_service;
    private $id;
    private $nickname;
    private $name;
    private $email;

    protected function setUp(): void
    {
        parent::setUp();

        $this->id = $this->faker->randomDigit;
        $this->nickname = $this->faker->firstName;
        $this->name = $this->faker->name;
        $this->email = $this->faker->email;

        $this->social_account_service = new SocialAccountService;
    }

    /**
     * @test
     */
    public function ソーシャルアカウントがアプリに登録されている場合にそのアカウントを返す()
    {
        $provider_user_mock = new ProviderUserMock($this->id, $this->nickname, $this->name, $this->email);

        $user = factory(User::class)->create();
        $social_account = factory(LinkedSocialAccount::class)->create([
            'provider_id' => $this->id,
            'user_id' => $user->id,
        ]);

        $social_acccount_user = $this->social_account_service->findOrCreate($provider_user_mock, 'twitter');

        $this->assertTrue($social_acccount_user instanceof User);

    }

    /**
     * @test
     */
    public function ソーシャルアカウントがアプリに登録されておらずメールアドレスがない場合に登録した時UserモデルとUserinfoモデルとLinkedSocialAccountモデルを登録する()
    {
        $provider_user_mock = new ProviderUserMock($this->id, $this->nickname, $this->name, null);

        $user = $this->social_account_service->findOrCreate($provider_user_mock, 'twitter');
        $userinfo = $user->userinfo()->first();
        $social_account = $user->accounts()->first();

        $this->assertNull($user->email);
        $this->assertTrue($user instanceof User);
        $this->assertTrue($userinfo instanceof Userinfo);
        $this->assertTrue($social_account instanceof LinkedSocialAccount); 
    }

    /**
     * @test
     */
    public function ソーシャルアカウントがアプリに登録されておらずメールアドレスがある場合に登録した時UserモデルとUserinfoモデルとLinkedSocialAccountモデルを登録する()
    {
        $provider_user_mock = new ProviderUserMock($this->id, $this->nickname, $this->name, $this->email);

        $user = $this->social_account_service->findOrCreate($provider_user_mock, 'twitter');
        $userinfo = $user->userinfo()->first();
        $social_account = $user->accounts()->first();

        $this->assertNotNull($user->email);
        $this->assertTrue($user instanceof User);
        $this->assertTrue($userinfo instanceof Userinfo);
        $this->assertTrue($social_account instanceof LinkedSocialAccount); 
    }

    /**
     * @test
     */
    public function ソーシャルアカウントがアプリに登録されておらずアカウントIDが重複した場合にランダムなIDを用いてUserモデルとUserinfoモデルとLinkedSocialAccountモデルを登録する()
    {
        $provider_user_mock = new ProviderUserMock($this->id, $this->nickname, $this->name, $this->email);

        $existing_user = factory(User::class)->create([
            'account_id' => $this->nickname
        ]);

        $user = $this->social_account_service->findOrCreate($provider_user_mock, 'twitter');
        $userinfo = $user->userinfo()->first();
        $social_account = $user->accounts()->first();

        $this->assertNotSame($this->nickname, $user->account_id);
        $this->assertTrue($user instanceof User);
        $this->assertTrue($userinfo instanceof Userinfo);
        $this->assertTrue($social_account instanceof LinkedSocialAccount); 
    }

    /**
     * @test
     */
    public function ソーシャルアカウントがアプリに登録されておらずメールアドレスがあるがそれがすでに登録されている場合にLinkedSocialAccountモデルを登録する()
    {
        $provider_user_mock = new ProviderUserMock($this->id, $this->nickname, $this->name, $this->email);

        $existing_user = factory(User::class)->create([
            'email' => $this->email
        ]);

        $user = $this->social_account_service->findOrCreate($provider_user_mock, 'twitter');
        $social_account = $user->accounts()->first();

        $this->assertTrue($user instanceof User);
        $this->assertTrue($social_account instanceof LinkedSocialAccount); 

    }

}

class ProviderUserMock implements ProviderUser
{
    private $id;
    private $nickname;
    private $name;
    private $email;

    public function __construct($id, $nickname, $name, $email)
    {
        $this->id = $id;

        $this->nickname = $nickname;

        $this->name = $name;

        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAvatar()
    {
        return null;
    }
};
