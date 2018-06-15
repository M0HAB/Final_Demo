<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Specialization;

class SpecializationController extends Controller
{
    protected $controllerName = "Specialization";
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate'], ['except' => ['destroy']]);
    }

    public function index()
    {
        // Return the list view with All Specializations
        if (canRead($this->controllerName)){
            $specializations = Specialization::all();
            return view('_auth.specialization.show')->with('specializations', $specializations);
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        if (canCreate($this->controllerName)){

            return view('_auth.specialization.create');
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (canCreate($this->controllerName)){
            //TODO :: add More Validation Rules
            // Validate Form submitted data
            $this->validate($request, [
                'specialization' => 'required',
            ]);
            // Create new Specialization
            $specialization = new Specialization;
            $specialization->name = $request->input('specialization');
            // If succesfully updated display success else error
            if ($specialization->save()){
                return redirect()->back()->with('success', 'Specialization created successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
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
        // Find Specialization with id
        $specialization = Specialization::find($id);
        // Return View with the data
        return view('_auth.specialization.view')->with('specialization', $specialization);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        if (canUpdate($this->controllerName)){

            // Get Specialization BY id
            $specialization = Specialization::find($id);
            return view('_auth.specialization.edit')->with('specialization', $specialization);

        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

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
        if (canUpdate($this->controllerName)){
            //TODO :: add More Validation Rules
            $this->validate($request, [
                'specialization' => 'required',
            ]);
            // Update Specialization
            $specialization = Specialization::find($id);
            $newname =  $request->input('specialization');
            if ($specialization->name != $newname){
                $specialization->name = $newname;
                if ($specialization->save()){
                    return redirect()->back()->with('success', 'Specialization updated successfully');
                }else{
                    return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
                }
            }else{
                return redirect()->back()->with('warning', 'Same Value resubmittion');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
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

        if (canDelete($this->controllerName)){

          $specialization = Specialization::find($id);
          if($request->ajax()){
            return ($specialization->delete())? 1:0;
          }else{
            if($specialization->delete()){
                return redirect()->back()->with('success', 'Specialization Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
          }
        }else{
            if($request->ajax())return 0;
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }
    public function getCourses($id)
    {
        $specialization = Specialization::find($id);
        return view('_auth.specialization.spec_courses')->with('specialization', $specialization);
    }
    public function getDepartments($id)
    {
        $specialization = Specialization::find($id);
        return view('_auth.specialization.spec_deps')->with('specialization', $specialization);
    }
}
