<?php

namespace App\Http\Controllers;

use App\assdeliver;
use App\grade;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class studentGradesController extends Controller
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
        $authuser = Auth::user();
        //get all students enrolled in this course
        $students = DB::table('users')
            ->leftjoin('course_user', 'course_user.user_id', '=', 'users.id')
            ->leftjoin('grades', 'grades.user_id', '=', 'users.id')
            ->leftjoin('grade_books', 'grade_books.course_id', '=', 'course_user.course_id')
            ->select('users.fname','users.lname','users.email','users.id as std_id','grades.*','grade_books.*')
            ->where('course_user.course_id', '=', $course_id)
            ->get();

       $assgrades = DB::table('assdelivers')
            ->leftjoin('assignments', 'assdelivers.ass_id', '=', 'assignments.id')
            ->leftjoin('modules', 'assignments.module_id', '=', 'modules.id')
            ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
            ->select('assdelivers.*' , 'assignments.full_mark')
            ->where('courses.id', '=', $course_id)
            ->get();
        $quizgrades = DB::table('quiz_user')
            ->leftjoin('quizzes', 'quiz_user.quiz_id', '=', 'quizzes.id')
            ->leftjoin('modules', 'quizzes.module_id', '=', 'modules.id')
            ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
            ->select('quiz_user.*' , 'quizzes.total_grade')
            ->where('courses.id', '=', $course_id)
            ->get();
        //dd($quizgrades);



        if ($authuser->role == 'instructor'){
            return view('_auth.grades.index',compact('students','assgrades','course_id','quizgrades'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id,$student_id)
    {



        $student = DB::table('users')
            ->leftjoin('course_user', 'course_user.user_id', '=', 'users.id')
            ->leftjoin('grades', 'grades.user_id', '=', 'users.id')
            ->leftjoin('courses', 'grades.course_id', '=', 'courses.id')
            ->leftjoin('modules', 'modules.course_id', '=', 'courses.id')
            ->leftjoin('assignments', 'assignments.module_id', '=', 'modules.id')
            ->leftjoin('assdelivers', 'assdelivers.ass_id', '=', 'assignments.id')
            ->leftjoin('grade_books', 'grade_books.course_id', '=', 'course_user.course_id')
            ->select('users.fname','users.lname','users.email','users.id as std_id','grades.*','grade_books.*',
                'courses.title','assignments.title as asstitle','assignments.full_mark as assfullmark' ,
                'assdelivers.grade as assgrade','assdelivers.comment','assdelivers.grade as assgrade')
            ->where('course_user.user_id', '=', $student_id)
            ->where('course_user.course_id', '=', $course_id)
            ->where('assdelivers.user_id', '=', $student_id)
            ->get();

        $assgrades = DB::table('assdelivers')
            ->leftjoin('assignments', 'assdelivers.ass_id', '=', 'assignments.id')
            ->leftjoin('modules', 'assignments.module_id', '=', 'modules.id')
            ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
            ->select('assdelivers.*' , 'assignments.full_mark')
            ->where('courses.id', '=', $course_id)
            ->get();

        $quizgrades = DB::table('quiz_user')
            ->leftjoin('quizzes', 'quiz_user.quiz_id', '=', 'quizzes.id')
            ->leftjoin('modules', 'quizzes.module_id', '=', 'modules.id')
            ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
            ->select('quiz_user.*' , 'quizzes.total_grade','quizzes.title as quiztitle','modules.title as modtitle')
            ->where('courses.id', '=', $course_id)
            ->get();





        return view('_auth.grades.show',compact('student','student_id','assgrades','quizgrades'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id,$student_id)
    {
        $authuser = Auth::user();

      $grades=grade::where('user_id', '=' ,$student_id)->first();
      $student=user::where('id', '=', $student_id)->first();

        if ($authuser->role == 'instructor'){

            return view('_auth.grades.edit',compact('grades','student'));
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
    public function update(Request $request, $course_id,$grade_id)
    {

        $grades = grade::findOrFail($grade_id);
        $grades ->midterm = $request->input('midtermgrade') ;
        $grades ->midterm_fullmark = $request->input('midtermfullmark') ;
        $grades ->finalgrade = $request->input('finalexam') ;
        $grades ->final_fullmark = $request->input('finalexamfullmark') ;

        if (($request->has('practicalgrade'))){
        $grades->practical = $request->input('practicalgrade');
        }

        elseif (($request->has('practicalfullmark'))){
            $grades->practical_fullmark = $request->input('practicalfullmark');
        }


        if ($grades->save()){
            return redirect()->back()->with('success', 'Grades updated successfully');
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
