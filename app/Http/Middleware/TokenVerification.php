<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('Authorization');
        if (!$token) {
            redirect('/userLogin');
        }
        $result = JWTToken::verifyToken($token);

        if($result == 'unauthorized'){
            return redirect('/userLogin');
        }

        if(is_object($result)){

            $request->headers->set('email', $result->email);
            $request->headers->set('id', $result->id);
            return $next($request);
        }

        return redirect('/userLogin');
    }
}
