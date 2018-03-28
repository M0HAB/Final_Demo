<?php

namespace App\Http\Controllers;
use App\assdeliver;
use Illuminate\Support\Facades\Auth;
use App\assignment;
use Input;
use App\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }
    public function index()
    {
        $assignments = assignment::all();
        return view('_auth.assignments.index')->with('assignments', $assignments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $authuser = Auth::user();
        if ($authuser->role == 'Instructor'){

            return view('_auth.assignments.create');
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
        $authuser = Auth::user();
        if ($authuser->role == 'Instructor'){

            // Validate Form submitted data

            $this->validate($request, [
                'asstitle' => 'required',
                'assdescription' => 'required',
                'deadline' => 'required',
                'module' => 'required',
                'upload_file' => 'max:10000|mimes:doc,pdf,docx,jpeg,png,jpg'

           ]);
           // dd($request->upload_file);
            // Create new assignment
            $assignment = new assignment;
            $assignment->module_id = $request->input('module');
            $assignment->title = $request->input('asstitle');
            $assignment->description = $request->input('assdescription');
            $assignment->deadline = $request->input('deadline');


            //upload files
            if ($request->hasFile('upload_file')) {

                $upfile=$request->file('upload_file');
                $fileName=time() . $upfile->getClientOriginalName();
                $destinationPath = 'uploads/assignments';
                //dd($upfile);

                $file= $upfile->move($destinationPath, $fileName);

                $assignment->file = $fileName;
            }


            // If successfully updated display success else error
            if ($assignment->save()){
                return redirect('/assignments')->with('success', 'Assignment created successfully');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $authuser = Auth::user();
        if ($authuser->role == 'Instructor'){

            $assignment = assignment::find($id);

                return view('_auth.assignments.edit', compact('assignment'));

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
        $authuser = Auth::user();
        if ($authuser->role == 'Instructor'){

                // Validate Form submitted data

                $this->validate($request, [
                    'asstitle' => 'required',
                    'assdescription' => 'required',
                    'deadline' => 'required',
                    'module' => 'required',

            ]);
            // Update Assignment
            $assignment = assignment::find($id);

            $assignment->module_id = $request->input('module');
            $assignment->title = $request->input('asstitle');
            $assignment->description = $request->input('assdescription');
            $assignment->deadline = $request->input('deadline');

            //upload files
            if ($request->hasFile('upload_file')) {

                $upfile=$request->file('upload_file');
                $fileName=time() . $upfile->getClientOriginalName();
                $destinationPath = 'uploads';
                

                $file= $upfile->move($destinationPath, $fileName);

                $assignment->file = $fileName;

            }


            if ($assignment->save()){
                    return redirect()->back()->with('success', 'Department updated successfully')->withInput();
                }else{
                    return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
                }
            }


        else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $authuser = Auth::user();
        if ($authuser->role == 'Instructor'){
            $assignment = assignment::findOrFail($id);

            if ($assignment->delete()){
                return redirect()->back()->with('success', 'Assignment Deleted successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }


    public function deliver($id)
    {


        $authuser = Auth::user();
        if ($authuser->role == 'Student'){

            $assignment = assignment::find($id);
            $userid=$authuser->id;
            $assdelivered= assdeliver::where([
                'user_id' => $userid,
                'ass_id' => $assignment->id,
            ]);


          //  dd($assdelivered->exists() );


            return view('_auth.assignments.deliver', compact('assignment','assdelivered'));

        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }

    public function deliverstore(Request $request)

    {

       // dd($request);
        $authuser = Auth::user();
        if ($authuser->role == 'Student'){

            // Validate Form submitted data

            $this->validate($request, [
                'assignment_answer' => 'required_without:upload_file',
                'upload_file' => 'required_without:assignment_answer| max:10000|mimes:doc,pdf,docx,jpeg,png,jpg',
                'assid' => 'required'

            ]);

            // Create new assignment submit
            $deliver = new assdeliver;
            $deliver->answer = $request->input('assignment_answer');
            $deliver->user_id = $authuser->id;
            $deliver->ass_id = $request->input('assid');



            //upload files
            if ($request->hasFile('upload_file')) {

                $upfile=$request->file('upload_file');
                $fileName=time() . $upfile->getClientOriginalName();
                $destinationPath = 'uploads/assignments/delivered';
                //dd($upfile);

                $file= $upfile->move($destinationPath, $fileName);

                $deliver->file = $fileName;
            }


            // If successfully updated display success else error
            if ($deliver->save()){
                return redirect('/assignments')->with('success', 'Assignment Submitted successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }

        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }


}
