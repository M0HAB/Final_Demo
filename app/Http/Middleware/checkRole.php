<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkRole
{

    public function handle($request, Closure $next, $role)
    {
        if(! (Auth::User()->role === $role)){
             return redirect()->back();
        }
        return $next($request);
    }
}
