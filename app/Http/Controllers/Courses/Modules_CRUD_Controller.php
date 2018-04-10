<?php
namespace App\Http\Controllers\Courses;

use App\Course;
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

    public function viewCourseModules($id){

        $myCourse = Course::find($id);
        $course = DB::table('courses')
            ->leftjoin('users', 'users.id', '=', 'courses.instructor_id')
            ->select('courses.*', 'users.fname', 'users.lname')
            ->where('courses.id', '=', $id)
            ->first();

        $modules = DB::table('modules')
            ->leftjoin('courses', 'courses.id', '=', 'modules.course_id')
            ->select('modules.*')
            ->where('modules.course_id', '=', $id)
            ->orderBy('module_order')
            ->get();
        if(Auth::User()->checkIfUserEnrolled($myCourse) or Auth::User()->checkIfUserTeachCourse($myCourse)) {
            return view('courses.courseModules', compact('course', 'modules'));
        }else{
            return redirect()->back();
        }
    }


    /**
    | Get new module form:-
    |----------------------
     */

    public function getNewModuleForm($id){
        $course_id = $id;
        $course = Course::find($course_id);
        if(Auth::User()->checkIfUserEnrolled($course) or Auth::User()->checkIfUserTeachCourse($course)) {
            return view('courses.newModuleForm', compact('course_id'));
        }else{
            return redirect()->back();
        }
    }

    /**
    | Create New Module
    |------------------
     */

    public function addNewModule(Request $request, $id){

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
                'course_id' => $id
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
    public function getUpdateModuleForm($course_id, $module_id){
        $course = Course::find($course_id);
        $module = Module::find($module_id);
        if(Auth::User()->checkIfUserEnrolled($course) or Auth::User()->checkIfUserTeachCourse($course)) {
            return view('courses.updateModuleForm', compact('course', 'module'));
        }else{
            return redirect()->back();
        }
    }

    /**
    | Update A Specific Module :-
    |----------------------------
     */
    public function updateModule(Request $request, $course_id, $module_id){
        if(\Illuminate\Support\Facades\Request::ajax()){

            $module = Module::find($module_id);

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

            $module = Module::where('id', $module_id)->update([
                'title'        => $request->title,
                'commitment'   => $request->commitment,
                'module_order' => $request->module_order,
                'introduction' => $request->introduction,
                'course_id'    => $course_id
            ]);

            if($module){
                $module = Module::find($module_id);
                return response()->json([
                    'message' => 'The module has been updated successfully!',
                    'data' => $module
                ]);
            }
        }
    }


}
