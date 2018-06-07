<?php

namespace App\Http\Controllers;

use App\assdeliver;
use App\User;
use Illuminate\Http\Request;
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


        return view('_auth.grades.index',compact('students','assgrades','course_id'));
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
        //
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
        //
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
