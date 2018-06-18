<?php

namespace App\Http\Middleware;

use App\Course;
use Closure;
use Illuminate\Support\Facades\Auth;

class checkCourseActivation
{

    public function handle($request, Closure $next)
    {
        $course = Course::find(request()->course->id);
        if(Auth::User()->isStudent()){
            if(!($course->is_active)){
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');            }
        }
        return $next($request);
    }
}
