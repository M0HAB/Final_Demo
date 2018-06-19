<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\CourseStudentAssign;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class courseController extends Controller{

    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['getUsers', 'destroy']]);
    }

    public function index(){
        $courses = DB::table('courses')
            ->leftJoin('departments', 'departments.id', '=', 'courses.course_department')
            ->leftJoin('specializations', 'specializations.id', '=', 'courses.course_specialization')
            ->select('courses.*', 'specializations.name as spec_name', 'departments.name as dep_name')
            ->get();
        // dd($courses);
        return view('_auth.admin.courses.index', compact('courses'));
    }

    public function assignStudents(Course $course){

        $students = User::getStudents()->orderBy('fname')->get();

        return view('_auth.admin.courses.assignStudents', compact('course', 'students'));
    }

    public function submitAssignStudents(Request $request, Course $course){

      if($request->students != null){
          $insertedUsers = 0;
          foreach($request->students as $key => $value){
              $data = array(
                  'course_id' => $course->id,
                  'user_id' => $value
              );
              $assign = CourseStudentAssign::insert($data);
              if($assign){
                  $insertedUsers++;
              }
          }
          if($insertedUsers == count($request->students)){
              return redirect()->back()->with('success', 'Students assigned successfully!');
          }
      }else{
          return redirect()->back()->with('error', 'Please select students!');
      }
    }

    public function courseStudents(Course $course){

        //$students = User::getStudents()->orderBy('fname')->get();

        $students = DB::table('course_user')
            ->leftjoin('users', 'users.id', '=', 'course_user.user_id')
            ->leftjoin('courses', 'courses.id', '=','course_user.course_id')
            ->select('users.*', 'course_user.id as assignID')
            ->where('courses.id', '=', $course->id)
            ->get();
        return view('_auth.admin.courses.courseStudents', compact('course', 'students'));
    }

    public function unAssignStudent(Course $course, CourseStudentAssign $assign){

        if($assign->delete()){
            return redirect()->back()->with('success', 'Student Un-assigned successfully');
        }else{
            return redirect()->back()->with('error', 'something went wrong!!Try again');
        }

    }

}