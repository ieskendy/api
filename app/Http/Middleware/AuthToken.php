<?php

namespace App\Http\Middleware;
use App\UserToken;
use Closure;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $usertoken = new UserToken;
        $token = $request->header('token');
        if($token) {
            if($usertoken->checkUserToken($token)){
                return $next($request);
            } else {
                return response()->json(['message' => 'Invalid token'], 500);
            }
        } else {
            return response()->json(['message' => 'Missing token'], 422);
        }
    }
}
