<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'password',
        'department',
        'gender',
        'role',
        'location',
        'level',
        'gpa',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getfnameAttribute($value)
    {
        return ucwords($value);
    }

    /*Create a function to check if the user(student OR instructor) is enrolled to a specific course */
    public function checkIfUserTeachCourse(Course $course){
        return (bool) DB::table('courses')
            ->leftjoin('users', 'users.id', '=', 'courses.instructor_id')
            ->where('courses.id', '=', $course->id)
            ->where('users.id', '=', $this->id)
            ->count();
    }

    public function checkIfUserEnrolled(Course $course){
        return (bool) DB::table('courses')
            ->leftjoin('course_user', 'course_user.course_id', '=', 'courses.id')
            ->leftjoin('users', 'users.id', '=','course_user.user_id')
            ->where('course_user.user_id', '=', $this->id)
            ->where('course_user.course_id', '=', $course->id)
            ->where('course_user.is_passed', '=', 0)
            ->count();
    }

}
