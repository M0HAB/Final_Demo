<?php
namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class coursePagesController extends Controller{

    /**
        | Get the user courses page [Student $ Instructor]:-
        |---------------------------------------------------
    */
    public function getCoursesList(){

    }

     /**
        | Get new course form:-
        |----------------------
     */

    public function getNewCourseForm(){
        return view('courses.newCourseForm');
    }





}