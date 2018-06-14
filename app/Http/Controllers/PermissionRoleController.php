<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Role;
use Session;
use App\Pindex;

class PermissionRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['destroy']]);
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
        $pindexes = Pindex::all();
        return view('_auth.admin.permission_role.create')->with('pindexes', $pindexes);
    }
    private function getAndCombinePermissions($pindexes,$role)
    {
      $envelope =array();
      $envelope['name'] = $role->name;
      $sectionsNumber = count($pindexes);
      $hex = dechex( (int) $role->permission);
      while (strlen($hex)<$sectionsNumber){
          $hex = "0" . $hex;
      }
      foreach($pindexes as $pindex){
          $permissions = str_split(hex2binPer($hex,$pindex->index));
          $names = ['create', 'read', 'update', 'delete'];
          foreach ($permissions as $k => $permission) {
            if($permission) $envelope[$names[$k].$pindex->index] = $permission;
          }
      }
      return $envelope;
    }

    private function decodePermissions(Request $request,$id,$type){

      $name = ucfirst(strtolower($request->input('name')));
      if($type === "update"){
        $role = Role::find($id);
      }else{
        $role = new Role;
      }
      $role->name = $name;
      $binary="";
      $moduleCount = Pindex::count();
      for ($i = 1;$i<=$moduleCount;$i++){
          $c= ($request->input('create'.$i) == null)? 0:1;
          $r= ($request->input('read'.$i) == null)? 0:1;
          $u= ($request->input('update'.$i) == null)? 0:1;
          $d= ($request->input('delete'.$i) == null)? 0:1;
          $binary .= $c.$r.$u.$d;
      }
      $permission = bindec($binary);
      $role->permission = $permission;
      return $role;
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
        $role = $this->decodePermissions($request,0,0);
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
        $role = Role::find($id);
        $pindexes = Pindex::all();
        $envelope = $this->getAndCombinePermissions($pindexes,$role);
        return view('_auth.admin.permission_role.view')->with('pindexes', $pindexes)->with('envelope', $envelope);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $role = Role::find($id);
      $pindexes = Pindex::all();
      $envelope = $this->getAndCombinePermissions($pindexes, $role);
      Session::flashInput($envelope);
      // Session::flashInput(['name'=>$role->name]);
      return view('_auth.admin.permission_role.edit')->with('role', $role)->with('pindexes', $pindexes);
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
      $rules =  [
          'name' => 'sometimes|required|max:100|unique:roles,name,'.$id
      ];
      $messages =  [
          'name.required' => 'Role name is required',
          'name.unique' => 'Role name must be unique.',
          'name.max' => 'Role name is 100 chars max'
      ];
      $this->validate($request, $rules, $messages);
      $role = $this->decodePermissions($request,$id,"update");
      if($role->name == Role::find($id)->name && $role->permission == Role::find($id)->permission ){
        return redirect()->back()->with('warning', 'Same Value Resubmittion');
      }
      if ($role->save()){
          return redirect()->back()->with('success', 'Role Updated Successfully');
      }else{
          return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
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
        $role = Role::find($id);
        if($request->ajax()){
          return ($role->delete())? 1:0;
        }else{
          if($role->delete()){
              return redirect()->back()->with('success', 'Role Deleted Successfully');
          }else{
              return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
          }
        }


    }
}
