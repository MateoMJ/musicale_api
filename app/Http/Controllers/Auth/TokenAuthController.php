<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Services\tokens\TokenMintingService;
use App\Services\tokens\TokenVerificationService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\tokens\RefreshToken;
use App\Models\tokens\AccessToken;


class TokenAuthController extends Controller
{
    public function __construct(
        TokenMintingService $tokenMintingService, LogService $logService, 
        TokenVerificationService $tokenVerificationService
        ){
        $this->tokenMintingService = $tokenMintingService;
        $this->tokenVerificationService = $tokenVerificationService;
    }
    
    public function authenticate(LoginRequest $request): JsonResponse
    {
        $email = request('email');
        $password = request('password');

        $user = User::where('email', $email)->first();
        
        if (!$user || !Hash::check($password, $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401); 
        }

        //Email Verification goes here if added TODO:

        $refreshToken = $this->tokenMintingService->grantRefreshToken($user);
        
        return response()->json([ 
            'token' => $refreshToken 
        ], 200);
    }

    public function AuthenticateWithRefreshToken($refreshToken): JsonResponse
    {   
        [$tokenValidity, $userId] = $this->tokenVerificationService->verifyRefreshToken($refreshToken);

        if($tokenValidity == FALSE){
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $accessToken = $this->tokenMintingService->grantAccessToken($userId);

        return response()->json([ 
            'token' => $accessToken 
        ], 200);
    }

    public function revokeAllTokens(Request $request): JsonResponse
    {   
        $user = $request->user();

        $user->tokens()->delete();

        $refreshTokens = RefreshToken::where('user_id', $user->id)->get();
        foreach( $refreshTokens as $token){
        $token->delete();
        }

        return response()->json([
            'message' => 'Successfully logged out'
        ], 200);
    }
}