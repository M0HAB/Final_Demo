<?php
namespace App\Http\Controllers\Courses;

use App\Course;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Courses_CRUD_Controller extends Controller{

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
                'title'           => $request->title,
                'code'            => $request->code,
                'course_department'      => $request->course_department,
                'start_date'      => $request->start_date,
                'end_date'        => $request->end_date,
                'course_language' => $request->course_language,
                'course_specialization'  => $request->course_specialization,
                'description'     => $request->description,
                'how_to_pass'     => $request->how_to_pass,
                'commitment'      => $request->commitment,
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
}