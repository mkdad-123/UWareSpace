<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $admin = $request->auth('admins')->user();
        if ($admin->subscribed('default')){
        return $next($request);
        }
        else {
            return response()->json([
                'message' => 'please Subscribe first to continue'
            ]);
        }
    }
}
