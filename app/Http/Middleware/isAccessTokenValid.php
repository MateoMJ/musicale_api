<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Models\tokens\AccessToken;
use App\Services\tokens\TokenVerificationService;

class IsAccessTokenValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = $request->header('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            return response()->json(['error' => 'No token provided.'], 401);
        }

        $tokenValue = substr($authHeader, 7);

        [$id, $tokenReceived] = explode('dbr', $tokenValue, 2);
        $token = AccessToken::where('id', $id)->firstOrFail();

        if (hash('sha256', $tokenReceived) !== $token->token) {
            $tokenValidity = False;
            return $tokenValidity;
        }

        $now = Carbon::now();
        $expiration = $token->expires_at;

        if($now->greaterThan($expiration)){
            $tokenValidity = FALSE;
        }else{
            $tokenValidity = TRUE;
        }
        
        if ($tokenValidity == False) {
            return response()->json(['error' => 'Token is invalid.'], 401);
        }

        $request->setUserResolver(function () use ($token) {
            return $token->user;
        });

        return $next($request);
    }
}