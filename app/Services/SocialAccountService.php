<?php

namespace App\Services;

use Laravel\Socialite\Contracts\User as ProviderUser;
use App\Models\LinkedSocialAccount;
use App\Models\User;

class SocialAccountService
{
    public function findOrCreate(ProviderUser $providerUser, $providerName)
    {
        $account = LinkedSocialAccount::where('provider_name', $providerName)
            ->where('provider_id', $providerUser->getId())
            ->first();
        
        if ($account) {

            return $account->user;

        } else {

            $findUser = User::where('account_id', $providerUser->getNickname())->first();

            if (!$findUser) {

                $account_id = $providerUser->getNickname();

            } else {

                $account_id = uniqid();

            }

            if (!$providerUser->getEmail()) {

                $email = null;

            } else {

                $email = $providerUser->getEmail();

                $user = User::where('email', $email)->first();

                if ($user) {

                    $user->accounts()->create([
                        'provider_id'   => $providerUser->getId(),
                        'provider_name' => $providerName,
                    ]);

                    return $user;

                }
            }

            try {
                
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'email' =>  $email,
                    'account_id' => $account_id,
                    'password' => null,
                ]);

                $user->userinfo()->create([
                    'completed_course_count' => 0,
                ]);

                $user->accounts()->create([
                    'provider_id'   => $providerUser->getId(),
                    'provider_name' => $providerName,
                ]);

            } catch (\Exception $e) {

                $user = null;

            }

            return $user;

        }
    }
}
