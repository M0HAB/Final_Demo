<?php

namespace App\Http\Controllers;
use App\assdeliver;
use App\Course;
use App\Module;
use Illuminate\Support\Facades\Auth;
use App\assignment;
use Input;
use Illuminate\Support\Facades\DB;
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
    public function index($course_id, $module_id)
    {
        $course = Course::find($course_id);
        $module = Module::find($module_id);
        $assignments = $module->assignments()->get();
        return view('_auth.assignments.index', compact('assignments', 'module', 'course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id, $module_id)
    {
        $course = Course::find($course_id);
        $module = Module::find($module_id);
        $authuser = Auth::user();
        if ($authuser->role == 'instructor'){
            return view('_auth.assignments.create', compact('course', 'module'));
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
    public function store(Request $request, $course_id, $module_id)
    {
        $course = Course::find($course_id);
        $module = Module::find($module_id);
        $authuser = Auth::user();
        if ($authuser->role == 'instructor'){

            // Validate Form submitted data

            $this->validate($request, [
                'asstitle' => 'required',
                'assdescription' => 'required',
                'deadline' => 'required',
                'upload_file' => 'max:10000|mimes:doc,pdf,docx,jpeg,png,jpg,pptx'

           ]);
           // dd($request->upload_file);
            // Create new assignment
            $assall     = assignment::all();
            $assignment = new assignment;
            $assignment->module_id = $module->id;
            $assignment->title = $request->input('asstitle');
            $assignment->description = $request->input('assdescription');
            $assignment->deadline = $request->input('deadline');
            $assignment->full_mark = $request->input('fullmark');


            //upload files
            if ($request->hasFile('upload_file')) {

                $upfile=$request->file('upload_file');
                $fileName=time() . $upfile->getClientOriginalName();
                $destinationPath = 'uploads/assignments';
                //dd($upfile);

                $file= $upfile->move($destinationPath, $fileName);

                $assignment->file = $fileName;
            }



            if ($assignment->save()){
                return redirect('Courses/'. $course_id .'/Modules/'. $module_id .'/assignments')->with('success', 'Assignment created successfully');
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
    public function show($course_id, $module_id, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $module_id, $ass_id)
    {
        $modules = DB::table('modules')->orderByRaw('module_order')->get();
        $course = Course::find($course_id);
        $module = Module::find($module_id);
        $authuser = Auth::user();
        if ($authuser->role == 'instructor'){

            $assignment = assignment::find($ass_id);

                return view('_auth.assignments.edit', compact('assignment', 'course', 'module', 'modules'));

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
    public function update(Request $request,$course_id, $module_id, $id)
    {
        $authuser = Auth::user();
        if ($authuser->role == 'instructor'){

                $modules_id_values =  DB::table('modules')->selectRaw('id')->get()->toArray();

                // Validate Form submitted data
                $this->validate($request, [
                    'asstitle' => 'required',
                    'assdescription' => 'required',
                    'deadline' => 'required',

            ]);
            // Update Assignment
            $assall     = assignment::all();
            $assignment = assignment::find($id);
            $assold = $assignment->full_mark;
            $assignment->module_id = $module_id;
            $assignment->title = $request->input('asstitle');
            $assignment->description = $request->input('assdescription');
            $assignment->deadline = $request->input('deadline');
            $assignment->full_mark = $request->input('fullmark');


            //upload files
            if ($request->hasFile('upload_file')) {

                $upfile=$request->file('upload_file');
                $fileName=time() . $upfile->getClientOriginalName();
                $destinationPath = 'uploads';
                

                $file= $upfile->move($destinationPath, $fileName);

                $assignment->file = $fileName;

            }



            if ($assignment->save()){
                    return redirect()->back()->with('success', 'Assignment updated successfully')->withInput();
                }
            else{
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
    public function destroy($course_id, $module_id, $id)
    {
        $authuser = Auth::user();
        if ($authuser->role == 'instructor'){
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

            //student deliver assignments

    public function deliver($course_id, $module_id, $id)
    {

        $course = Course::find($course_id);
        $module = Module::find($module_id);
        $authuser = Auth::user();
        if ($authuser->role == 'student'){

            $assignment = assignment::find($id);
            $userid=$authuser->id;
            $assdelivered= assdeliver::where([
                'user_id' => $userid,
                'ass_id' => $assignment->id,
            ]);


          //  dd($assdelivered->exists() );
          


            return view('_auth.assignments.deliver', compact('assignment','assdelivered','course','module'));

        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }

    public function deliverstore($course_id, $module_id,  Request $request)

    {

       // dd($request);
        $authuser = Auth::user();
        if ($authuser->role == 'student'){

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
                return redirect('Courses/' . $course_id .'/Modules/' . $module_id . '/assignments')->with('success', 'Assignment Submitted successfully');
            }else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }

        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }
    //instructor show delivered assignments

    public function delivered($course_id, $module_id)
    {

        $authuser = Auth::user();
        //$assignments = assignment::all();
        if ($authuser->role == 'instructor'){
            $assdelivered = DB::table('assdelivers')
                ->leftjoin('assignments', 'assignments.id', '=', 'assdelivers.ass_id')
                ->leftjoin('users', 'users.id', '=', 'assdelivers.user_id')
                ->select('assdelivers.*', 'assignments.id as ass_id','assignments.title', 'assignments.module_id', 'assignments.deadline','assignments.full_mark', 'users.fname')
                ->where('assignments.module_id', '=', $module_id)
                ->get();


            return view('_auth.assignments.showdelivered')->with('assdelivered', $assdelivered);

        }elseif($authuser->role == 'student'){
            $assdelivered = DB::table('assdelivers')
                ->leftjoin('assignments', 'assignments.id', '=', 'assdelivers.ass_id')
                ->leftjoin('users', 'users.id', '=', 'assdelivers.user_id')
                ->select('assdelivers.*', 'assignments.title', 'assignments.module_id', 'assignments.deadline', 'users.fname')
                ->where('assignments.module_id', '=', $module_id)
                ->where('assdelivers.user_id', '=', $authuser->id)
                ->get();

            return view('_auth.assignments.showdelivered')->with('assdelivered',$assignments, $assdelivered);
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }
public function deliveredEdit($id){

    $delivered = assdeliver::findOrFail($id);



    return view('_auth.assignments.editdelivered',compact('delivered'));


}
public function deliveredUpdate(Request $request, $id){

//dd($request);
    $delivered = assdeliver::findOrFail($id);
    //dd($delivered);
    $delivered->comment = $request->input('comment');
    $delivered->grade   = $request->input('grade');
    if ($delivered->save()) {
        return redirect()->back()->with('success', 'Delivered Assignment updated successfully');
    }
    else{

        return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
    }

}



}
