<?php

namespace App\Http\Controllers;

use App\Course;
use App\gradeBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradesBookController extends Controller
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

    public function index($course_id)
    {
        $course  = Course::find($course_id);
        $gradesBooks= gradeBook::where('course_id',$course_id)->get();
        //$practical=$gradesBooks->practical_weight
        //$totalweights=  $gradesBooks->assignments_weight + $gradesBooks->quizzes_weight + $gradesBooks->midterm_weight + $gradesBooks->finalexam_weight + $gradesBooks->practical_weight;

        if (Auth::user()->isInstructor()){
            return view('_auth.gradesBook.index', compact( 'course','gradesBooks','course_id'));
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $course = Course::find($course_id);



        if (Auth::user()->isInstructor()){
            return view('_auth.gradesBook.create', compact( 'gradebook','course'));
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
    public function store(Request $request,$course_id)
    {
        $course = Course::find($course_id);


        if (gradeBook::where('course_id', '=', $course_id)->exists()){
            return redirect()->back()->with('error', 'Grade book already exist ');
        }
        else{
        $gradebook = new gradeBook;
        $gradebook ->assignments_weight = $request->input('assw') / 100;
        $gradebook ->quizzes_weight = $request->input('quizw') /100;
        $gradebook ->midterm_weight = $request->input('midw') /100;
        $gradebook ->finalexam_weight = $request->input('finalw') /100;
        $gradebook ->course_id= $course_id;

        if (!empty($request->input('practw'))) {
            $gradebook ->practical_weight = $request->input('practw') /100;
        }


        if ($gradebook->save()){
            return redirect()->back()->with('success', 'Grade Book created successfully');
        }else{
            return redirect()->back()->with('error', 'An Error Occurred ');
        }
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
    public function edit($course_id,$gradesBook_id)
    {
        $gradebook=gradeBook::find($gradesBook_id)  ;

        //dd($gradesBook_id);


        if (Auth::user()->isInstructor()){
            return view('_auth.gradesBook.edit', compact( 'gradebook','course_id'));
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
    public function update(Request $request, $course_id,$gradebook_id)
    {
        //dd($gradebook_id);
        $gradebook = gradeBook::findOrFail($gradebook_id);

        $gradebook ->assignments_weight = $request->input('assw') / 100;
        $gradebook ->quizzes_weight = $request->input('quizw') /100;
        $gradebook ->midterm_weight = $request->input('midw') /100;
        $gradebook ->finalexam_weight = $request->input('finalw') /100;
        $gradebook ->finalexam_weight = $request->input('finalw') /100;
        $gradebook ->practical_weight = $request->input('practw') /100;



        if ($gradebook->save()){
            return redirect()->back()->with('success', 'Grade Book updated successfully');
        }else{
            return redirect()->back()->with('error', 'An Error Occurred ');
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
        //
    }
}
