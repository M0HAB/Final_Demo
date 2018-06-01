<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Permission;

class PermissionController extends Controller
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

    //PERMISSION INDEX CONTROLLER
    
    public function index()
    {
        $pIndex = Permission::all();
        return view('_auth.admin.permission_index.show')->with('pIndex', $pIndex);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('_auth.admin.permission_index.edit')->with('permission', $permission);
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
        //todo::add more validations
        $this->validate($request, [
            'permission' => 'required',
        ]);
        $permission = Permission::find($id);
        $newname =  ucfirst($request->input('permission'));
        if ($permission->name != $newname){
            $permission->name = $newname;
            if ($permission->save()){
                return redirect()->route('permission.index')->with('success', 'Permission updated successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }else{
            return redirect()->back()->with('warning', 'Same Value resubmittion');
        }
    }

}
