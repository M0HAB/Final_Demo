<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Role;
use Session;
use App\Permission;

class PermissionRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //PERMISSION ROLE CONTROLLER

    public function index()
    {
        $perRole = Role::all();
        return view('_auth.admin.permission_role.show')->with('perRole', $perRole);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('_auth.admin.permission_role.create')->with('permissions', $permissions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =  [
            'name' => 'required|unique:roles|max:100' 
        ];
        $messages =  [
            'name.required' => 'Role name is required',
            'name.unique' => 'Role name must be unique.',
            'name.max' => 'Role name is 100 chars max'
        ];
        $this->validate($request, $rules, $messages);
        $name = ucfirst(strtolower($request->input('name')));
        $role = new Role;
        $role->name = $name;
        $binary="";
        $moduleCount = Permission::count();//remember to change generic if works
        for ($i = 1;$i<=$moduleCount;$i++){
            $c= ($request->input('create'.$i) == null)? 0:1;
            $r= ($request->input('read'.$i) == null)? 0:1;
            $u= ($request->input('update'.$i) == null)? 0:1;
            $d= ($request->input('delete'.$i) == null)? 0:1;
            $binary .= $c.$r.$u.$d;
        }
        $permission = bindec($binary);
        $role->permission = $permission;
        if ($role->save()){
            return redirect()->back()->with('success', 'Role Created Successfully');                
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
        $pRole = Role::find($id)->permission;
        $envelope =array();
        $permissions = Permission::all();
        $sectionsNumber = count($permissions);
        $hex = dechex( (int) $pRole);
        while (strlen($hex)<$sectionsNumber){
            $hex = "0" . $hex;
        }
        foreach($permissions as $pIndexName){
            $permission = hex2binPer($hex,$pIndexName->index);
            $create = substr($permission, 0,1);
            $read = substr($permission, 1,1);
            $update = substr($permission, 2,1);
            $delete = substr($permission, 3,1);
            $envelope[$pIndexName->index] = [
                "name" => $pIndexName->name, "create"=>$create,
                "read" => $read, "update"=>$update, "delete"=>$delete
            ];
        }
        return view('_auth.admin.permission_role.view')->with('envelope', $envelope);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('_auth.admin.permission_role.edit');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo "Deleted";
    }
}
