<?php
namespace App\Http\Controllers\Courses;

use App\Course;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Courses_CRUD_Controller extends Controller{


    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }


    /**
    | list the courses of the user:-
    |-------------------------------
     */

    public function listUserCourses(){

        $user = User::find(Auth::User()->id);

        // Get the courses of the user and the instructor name of each course
        $courses = DB::table('courses')
            ->leftjoin('course_user', 'course_user.course_id', '=', 'courses.id')
            ->leftjoin('users as u1', 'u1.id', '=', 'courses.instructor_id')
            ->leftjoin('users as u2', 'u2.id', '=','course_user.user_id')
            ->select('courses.*', 'u1.fname', 'u1.lname')
            ->where('course_user.user_id', '=', $user->id)
            ->where('course_user.is_passed', '=', 0)
            ->get();
        return view('Courses.userCourses', compact('courses'));
    }




    /**
    | Get new course form:-
    |----------------------
     */

    public function getNewCourseForm(){
        return view('courses.newCourseForm');
    }

    /**
        | Create New Course
        |------------------
    */

    public function addNewCourse(Request $request){

        if(\Illuminate\Support\Facades\Request::ajax()){

            // Variables to hold the valid selected values in the form

            $departmentValues = ['Computer Department', 'Communication Department', 'Architecture Department', 'Mechanical Department'];
            $courseSpecializationValues = ['Computer Science', 'Data Science', 'Embedded System', 'Communication', 'Electronics', 'Basic Science',];
            $languageValues = ['Arabic', 'English'];
            $commitmentValues = [1, 2, 3, 4];

            // Validate the form fields

            $validator = Validator::make($request->all(), [
                'title'           => 'required|string|max:255|unique:courses',
                'code'            => 'required|string|max:255|unique:courses',
                'course_department'  => ['required', Rule::in($departmentValues)],
                'start_date'      => 'required|date|after:today',
                'end_date'        => 'required|date|after:start_date',
                'course_language' => ['required', Rule::in($languageValues)],
                'course_specialization'  => ['required', Rule::in($courseSpecializationValues)],
                'description'     => 'required|max:255',
                'how_to_pass'     => 'required|max:255',
                'commitment'      => ['required', Rule::in($commitmentValues)]
            ]);
            if (!($validator->passes())) {
                return response($validator->errors(), 401);
            }

            $course = Course::create([
                'title'            => $request->title,
                'code'             => $request->code,
                'course_department'=> $request->course_department,
                'start_date'       => $request->start_date,
                'end_date'         => $request->end_date,
                'course_language'  => $request->course_language,
                'course_specialization' => $request->course_specialization,
                'description'      => $request->description,
                'how_to_pass'      => $request->how_to_pass,
                'commitment'       => $request->commitment,
                'instructor_id'      => Auth::User()->id,
            ]);
            if($course){
                return response()->json([
                    'message' => 'The course has been created successfully!',
                    'data' => $course
                ]);
            }
        }
    }

    /**
    | Get The Update Form Of Existing course :-
    |------------------------------------------
     */
    public function getUpdateCourseForm($id){
        $course = Course::find($id);
        if(Auth::User()->checkIfUserEnrolled($course) or Auth::User()->checkIfUserTeachCourse($course)) {
            return view('courses.updateCourseForm', compact('course'));
        }else{
            return redirect()->back();
        }
    }

    /**
    | Update A Specific Course :-
    |----------------------------
     */
    public function updateCourse(Request $request, $id){
        if(\Illuminate\Support\Facades\Request::ajax()){

            $course = Course::find($id);
            // Variables to hold the valid selected values in the form
            $departmentValues = ['Computer Department', 'Communication Department', 'Architecture Department', 'Mechanical Department'];
            $courseSpecializationValues = ['Computer Science', 'Data Science', 'Embedded System', 'Communication', 'Electronics', 'Basic Science',];
            $languageValues = ['Arabic', 'English'];
            $commitmentValues = [1, 2, 3, 4];

            // Validate the form fields

            $validator = Validator::make($request->all(), [
                'title'           => 'required|string|max:255|unique:courses,title,'.$course->id,
                'code'            => 'required|string|max:255|unique:courses,code,'.$course->id,
                'course_department'  => ['required', Rule::in($departmentValues)],
                'start_date'      => 'required|date|after:today',
                'end_date'        => 'required|date|after:start_date',
                'course_language' => ['required', Rule::in($languageValues)],
                'course_specialization'  => ['required', Rule::in($courseSpecializationValues)],
                'description'     => 'required|max:255',
                'how_to_pass'     => 'required|max:255',
                'commitment'      => ['required', Rule::in($commitmentValues)]
            ]);
            if (!($validator->passes())) {
                return response($validator->errors(), 401);
            }

            $course = Course::where('id', $id)->update([
                    'title'            => $request->title,
                    'code'             => $request->code,
                    'course_department'=> $request->course_department,
                    'start_date'       => $request->start_date,
                    'end_date'         => $request->end_date,
                    'course_language'  => $request->course_language,
                    'course_specialization' => $request->course_specialization,
                    'description'      => $request->description,
                    'how_to_pass'      => $request->how_to_pass,
                    'commitment'       => $request->commitment,
                    'instructor_id'      => Auth::User()->id,
            ]);
            if($course){
                $course = Course::find($id);
                return response()->json([
                    'message' => 'The course has been updated successfully!',
                    'data' => $course
                ]);
            }
        }
    }


}