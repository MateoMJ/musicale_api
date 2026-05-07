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

        $userId = $tokenInfo->user_id;
        
        return [$tokenValidity, $userId];
    }

    public function verifyAccessToken(String $accessToken)
    {
        [$id, $token] = explode('dbr', $accessToken, 2);
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

        $userId = $tokenInfo->user_id;
        
        return [$tokenValidity, $userId];
    }
}