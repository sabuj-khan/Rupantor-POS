<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerifyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->cookie('token');
        $result = JWTToken::verifyJWTToken($token);

        if($result == "Unauthorized"){
            return redirect('/userLogin');
            // return response()->json([
            //     'success' => 'fail',
            //     'message' => 'Something went wrong'
            // ], 401);
        }else{
            $request->headers->set('email', $result->userEmail);
            $request->headers->set('id', $result->userId);
            return $next($request);
        }

        
    }
}
