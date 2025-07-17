<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log::info('UserMiddleware executed');

    	if (Auth::check() && Auth::user()->user_type == 'customer') {
            // Log::warning('User is authenticated and a customer');
	        return $next($request);
    	}

        // Log::warning('User is not authenticated or not a customer');
    	return redirect()->route('customerlogin');

    }
}
