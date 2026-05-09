<?php

namespace App\Services\tokens;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\User;
use App\Models\tokens\RefreshToken;
use App\Models\tokens\AccessToken;
use Illuminate\Support\Str;

class TokenMintingService
{

    public function __construct()
    {

    }

    public function grantAccessToken(Int $userId)
    {
        $deviceName = 'To be defined'; //Not needed for now

        $previousToken = AccessToken::select('id','name','user_id')->where('user_id', $user->id)
        ->where('name', $deviceName)->first();
        if($previousToken){
            $previousToken->delete();
        }

        $tokenPlainText = Str::Random(64);
        $hashedToken = hash('sha256', $tokenPlainText);

        $expiry = Carbon::now();
        $expiry->add(10, 'minute');

        $AccessToken = RefreshToken::create([
            'name' => ($deviceName),
            'token' => ($hashedToken),
            'last_used_at' => (NULL),
            'expires_at' => ($expiry),
            'user_id' => ($user->id),
        ]);

        $tokenRow = $refreshToken->id . 'dbr';
        $tokenPlainText = $tokenRow . $tokenPlainText;

        return $tokenPlainText;
    }

    public function grantRefreshToken(User $user)
    {

        $deviceName = 'To be defined'; //Not needed for now

        $previousToken = RefreshToken::select('id','name','user_id')->where('user_id', $user->id)->
        where('name', $deviceName)->first();
        if($previousToken){
            $previousToken->delete();
        }

        $tokenPlainText = Str::Random(64);
        $hashedToken = hash('sha256', $tokenPlainText);

        $expiry = Carbon::now();
        $expiry->add(7, 'day');

        $refreshToken = RefreshToken::create([
            'name' => ($deviceName),
            'token' => ($hashedToken),
            'last_used_at' => (NULL),
            'expires_at' => ($expiry),
            'user_id' => ($user->id),
        ]);

        $tokenRow = $refreshToken->id . 'dbr';
        $tokenPlainText = $tokenRow . $tokenPlainText;

        return $tokenPlainText;
    }
}