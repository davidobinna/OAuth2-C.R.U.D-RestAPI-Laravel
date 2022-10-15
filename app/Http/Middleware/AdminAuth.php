<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {    
           $user = User::class;
        if (Auth::guard('api')->check() && Auth::guard('api')->user()->type >= 1) {
            # code...
            return $next($request);
        } else {
            $message = ["message" => "Permission Denied"];

            return response($message, 401);
        }

    }
}
