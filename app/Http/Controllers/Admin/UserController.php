<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Department;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['getUsers']]);
    }
    public function index()
    {
        $users = User::getStudents()->orderBy('level')->orderBy('dep_id')->orderBy('fname')->get();
        $departments = Department::all();
        $roles = Role::all();
        return view('_auth.admin.users.index')->with('users', $users)->with('departments', $departments)->with('roles', $roles);
    }
    public function getUsers(Request $request)
    {

        if($request->name == ""){
            $users = User::where('role_id', $request->type)->orderBy('level')->orderBy('dep_id')->orderBy('fname')->get();
            $users->transform(function ($item, $key) {
                $item['dep_id'] = $item->department->name;
                return $item;
            });
            return response()->json([
                'users' => $users
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
        $results = User::where('role_id', $request->type)
        ->whereRaw('(fname LIKE "'.$fname.'%" and lname LIKE "'.$lname.'%")')
        ->orderBy('level')->orderBy('dep_id')
        ->orderBy('fname')->get();
        $results->transform(function ($item, $key) {
            $item['dep_id'] = $item->department->name;
            return $item;
        });

        if($request->ajax()){
          return response()->json([
              'users' => $results
          ]);
        }
        //incase of non ajax call
        return 1;
    }
    public function profile(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if($user){
            return view('_auth.admin.users.profile')->with('user', $user);
        }else{
            return "404";
        }
    }
}
