<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Department;
use App\User;
use App\Role;
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
        $this->middleware(['auth', 'revalidate'], ['except' => ['destroy']]);
    }

    public function index()
    {
        // Return the list view with All Departments
        if (canRead($this->controllerName)){
            $departments = Department::all();
            return view('_auth.department.show')->with('departments', $departments);
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (canCreate($this->controllerName)){
            // Return the create view with Users from DB to use in ComboBox
            $users = User::getInstructors()->get();
            return view('_auth.department.create')->with('users', $users);
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (canCreate($this->controllerName)){
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
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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

        if (canUpdate($this->controllerName)){

            // Get Department BY id
            $department = Department::find($id);
            // Get users from DB where role is Instructor
            $users = User::getInstructors()->get();
            // Return the Edit view with Users from DB to use in ComboBox
            return view('_auth.department.edit')->with('users', $users)->with('department', $department);

        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
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
        if (canUpdate($this->controllerName)){
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
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {

        if (canDelete($this->controllerName)){

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
        }else{
            if($request->ajax())return 0;
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }
    public function getCourses($id)
    {
        $department = Department::find($id);
        return view('_auth.department.dep_courses')->with('department', $department);
    }
    public function getSpecializations($id)
    {
        $department = Department::find($id);
        return view('_auth.department.dep_specs')->with('department', $department);
    }
}
