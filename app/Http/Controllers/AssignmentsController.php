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
use App\ActionLog;

class AssignmentsController extends Controller
{
    private $controllerName = 'Assignment';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }
    public function index(Course $course, Module $module)
    {
        if(canRead($this->controllerName)){
            $assignments = $module->assignments()->get();
            if(Auth::User()->checkIfUserTeachCourse($course->id) or Auth::User()->checkIfUserEnrolled($course->id)){
                return view('_auth.assignments.index', compact('assignments', 'module', 'course'));
            }else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Course $course, Module $module)
    {
        if(canCreate($this->controllerName)){
            if (Auth::user()->isInstructor() and Auth::user()->checkIfUserTeachCourse($course->id)){
                return view('_auth.assignments.create', compact('course', 'module'));
            }else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
            }
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
    public function store(Request $request, Course $course, Module $module)
    {
        if(canCreate($this->controllerName)){
            if (Auth::user()->isInstructor()){

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
                    ActionLog::create([
                        'subject' => 'user',
                        'subject_id' => Auth::user()->id,
                        'action' => 'create',
                        'type' => 'assignment',
                        'type_id' => $assignment->id,
                        'object' => 'module',
                        'object_id' => $module->id
                    ]);
                    return redirect('Courses/'. $course->id .'/Modules/'. $module->id .'/assignments')->with('success', 'Assignment created successfully');
                }else{
                    return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
                }

            }else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
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
    public function show(Course $course, Module $module, assignment $assigmment)
    {
        if(canRead($this->controllerName)){

        }else{

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course, Module $module, assignment $assignment)
    {
        if(canUpdate($this->controllerName)){
            $modules = DB::table('modules')->orderByRaw('module_order')->get();

            if (Auth::user()->isInstructor() and Auth::user()->checkIfUserTeachCourse($course->id)){

                $assignment = assignment::find($assignment->id);

                    return view('_auth.assignments.edit', compact('assignment', 'course', 'module', 'modules'));

            }else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
            }
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
    public function update(Request $request,Course $course, Module $module, assignment $assignment)
    {
        if(canUpdate($this->controllerName)){
            if (Auth::user()->isInstructor()){

                $modules_id_values =  DB::table('modules')->selectRaw('id')->get()->toArray();
                // Validate Form submitted data
                $this->validate($request, [
                    'asstitle' => 'required',
                    'assdescription' => 'required',
                    'deadline' => 'required',
                ]);
                // Update Assignment
                $assall     = assignment::all();
                $assignment = assignment::find($assignment->id);
                $assold = $assignment->full_mark;
                $assignment->module_id = $module->id;
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
                    ActionLog::create([
                        'subject' => 'user',
                        'subject_id' => Auth::user()->id,
                        'action' => 'update',
                        'type' => 'assignment',
                        'type_id' => $assigmment->id,
                        'object' => 'quiz',
                        'object_id' => $module->id
                    ]);
                    return redirect()->back()->with('success', 'Assignment updated successfully')->withInput();
                }
                else{
                    return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
                }
            }
            else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
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
    public function destroy(Course $course, Module $module, assignment $assignment)
    {
        if(canDelete($this->controllerName)){
            if (Auth::user()->isInstructor()){

                if ($assignment->delete()){
                    ActionLog::create([
                        'subject' => 'user',
                        'subject_id' => Auth::user()->id,
                        'action' => 'delete',
                        'type' => 'assignment',
                        'type_id' => $assigmment->id,
                        'object' => 'module',
                        'object_id' => $module->id
                    ]);
                    return redirect()->back()->with('success', 'Assignment Deleted successfully');
                }else{
                    return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
                }
            }else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }

            //student deliver assignments

    public function deliver(Course $course, Module $module, assignment $assignment)
    {
        if(canCreate($this->controllerName)){
            if (Auth::user()->isStudent() and Auth::user()->checkIfUserEnrolled($course->id)){

                $assdelivered = assdeliver::where([
                    'user_id' => Auth::user()->id,
                    'ass_id' => $assignment->id,
                ]);
                //Not sure about this
                if($assdelivered->exists()) return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');

                return view('_auth.assignments.deliver', compact('assignment','assdelivered','course','module'));

            }else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }


    }

    public function deliverstore(Course $course, Module $module,  Request $request)

    {
        if(canCreate($this->controllerName)){
            // dd($request);
             if (Auth::user()->isStudent()){

                 // Validate Form submitted data

                 $this->validate($request, [
                     'assignment_answer' => 'required_without:upload_file',
                     'upload_file' => 'required_without:assignment_answer| max:10000|mimes:doc,pdf,docx,jpeg,png,jpg',
                     'assid' => 'required'

                 ]);

                 // Create new assignment submit
                 $deliver = new assdeliver;
                 $deliver->answer = $request->input('assignment_answer');
                 $deliver->user_id = Auth::user()->id;
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
                     ActionLog::create([
                         'subject' => 'user',
                         'subject_id' => Auth::user()->id,
                         'action' => 'create',
                         'type' => 'ass_deliver',
                         'type_id' => $deliver->id,
                         'object' => 'assignment',
                         'object_id' => $deliver->ass_id
                     ]);
                     return redirect('Courses/' . $course->id .'/Modules/' . $module->id . '/assignments')->with('success', 'Assignment Submitted successfully');
                 }else{
                     return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
                 }

             }else{
                 return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
             }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }
    //instructor show delivered assignments

    public function delivered(Course $course, Module $module)
    {
        if(canRead($this->controllerName)){
            if (Auth::user()->isInstructor() and Auth::user()->checkIfUserTeachCourse($course->id)){
                $assdelivered = DB::table('assdelivers')
                    ->leftjoin('assignments', 'assignments.id', '=', 'assdelivers.ass_id')
                    ->leftjoin('users', 'users.id', '=', 'assdelivers.user_id')
                    ->select('assdelivers.*', 'assignments.id as ass_id','assignments.title', 'assignments.module_id', 'assignments.deadline','assignments.full_mark', 'users.fname')
                    ->where('assignments.module_id', '=', $module->id)
                    ->get();
                //dd($course->title);

                return view('_auth.assignments.showdelivered',compact('course','module','assdelivered'));

            }elseif(Auth::user()->isStudent() and Auth::user()->checkIfUserEnrolled($course->id)){
                $assdelivered = DB::table('assdelivers')
                    ->leftjoin('assignments', 'assignments.id', '=', 'assdelivers.ass_id')
                    ->leftjoin('users', 'users.id', '=', 'assdelivers.user_id')
                    ->select('assdelivers.*', 'assignments.title', 'assignments.module_id', 'assignments.deadline', 'users.fname')
                    ->where('assignments.module_id', '=', $module->id)
                    ->where('assdelivers.user_id', '=', Auth::user()->id)
                    ->get();

                return view('_auth.assignments.showdelivered',compact('course', 'module', 'assdelivered'));
            }else{
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }


    }

    public function deliveredEdit(Course $course,Module $module,assignment $assginment,User $student ,$assdel_id){

        if(canUpdate($this->controllerName)){
            $delivered = assdeliver::findOrFail($assdel_id);
            return view('_auth.assignments.editdelivered',compact('course', 'module','delivered'));
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }
    public function deliveredUpdate(Request $request,Course $course, Module $module, assdeliver $assdeliver){
        if(canUpdate($this->controllerName)){
        //dd($request);
            $delivered = assdeliver::findOrFail($assdeliver->id);
            //dd($delivered);
            $delivered->comment = $request->input('comment');
            $delivered->grade   = $request->input('grade');
            if ($delivered->save()) {
                ActionLog::create([
                    'subject' => 'user',
                    'subject_id' => Auth::user()->id,
                    'action' => 'update',
                    'type' => 'ass_deliver',
                    'type_id' => $delivered->id,
                    'object' => 'quiz',
                    'object_id' => $delivered->ass_id
                ]);
                return redirect()->back()->with('success', 'Delivered Assignment updated successfully');
            }
            else{
                return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }


    }



}
