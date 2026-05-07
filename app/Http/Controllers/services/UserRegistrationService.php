<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRegistrationService
{
    public function __construct()
    {

    }

    public function createUser(array $userInfo, ?String $selectedRank): void
    {
        $newUser = User::create([
            'name' => $userInfo['name'],
            'last_name' => $userInfo['last_name'],
            'email' => $userInfo['email'],
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