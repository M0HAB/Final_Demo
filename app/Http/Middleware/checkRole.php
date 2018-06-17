<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkRole
{

    public function handle($request, Closure $next, $role)
    {
        if(!(strtolower(Auth::user()->role->name) === strtolower($role))){
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
        return $next($request);
    }
}
