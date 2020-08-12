<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SocialAccountService;

class SocialAccountController extends Controller
{
    public function redirectToProvider()
    {
        return \Socialite::driver('twitter')->redirect();
    }

    public function handleProviderCallback(SocialAccountService $accountService)
    {

        try {

            $user = \Socialite::driver('twitter')->user();

        } catch (\Exception $e) {

            notify()->error('ログインに失敗しました', '失敗');
            
            return redirect()
                ->route('login');
                
        }

        $authUser = $accountService->findOrCreate(
            $user,
            'twitter'
        );

        auth()->guard('web')->login($authUser, true);

        notify()->success('ログインしました', '成功');

        return redirect()
            ->route('courses.index');

    }
}
