<?php

namespace App\Http\Controllers;

use App\Course;
use App\gradeBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\ActionLog;

class GradesBookController extends Controller
{
    private $controllerName = "Course";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }

    public function index(Course $course)
    {
        if(canRead($this->controllerName)){
            $course_id = $course->id;
            $gradesBooks= gradeBook::where('course_id',$course->id)->get();
            //$practical=$gradesBooks->practical_weight
            //$totalweights=  $gradesBooks->assignments_weight + $gradesBooks->quizzes_weight + $gradesBooks->midterm_weight + $gradesBooks->finalexam_weight + $gradesBooks->practical_weight;

            if (Auth::user()->isInstructor()){
                return view('_auth.gradesBook.index', compact( 'course','gradesBooks','course_id'));
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
    public function create(Course $course)
    {
        if(canCreate($this->controllerName)){
            $course = Course::find($course->id);

            if (Auth::user()->isInstructor()){
                return view('_auth.gradesBook.create', compact( 'gradebook','course'));
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
    public function store(Request $request,Course $course)
    {
        if(canCreate($this->controllerName)){
            if ($request->assw == null || $request->quizw == null || $request->midw == null || $request->finalw == null) {
                Session::flash('error', 'Please be sure you fill out the required fields.');
                return redirect()->back()->withInput();
            } else {
                if (gradeBook::where('course_id', '=', $course->id)->exists()){
                    return redirect()->back()->with('error', 'Grade book already exist ');
                }
                else{
                    $gradebook = new gradeBook;
                    $gradebook ->assignments_weight = $request->input('assw') / 100;
                    $gradebook ->quizzes_weight = $request->input('quizw') /100;
                    $gradebook ->midterm_weight = $request->input('midw') /100;
                    $gradebook ->finalexam_weight = $request->input('finalw') /100;
                    $gradebook ->course_id= $course->id;

                    if (!empty($request->input('practw'))) {
                        $gradebook ->practical_weight = $request->input('practw') /100;
                    }


                    if ($gradebook->save()){
                        ActionLog::create([
                            'subject' => 'user',
                            'subject_id' => Auth::user()->id,
                            'action' => 'create',
                            'type' => 'gradebook',
                            'type_id' => $gradebook->id,
                            'object' => 'course',
                            'object_id' => $course_id
                        ]);
                        return redirect()->back()->with('success', 'Grade Book created successfully');
                    }else{
                        return redirect()->back()->with('error', 'An Error Occurred ');
                    }
                }
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
    public function edit(Course $course,gradeBook $gradebook)
    {
        if(canUpdate($this->controllerName)){

            $course_id = $course->id;
            //dd($gradebook);
            if (Auth::user()->isInstructor()){
                return view('_auth.gradesBook.edit', compact( 'gradebook','course_id'));
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
    public function update(Request $request, Course $course,gradeBook $gradebook)
    {
        if(canUpdate($this->controllerName)){
            //dd($gradebook);

            $gradebook ->assignments_weight = $request->input('assw') / 100;
            $gradebook ->quizzes_weight = $request->input('quizw') /100;
            $gradebook ->midterm_weight = $request->input('midw') /100;
            $gradebook ->finalexam_weight = $request->input('finalw') /100;
            $gradebook ->finalexam_weight = $request->input('finalw') /100;
            $gradebook ->practical_weight = $request->input('practw') /100;



            if ($gradebook->save()){
                ActionLog::create([
                    'subject' => 'user',
                    'subject_id' => Auth::user()->id,
                    'action' => 'update',
                    'type' => 'gradebook',
                    'type_id' => $gradebook->id,
                    'object' => 'course',
                    'object_id' => $course_id
                ]);
                return redirect()->back()->with('success', 'Grade Book updated successfully');
            }else{
                return redirect()->back()->with('error', 'An Error Occurred ');
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
    public function destroy($id)
    {
        if(canDelete($this->controllerName)){

        }else{

        }
    }
}
