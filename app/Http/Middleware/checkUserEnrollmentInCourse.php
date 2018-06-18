<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class checkUserEnrollmentInCourse
{
    public function handle($request, Closure $next)
    {
        if(Auth::User()->isInstructor()){
            if(!(Auth::User()->checkIfUserTeachCourse(request()->course->id))){
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');            }
        }elseif(Auth::User()->isStudent()){
            if(!(Auth::User()->checkIfUserEnrolled(request()->course->id))){
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');            }
        }
        return $next($request);
    }
}
