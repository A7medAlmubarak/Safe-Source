<?php

namespace App\Services;

use App\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;

class TokenService
{
    /**
     * Create a new personal access token for the user.
     *
     * @param User $user
     * @param string $tokenName
     * @return PersonalAccessTokenResult
     */
    public function createPersonalAccessToken(User $user, string $tokenName = 'Personal Access Token')
    {
        return $user->createToken($tokenName)->accessToken;
    }
}
