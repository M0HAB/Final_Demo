<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialization;
use Auth;
use App\ActionLog;

class SpecializationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['destroy', 'userIndex', 'userShow', 'specDestroy', 'userGetCourses', 'userGetDepartments']]);
        $this->middleware(['auth', 'revalidate'], ['only' => ['userIndex', 'userShow', 'userGetCourses', 'userGetDepartments']]);
    }

    public function userIndex()
    {
        $specializations = Specialization::all();
        return view('_auth.specialization.show')->with('specializations', $specializations);
    }

    public function index()
    {
        $specializations = Specialization::all();
        return view('_auth.admin.specialization.show')->with('specializations', $specializations);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('_auth.admin.specialization.create');
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
            'specialization' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
        ]);
        // Create new Specialization
        $specialization = new Specialization;
        $specialization->name = $request->input('specialization');
        // If succesfully updated display success else error
        if ($specialization->save()){
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'create',
                'type' => 'specialization',
                'type_id' => $specialization->id
            ]);
            return redirect()->back()->with('success', 'Specialization created successfully');
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
    public function userShow($id)
    {
        // Find Specialization with id
        $specialization = Specialization::find($id);
        // Return View with the data
        return view('_auth.specialization.view')->with('specialization', $specialization);
    }

    public function show($id)
    {
        // Find Specialization with id
        $specialization = Specialization::find($id);
        // Return View with the data
        return view('_auth..admin.specialization.view')->with('specialization', $specialization);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Get Specialization BY id
        $specialization = Specialization::find($id);
        return view('_auth.admin.specialization.edit')->with('specialization', $specialization);
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
            'specialization' => 'required|regex:/^[a-zA-Z0-9\s]+$/',
        ]);
        // Update Specialization
        $specialization = Specialization::find($id);
        $newname =  $request->input('specialization');
        if ($specialization->name != $newname){
            $specialization->name = $newname;
            if ($specialization->save()){
                ActionLog::create([
                    'subject' => 'admin',
                    'subject_id' => Auth::user()->id,
                    'action' => 'update',
                    'type' => 'specialization',
                    'type_id' => $specialization->id
                ]);
                return redirect()->back()->with('success', 'Specialization updated successfully');
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
    public function destroy(Request $request,$id)
    {
        $specialization = Specialization::find($id);
        if($request->ajax()){
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'delete',
                'type' => 'specialization',
                'type_id' => $specialization->id
            ]);
            return ($specialization->delete())? 1:0;
        }else{
            if($specialization->delete()){
                ActionLog::create([
                    'subject' => 'admin',
                    'subject_id' => Auth::user()->id,
                    'action' => 'delete',
                    'type' => 'specialization',
                    'type_id' => $specialization->id
                ]);
                return redirect()->back()->with('success', 'Specialization Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }
    }

    public function userGetCourses($id)
    {
        $specialization = Specialization::find($id);
        return view('_auth.specialization.spec_courses')->with('specialization', $specialization);
    }
    public function userGetDepartments($id)
    {
        $specialization = Specialization::find($id);
        return view('_auth.specialization.spec_deps')->with('specialization', $specialization);
    }

    public function getCourses($id)
    {
        $specialization = Specialization::find($id);
        return view('_auth.admin.specialization.spec_courses')->with('specialization', $specialization);
    }
    public function getDepartments($id)
    {
        $specialization = Specialization::find($id);
        return view('_auth.admin.specialization.spec_deps')->with('specialization', $specialization);
    }
}
