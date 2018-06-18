<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user() && Auth::user()->role_id != 0) {
            return redirect()->route('user.dashboard')->with(Session::flash('error', 'Access denied, don\'t be rude'));
        }

        return $next($request);
    }
}
