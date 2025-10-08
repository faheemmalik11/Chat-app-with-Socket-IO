<?php

namespace App\Http\Middleware;






use Illuminate\Http\Request;
use Closure;

use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;




class AuthUserMiddleware {

    /**
     * The JWT Authenticator.
     *
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
       
        try {



            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return response()->json(['message' => 'user not found', 'user' => $user], 500);
            }

        } catch (JWTException $e) {
            return response()->json(['messages' => $e->getMessage()], 500);
        }

        if(auth()->guard('user')->check()){
            return $next($request);
        } else {
            return response()->json([
                'status' => auth()->guard('user')->check(),
                'message' => 'Please login with user Account.',
            ], 409);
        }

    }
}