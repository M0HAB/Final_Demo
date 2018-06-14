<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Pindex;

class PIndexController extends Controller
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
        $pindex = Pindex::all();
        return view('_auth.admin.permission_index.show')->with('pindex', $pindex);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pindex = Pindex::find($id);
        return view('_auth.admin.permission_index.edit')->with('pindex', $pindex);
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
            'pindex' => 'required',
        ]);
        $pindex = Pindex::find($id);
        $newname =  ucfirst($request->input('pindex'));
        if ($pindex->name != $newname){
            $pindex->name = $newname;
            if ($pindex->save()){
                return redirect()->route('pindex.index')->with('success', 'Permission Index updated successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }else{
            return redirect()->back()->with('warning', 'Same Value resubmittion');
        }
    }

}
