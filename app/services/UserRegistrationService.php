<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRegistrationService
{
    public function __construct()
    {

    }

    public function createUser(array $userInfo, ?String $selectedRank): void
    {
        $uuid = Str::uuid();
        $newUser = User::create([
            'uuid' => $uuid,
            'name' => $userInfo['name'],
            'last_name' => $userInfo['last_name'],
            'email' => $userInfo['email'],
            'rank' => $selectedRank,
            'password' => Hash::make($userInfo['password']),
        ]);

        if($selectedRank == 'user' or $selectedRank == NULL){
            $newUser->rank = 'user';
            $newUser->save();

            return;
        }

        $newUser->rank = $selectedRank;
        $newUser->save();

        return;
    }
}