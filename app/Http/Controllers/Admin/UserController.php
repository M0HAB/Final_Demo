<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Department;
use App\Http\Controllers\PermissionRoleController;
use App\Pindex;
use Session;
use Validator;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['getUsers', 'destroy']]);
    }
    public function index()
    {
        $users = User::getStudents()->withTrashed()->orderBy('level')->orderBy('dep_id')->orderBy('fname')->get();
        $departments = Department::all();
        $roles = Role::all();
        return view('_auth.admin.users.index')->with('users', $users)->with('departments', $departments)->with('roles', $roles);
    }
    public function getUsers(Request $request)
    {

        if($request->name == ""){
            $users = User::withTrashed()->where('role_id', $request->type)->orderBy('level')->orderBy('dep_id')->orderBy('fname')->take(30)->get();
            $users->transform(function ($item, $key) {
                if($item->trashed()){
                    $item['trashed'] = true;
                }
                $item['dep_id'] = $item->department->name;
                return $item;
            });
            return response()->json([
                'body' => view('_auth.admin.users.search_partial')->with('users', $users)->render()
            ]);
        }
        $fname = "NULL";
        $lname = "";
        $name = explode(" ",$request->name);
        if(isset($name[0])){
            $fname = $name[0];
        }
        if(isset($name[1])){
            $lname = $name[1];
        }
        $results = User::withTrashed()->where('role_id', $request->type)
        ->whereRaw('(fname LIKE "'.$fname.'%" and lname LIKE "'.$lname.'%")')
        ->orderBy('level')->orderBy('dep_id')
        ->orderBy('fname')->take(30)->get();
        $results->transform(function ($item, $key) {
            if($item->trashed()){
                $item['trashed'] = true;
            }
            $item['dep_id'] = $item->department->name;
            return $item;
        });

        if($request->ajax()){
          return response()->json([
              'body' => view('_auth.admin.users.search_partial')->with('users', $results)->render()
          ]);
        }
        //incase of non ajax call
        return 1;
    }
    public function profile(Request $request)
    {
        $id = $request->id;
        $user = User::withTrashed()->find($id);
        $pindexes = Pindex::all();
        $PRC = new PermissionRoleController;
        $envelope = $PRC->getAndCombinePermissions($pindexes,$user);
        // dd($envelope);
        if($user){
            return view('_auth.admin.users.profile')->with('user', $user);
        }else{
            return "404";
        }
    }
    public function destroy(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        if($user->trashed()){
            return ($user->restore())? 1:0;
        }
        if($request->ajax()){
          return ($user->delete())? 1:0;
        }else{
          if($user->delete()){
              return redirect()->back()->with('success', 'Role Deleted Successfully');
          }else{
              return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
          }
        }
    }
    public function edit(Request $request)
    {
        $user = User::withTrashed()->find($request->id);
        $deps = Department::all();
        $roles = Role::all();
        $inputs=[
            'fname' => $user->fname, 'lname' => $user->lname,
            'email' => $user->email, 'email_confirmation'=>$user->email,
            'department' => $user->dep_id, 'gender' => $user->gender,
            'role' => $user->role_id, 'location' => $user->location,
            'level' => $user->level, 'gpa' => $user->gpa
        ];
        Session::flashInput($inputs);
        return view('_auth.admin.users.edit')->with([
            'user' => $user,
            'deps' => $deps,
            'roles' => $roles
        ]);
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $user = User::withTrashed()->find($id);
        if($user){
            $rules =  [
                'fname' => 'required|min:3|max:100',
                'lname' => 'required|min:3|max:100',
                'email' => 'required|confirmed|email||unique:users,email,'.$id.'|max:100',
                'department' => 'required|max:2',
                'gender' => 'required|max:1',
                'location' => 'required|max:255'
            ];
            $messages =  [
                'fname.required' => 'First name is required',
                'fname.min' => 'First name must be at least 3 characters.',
                'lname.required' => 'Last name is required',
                'lname.min' => 'Last name must be at least 3 characters.',
                'email.required' => 'Email is required',
                'department.required' => 'Department is required',
                'gender.required' => 'Gender is required',
                'location.required' => 'Location field is required'
            ];
            if($user->isStudent()){
              $rules['level'] = 'required|max:255';
              $rules['gpa'] = 'required|max:255';
              $messages['level.required'] = 'level is required';
              $messages ['gpa.required'] = 'GPA field is required';
            }
            // Apply validation rules on incoming request
            $validator = Validator::make($request->all(), $rules, $messages);

            // If incoming request is valid
            if ($validator->passes())
            {

                $request['dep_id'] = $request->department;
                $input = array_except($request->all(), ['_token', 'email_confirmation']);
                $user->update($input);
                // After creating new user return json response with success. message
                return response()->json(['success' => 'User Edited Successfully']);
            }
            // If incoming request not valid then return a json response with error bags
            return response()->json(['error' => $validator->errors()->all()]);

        }else{
            return redirect()->route('error.api', 'Not Found');
        }
        /**
         * Override laravel default validation messages
         * Not the best way to customize validation rules and messages, not clear and reusable.
         * Refactoring..Later
        */

    }
}
