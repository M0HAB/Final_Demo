<?php

namespace App\Http\Controllers;

use App\assdeliver;
use App\Course;
use App\grade;
use App\gradeBook;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ActionLog;

class studentGradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $controllerName = "Grade";

    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }

    public function index(Course $course)
    {
        if(canRead($this->controllerName)){

            $course_id = $course->id;

            if (Auth::user()->isInstructor()){
                //get all students enrolled in this course
                $students = DB::table('users')
                    ->leftjoin('course_user', 'course_user.user_id', '=', 'users.id')
                    ->leftjoin('grades', 'grades.user_id', '=', 'users.id')
                    ->leftjoin('grade_books', 'grade_books.course_id', '=', 'course_user.course_id')
                    ->select('users.fname','users.lname','users.email','users.id as std_id','grades.*','grade_books.*','grades.id as gradeid')
                    ->where('course_user.course_id', '=', $course->id)
                    ->get();

               $assgrades = DB::table('assdelivers')
                    ->leftjoin('assignments', 'assdelivers.ass_id', '=', 'assignments.id')
                    ->leftjoin('modules', 'assignments.module_id', '=', 'modules.id')
                    ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
                    ->select('assdelivers.*' , 'assignments.full_mark')
                    ->where('courses.id', '=', $course->id)
                    ->get();
                $quizgrades = DB::table('quiz_user')
                    ->leftjoin('quizzes', 'quiz_user.quiz_id', '=', 'quizzes.id')
                    ->leftjoin('modules', 'quizzes.module_id', '=', 'modules.id')
                    ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
                    ->select('quiz_user.*' , 'quizzes.total_grade')
                    ->where('courses.id', '=', $course->id)
                    ->get();

                $gradesbook=gradeBook::where('course_id', '=' ,$course->id)->first();



                //dd($course);

                //dd($grades);
                return view('_auth.grades.index',compact('students','assgrades','course_id','quizgrades','gradesbook','course'));
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
    public function create(Course $course, User $student)
    {
        if(canCreate($this->controllerName)){
            $course_id = $course->id;
            $student_id = $student->id;

            if (Auth::user()->isInstructor()){

                return view('_auth.grades.create',compact('course_id','student_id','student'));
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
    public function store(Request $request, Course $course, User $student)
    {
        //d($student_id);
        if(canCreate($this->controllerName)){
            \DB::table('grades')->insert([
                [
                    'course_id'          => $course->id,
                    'user_id'            => $student->id,
                    'finalgrade'         => $request->input('finalexam'),
                    'midterm'            => $request->input('midtermgrade'),
                    'midterm_fullmark'   => $request->input('midtermfullmark'),
                    'final_fullmark'     => $request->input('finalexamfullmark'),
                    'practical'          => $request->input('practicalgrade'),
                    'practical_fullmark' => $request->input('practicalfullmark')
                ]
            ]);
            $grades=grade::where('user_id', '=' ,$student->id)->first();
            ActionLog::create([
                'subject' => 'user',
                'subject_id' => Auth::user()->id,
                'action' => 'create',
                'type' => 'grades',
                'type_id' => $grades->id,
                'object' => 'course',
                'object_id' => $course->id
            ]);
            return redirect()->back()->with('success', 'Grades Successfully Submitted');

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
    public function show(Course $course, $id)
    {

        $student = User::find($id);
        $student_id = $student->id;
        $course_id = $course->id;
        if(canRead($this->controllerName)){
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
                ->where('course_user.user_id', '=', $student->id)
                ->where('course_user.course_id', '=', $course->id)
               // ->where('assdelivers.user_id', '=', $student->id)
                ->get();


            $assgrades = DB::table('assdelivers')
                ->leftjoin('assignments', 'assdelivers.ass_id', '=', 'assignments.id')
                ->leftjoin('modules', 'assignments.module_id', '=', 'modules.id')
                ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
                ->select('assdelivers.*' , 'assignments.full_mark')
                ->where('courses.id', '=', $course->id)
                ->get();



            $quizgrades = DB::table('quiz_user')
                ->leftjoin('quizzes', 'quiz_user.quiz_id', '=', 'quizzes.id')
                ->leftjoin('modules', 'quizzes.module_id', '=', 'modules.id')
                ->leftjoin('courses', 'modules.course_id', '=', 'courses.id')
                ->select('quiz_user.*' , 'quizzes.total_grade','quizzes.title as quiztitle','modules.title as modtitle')
                ->where('courses.id', '=', $course->id)
                ->get();

            $grades=grade::where('course_id', '=' ,$course->id)->first();
            $assigmentdelv=assdeliver::where('user_id', '=', $id )->get();

            //dd($assigmentdelv);




            return view('_auth.grades.show',compact('student','student_id','assgrades','quizgrades','grades','course_id','assigmentdelv'));
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course, $student_id)
    {

        if(canUpdate($this->controllerName)){
            $student = User::find($student_id);
            $grades=grade::where('user_id', '=' ,$student->id)->first();

            //dd($student);
            if (Auth::user()->isInstructor()){

                return view('_auth.grades.edit',compact('grades','student'));
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
    public function update(Request $request, Course $course, $grade_id)
    {
        if(canUpdate($this->controllerName)){
            $grades = grade::find($grade_id);
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
                ActionLog::create([
                    'subject' => 'user',
                    'subject_id' => Auth::user()->id,
                    'action' => 'update',
                    'type' => 'grades',
                    'type_id' => $grades->id,
                    'object' => 'course',
                    'object_id' => $course->id
                ]);
                return redirect()->back()->with('success', 'Grades updated successfully');
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
