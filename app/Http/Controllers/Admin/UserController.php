<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['getUsers']]);
    }
    public function index()
    {
        $users = User::getStudents()->orderBy('level')->orderBy('dep_id')->orderBy('fname')->get();
        return view('_auth.admin.users.index')->with('users', $users);
    }
    public function getUsers(Request $request)
    {
        if($request->name == ""){
            return response()->json([
                'users' => User::getStudents()->orderBy('level')->orderBy('dep_id')->orderBy('fname')->get()
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
        $role_id = Role::where('name', 'student')->first()->id;
        $results = User::where('role_id', $role_id)
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
        return view('_auth.discussions.search')->with('results', $results)->with('discussion_id', $id);
    }
}
