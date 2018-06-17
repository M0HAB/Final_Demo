<?php
namespace App\Http\Controllers\Courses;

use App\Course;
use App\grade;
use App\Http\Controllers\Controller;
use App\Module;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Modules_CRUD_Controller extends Controller{

    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }

    /**
    | list the modules of the course:-
    |-------------------------------
     */

    public function viewCourseModules(Course $course){
        if(Auth::User()->checkIfUserEnrolled($course->id) or Auth::User()->checkIfUserTeachCourse($course->id)) {
            $course = DB::table('courses')
                ->leftjoin('users', 'users.id', '=', 'courses.instructor_id')
                ->select('courses.*', 'users.fname', 'users.lname')
                ->where('courses.id', '=', $course->id)
                ->first();

            $modules = DB::table('modules')
                ->leftjoin('courses', 'courses.id', '=', 'modules.course_id')
                ->select('modules.*')
                ->where('modules.course_id', '=', $course->id)
                ->orderBy('module_order')
                ->get();

            $grades=grade::where('user_id', '=' ,Auth::User()->id)->first();

            return view('courses.courseModules', compact('course', 'modules','grades'));
        }else{
            return redirect()->back()->with('error', 'Unauthorized access');
        }
    }


    /**
    | Get new module form:-
    |----------------------
     */

    public function getNewModuleForm(Course $course){
        if(Auth::User()->checkIfUserEnrolled($course->id) or Auth::User()->checkIfUserTeachCourse($course->id)) {
            return view('courses.newModuleForm')->with('course_id', $course->id);
        }else{
            return redirect()->back();
        }
    }

    /**
    | Create New Module
    |------------------
     */

    public function addNewModule(Request $request, Course $course){

        if(\Illuminate\Support\Facades\Request::ajax()){


            // Validate the form fields

            $validator = Validator::make($request->all(), [
                'title'      => 'required|string|max:255|unique:modules',
                'commitment' => 'required|min:1|integer',
                'module_order' => 'required|min:1|integer',
                'introduction' => 'required|max:250',

            ]);
            if (!($validator->passes())) {
                return response($validator->errors(), 401);
            }

            $module = Module::create([
                'title'        => $request->title,
                'commitment'   => $request->commitment,
                'module_order' => $request->module_order,
                'introduction' => $request->introduction,
                'course_id' => $course->id
            ]);

            if($module){
                return response()->json([
                    'message' => 'The module has been created successfully!',
                    'data' => $module
                ]);
            }
        }
    }

    /**
    | Get The Update Form Of Existing Module :-
    |------------------------------------------
     */
    public function getUpdateModuleForm(Course $course, Module $module){

        if(Auth::User()->checkIfUserEnrolled($course->id) or Auth::User()->checkIfUserTeachCourse($course->id)) {
            return view('courses.updateModuleForm', compact('course', 'module'));
        }else{
            return redirect()->back();
        }

    }

    /**
    | Update A Specific Module :-
    |----------------------------
     */
    public function updateModule(Request $request, Course $course, Module $module){
        if(\Illuminate\Support\Facades\Request::ajax()){

            // Validate the form fields
            $validator = Validator::make($request->all(), [
                'title'           => 'required|string|max:255|unique:modules,title,'.$module->id,
                'commitment' => 'required|min:1|integer',
                'module_order' => 'required|min:1|integer',
                'introduction' => 'required|max:250'
            ]);
            if (!($validator->passes())) {
                return response($validator->errors(), 401);
            }

            $myModule = $module->update([
                'title'        => $request->title,
                'commitment'   => $request->commitment,
                'module_order' => $request->module_order,
                'introduction' => $request->introduction,
                'course_id'    => $course->id
            ]);

            if($myModule){
                return response()->json([
                    'message' => 'The module has been updated successfully!',
                    'data' => $module
                ]);
            }
        }
    }


}
