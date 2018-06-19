<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Department;
use App\User;
use App\Role;
use App\Specialization;
use DB;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $controllerName = "Department";

    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['destroy', 'userIndex', 'userShow', 'specDestroy', 'userGetCourses', 'userGetSpecializations']]);
        $this->middleware(['auth', 'revalidate'], ['only' => ['userIndex', 'userShow', 'userGetCourses', 'userGetSpecializations']]);
    }

    public function userIndex()
    {
        // Return the list view with All Departments
        $departments = Department::all();
        return view('_auth.department.show')->with('departments', $departments);

    }

    public function index()
    {
        // Return the list view with All Departments
        $departments = Department::all();
        return view('_auth.admin.department.show')->with('departments', $departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view with Users from DB to use in ComboBox
        $users = User::getInstructors()->get();
        return view('_auth.admin.department.create')->with('users', $users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //TODO :: add More Validation Rules
        // Validate Form submitted data
        $this->validate($request, [
            'department' => 'required',
            'instructor' => [
                'required',
                Rule::notIn(['null'])
            ],
        ]);
        // Create new Department
        $department = new Department;
        $department->name = $request->input('department');
        $department->Dep_Head_ID = $request->input('instructor');
        // If succesfully updated display success else error
        if ($department->save()){
            return redirect()->back()->with('success', 'Department created successfully');
        }else{
            return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
        }

    }
    public function show($id)
    {
        // Find Department with id
        $department = Department::find($id);
        if($department){
            // Find Department Head from Users by Dep_Head_ID
            $user =  User::find($department->Dep_Head_ID);
            // get number of Students in that Department
            $student_count = count($department->getStudents()->get());
            // Append count of Students to department variable
            $department['student_count'] = $student_count;
            // Append name of Deapartment Head to department variable
            $department['head_name'] = $user->fname . ' ' . $user->lname;
            // Return View with the data
            return view('_auth.admin.department.view')->with('department', $department);
        }else{
            return redirect()->back()->with('error', 'Department not found!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function userShow($id)
    {
        // Find Department with id
        $department = Department::find($id);
        // Find Department Head from Users by Dep_Head_ID
        $user =  User::find($department->Dep_Head_ID);
        $authuser = Auth::user();
        if ($authuser->isInstructor()){
            // get number of Students in that Department
            $student_count = count($department->getStudents()->get());
            // Append count of Students to department variable
            $department['student_count'] = $student_count;
        }
        // Append name of Deapartment Head to department variable
        $department['head_name'] = $user->fname . ' ' . $user->lname;

        // Return View with the data
        return view('_auth.department.view')->with('department', $department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get Department BY id
        $department = Department::find($id);
        if($department){
            // Get users from DB where role is Instructor
            $users = User::getInstructors()->get();
            // Return the Edit view with Users from DB to use in ComboBox
            return view('_auth.admin.department.edit')->with('users', $users)->with('department', $department);
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //TODO :: add More Validation Rules
        $this->validate($request, [
            'department' => 'required',
            'instructor' => [
                'required',
                Rule::notIn(['null'])
            ],
        ]);
        // Update Department
        $department = Department::find($id);
        $newname =  $request->input('department');
        $newHead =  $request->input('instructor');
        if ($department->name != $newname || $department->Dep_Head_ID != $newHead){
            $department->name = $newname;
            $department->Dep_Head_ID = $newHead;
            if ($department->save()){
                return redirect()->back()->with('success', 'Department updated successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }else{
            return redirect()->back()->with('warning', 'Same Value resubmittion');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $department = Department::find($id);
        if($request->ajax()){
            return ($department->delete())? 1:0;
        }else{
            if($department->delete()){
                return redirect()->back()->with('success', 'Department Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }
    }

    public function getCourses($id)
    {
        $department = Department::find($id);
        if($department){
            return view('_auth.admin.department.dep_courses')->with('department', $department);
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }
    }

    public function userGetCourses($id)
    {
        $department = Department::find($id);
        if($department){
            return view('_auth.department.dep_courses')->with('department', $department);
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }
    }

    public function getSpecializations($id)
    {
        $department = Department::find($id);
        if($department){
            return view('_auth.admin.department.dep_specs')->with('department', $department);
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }
    }

    public function userGetSpecializations($id)
    {
        $department = Department::find($id);
        if($department){
            return view('_auth.department.dep_specs')->with('department', $department);
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }
    }

    public function addSpecCreate($id)
    {
        $department = Department::find($id);
        if($department){
            $dep_spec = $department->specializations->where('id' ,'>' ,0)->pluck('id')->toArray();
            $specializations = Specialization::all()->whereNotIn('id', $dep_spec);
            return view('_auth.admin.department.add_spec')->with([
                'department' => $department,
                'specializations' => $specializations
            ]);
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }

    }
    public function addSpecStore(Request $request, $id)
    {
        $department = Department::find($id);
        if($department){
            $dep_spec = $department->specializations->where('id' ,'>' ,0)->pluck('id')->toArray();
            $this->validate($request, [
                'specialization' => [
                    'required',
                    Rule::notIn($dep_spec)
                ],
            ]);
            $spec = Specialization::find($request->specialization);
            if ($department->specializations()->save($spec)){
                return redirect()->back()->with('success', 'Department updated successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }


    }
    public function specDestroy(Request $request, $id)
    {
        $department = Department::find($request->dep_id);
        if($department){
            if($request->ajax()){
                return ($department->specializations()->detach($id))? 1:0;
            }else{
                if($department->specializations()->detach($id)){
                    return redirect()->back()->with('success', 'Department updated Successfully');
                }else{
                    return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
                }
            }
        }else{
            return redirect()->back()->with('error', 'Department not found');
        }


    }
}
