<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Department;
use App\User;
use DB;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        // Return the list view with All Departments
        $departments = Department::all();
        return view('_auth.Department.DepShow')->with('departments', $departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Return the create view with Users from DB to use in ComboBox
        $users = User::where('role', 'Instructor')->get();
        return view('_auth.Department.DepCreate')->with('users', $users);
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
        // Count number of Students in that Department
        $students = count(User::where(['dep_id' => $id, 'role' => 'Student'])->get());
        // Append name of Deapartment Head to department variable
        $department['head_name'] = $user->fname . ' ' . $user->lname;
        // Append count of Students to department variable
        $department['student_count'] = $students;
        // Return View with the data
        return view('_auth.Department.DepViewID')->with('department', $department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get users from DB where role is Instructor
        $users = User::where('role', 'Instructor')->get();
        // Get Department BY id
        $department = Department::find($id);
        // Return the Edit view with Users from DB to use in ComboBox
        return view('_auth.Department.DepEdit')->with('users', $users)->with('department', $department);
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
    public function destroy($id)
    {
        $department = Department::find($id);
        if ($department->delete()){
            return redirect()->back()->with('success', 'Department Deleted successfully');
        }else{
            return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
        }
    }
}
