<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class TokenVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader || !preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            return response()->json(['error' => 'No Autorizado'], Response::HTTP_UNAUTHORIZED);
        }

        $token = $matches[1];

        if (!$this->isTokenValid($token)) {
            return response()->json(['error' => 'No Autorizado'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }

    protected function isTokenValid($token): bool
    {
        return User::whereHas('tokens', function ($query) use ($token) {
            $query->where('token', $token);
        })->exists();
    }
}
