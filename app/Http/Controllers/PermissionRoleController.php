<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Role;
use Session;
use App\User;
use App\Pindex;
use App\ActionLog;

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
    public function getAndCombinePermissions($pindexes,$role)
    {
      $envelope =array();
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

    private function encodePermissions(Request $request){
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
      return $permission;
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
        $role->permission = $this->encodePermissions($request);
        if ($role->save()){
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'create',
                'type' => 'role',
                'type_id' => $role->id
            ]);
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
        $envelope['name'] = $role->name;
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
        $envelope['name'] = $role->name;
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
        $role = Role::find($id);
        if($id != 1 && $id != 2){
            $rules =  [
                'name' => 'sometimes|required|max:100|unique:roles,name,'.$id
            ];
            $messages =  [
                'name.required' => 'Role name is required',
                'name.unique' => 'Role name must be unique.',
                'name.max' => 'Role name is 100 chars max'
            ];
            $this->validate($request, $rules, $messages);
            $role->permission = $this->encodePermissions($request);
            $name = ucfirst(strtolower($request->input('name')));
            $role->name = $name;
            $same = ($role->name == Role::find($id)->name && $role->permission == Role::find($id)->permission );

        }else{
            $role->permission = $this->encodePermissions($request);
            $same = ($role->permission == Role::find($id)->permission );
        }
        if($same){
          return redirect()->back()->with('warning', 'Same Value Resubmittion');
        }
        if ($role->save()){
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'update',
                'type' => 'role',
                'type_id' => $role->id
            ]);
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
        if($id != 1 && $id != 2){
            $role = Role::find($id);
            if($request->ajax()){
                ActionLog::create([
                    'subject' => 'admin',
                    'subject_id' => Auth::user()->id,
                    'action' => 'delete',
                    'type' => 'role',
                    'type_id' => $role->id
                ]);
              return ($role->delete())? 1:0;
            }else{
              if($role->delete()){
                  ActionLog::create([
                      'subject' => 'admin',
                      'subject_id' => Auth::user()->id,
                      'action' => 'delete',
                      'type' => 'role',
                      'type_id' => $role->id
                  ]);
                  return redirect()->back()->with('success', 'Role Deleted Successfully');
              }else{
                  return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
              }
            }
        }else{
            return redirect()->back()->with('error', 'Operation Not Allowed');
        }


    }

    public function viewUserPermission(Request $request)
    {
        $user = User::withTrashed()->find($request->id);
        $pindexes = Pindex::all();
        $envelope = $this->getAndCombinePermissions($pindexes, $user);
        if(empty($envelope)){
            $user['empty'] = true;
        }
        Session::flashInput($envelope);
        return view('_auth.admin.permission_role.user_role')->with('user', $user)->with('pindexes', $pindexes);
    }

    public function setUserPermission(Request $request)
    {
        $user = User::withTrashed()->find($request->id);
        if(isset($_POST['revert'])){
            if($user->permission === null){
                return redirect()->back()->with('warning', 'Permissions are already at default');
            }
            $user->permission =null;
            $user->save();
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'reset',
                'type' => 'user_permission',
                'type_id' => $user->id
            ]);
            return redirect()->back()->with('success', 'Permissions Reverted Successfully');
        }else{
            $permission = $this->encodePermissions($request);
            $user->permission = $permission;
            $user->save();
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'update',
                'type' => 'user_permission',
                'type_id' => $user->id
            ]);
            return redirect()->back()->with('success', 'Permissions Updated Successfully');

        }

    }

}
