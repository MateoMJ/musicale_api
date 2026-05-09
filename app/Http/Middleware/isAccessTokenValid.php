<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

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
        $token = AccessToken::where('token', $tokenValue)->first();

        if (!$token) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }
        if (Carbon::now()->greaterThan($token->expires_at)) {
            return response()->json(['error' => 'Token expired.'], 401);
        }

        $request->setUserResolver(function () use ($token) {
            return $token->user;
        });

        return $next($request);
    }
}