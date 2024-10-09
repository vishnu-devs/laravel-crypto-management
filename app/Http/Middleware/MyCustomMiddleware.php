<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MyCustomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('Quartz12$#lkmn'); // Check authorization header
        
        // Alternatively, check for API key in query string:
            // $apiKey = $request->query('api_key');
            
            if (is_null($apiKey) || $apiKey !== config('app.apikey')) {
                //echo config('app.key');
                //die;
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            
            return $next($request);
    }
}
