<?php

namespace App\Http\Middleware;

use App\Helper\JWTToken;
use App\Helper\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerification {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response {
        //    Received token in header
        $token = $request->header('token');
        // Verify the user token
        $result = JWTToken::verifyUserToken($token);
        // check if the result indicates unauthorized
        if ($result === 'unauthorized') {
            // Return a JSON response for unauthorized access
            return ResponseHelper::out('Unauthorized', null, 401);
        }
        $request->headers->set('email', $result);
        return $next($request);
    }
}
