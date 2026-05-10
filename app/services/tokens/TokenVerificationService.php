<?php

namespace App\Services\tokens;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\User;
use App\Models\tokens\RefreshToken;
use App\Models\tokens\AccessToken;
use Illuminate\Support\Facades\Hash;

class TokenVerificationService
{
    public function verifyRefreshToken(String $refreshToken)
    {
        [$id, $token] = explode('dbr', $refreshToken, 2);
        $tokenInfo = RefreshToken::where('id', $id)->firstOrFail();

        if (hash('sha256', $token) !== $tokenInfo->token) {
            $tokenValidity = False;
            return $tokenValidity;
        }

        $now = Carbon::now();
        $expiration = $tokenInfo->expires_at;

        if($now->greaterThan($expiration)){
            $tokenValidity = FALSE;
        }else{
            $tokenValidity = TRUE;
        }

        $userUuid = $tokenInfo->user_uuid;
        
        return [$tokenValidity, $userUuid];
    }

    //Not called everywhere, this is handled in middleware, but we have the function just in case for later use
    public function verifyAccessToken(String $tokenValue)
    {
        [$id, $token] = explode('dbr', $tokenValue, 2);
        $tokenInfo = AccessToken::where('id', $id)->firstOrFail();

        if (hash('sha256', $token) !== $tokenInfo->token) {
            $tokenValidity = False;
            return $tokenValidity;
        }

        $now = Carbon::now();
        $expiration = $tokenInfo->expires_at;

        if($now->greaterThan($expiration)){
            $tokenValidity = FALSE;
        }else{
            $tokenValidity = TRUE;
        }

        $userUuid = $tokenInfo->user_uuid;
        
        return $tokenValidity;
    }
}