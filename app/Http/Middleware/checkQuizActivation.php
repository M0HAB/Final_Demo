<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkQuizActivation
{

    public function handle($request, Closure $next)
    {
        if(Auth::User()->isStudent()){
            if(!(request()->quiz->is_active)){
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');            }
        }
        return $next($request);
    }
}
