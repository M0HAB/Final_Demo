@extends('_layouts.app')
@section('title', 'View student grades')


@section('content')

    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>

    @if(!$grades)
        @if(Auth::user()->isInstructor())
            {{-- <div class="reg-log-form p-3 my-3 " style="background-color: #ff343f; ">
                <b>Attention!!</b> Please Fill student Grades First from  <a style="color: white" href="{{ route('course.studentGrades.index',['course_id' =>$course_id]) }}"> here</a>
            </div> --}}

            <div class="alert alert-dismissible alert-info">
                <strong>Attention!!</strong> Please Fill student Grades First from  <a style="color: white" href="{{ route('course.studentGrades.index',['course_id' =>$course_id]) }}"> here</a>
            </div>
            @else
            {{-- <div class="reg-log-form p-3 my-3 " style="background-color: #eeff41; ">
                <b>Attention!!</b> Grades not set yet !
            </div> --}}
                <div class="alert alert-dismissible alert-info">
                    <strong>Attention!!</strong> Grades not set yet !
                </div>
            @endif

    @else

            <h3 class="f-rw">Viewing <span class="text-success">{{$student[0]->fname . ' '. $student[0]->lname}}</span> Grades in Details</h3>
            <strong class="f-rw-bold">For course {{$student[0]->title}}</strong>


            <div class="row">
                <div class="col-lg-12 my-4">
                    <h5 class="f-rw-bold text-muted mb-3 ml-1"><i class="fas fa-asterisk fa-xs"></i> Assginments grades</h5>
                    <table class="table">
                        <thead class="bg-light">
                            </thead>
                                <tr>
                                    <th>Assignments</th>
                                    <th>Grade</th>
                                    <th>Feedback</th>
                                </tr>
                            <tbody>
                            @if (!empty($student) &&!empty($assgrades)  &&!empty($quizgrades))
                                    @if(count($assigmentdelv) > 0)
                                        @foreach ($assigmentdelv as $stdass)
                                            <tr>
                                                <td>
                                                    {{$stdass->assignment->title}}

                                                </td>
                                                <td>
                                                    {{$stdass->grade ? $stdass->grade .'/'. $stdass->assignment->full_mark : "Not set yet"}}

                                                </td>
                                                <td>
                                                    {{$stdass->comment ? $stdass->comment : "No feedback"}}

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center">No assignment was delivered yet!</td>
                                        </tr>
                                    @endif                                    
                            </tbody>
                        </table>
                    </div>



                    <div class="col-lg-12">
                        <h5 class="f-rw-bold text-muted mb-3 ml-1"><i class="fas fa-asterisk fa-xs"></i> Quizzes grades</h5>
                        <table class="table">
                            <thead class="bg-light">
                            <tr>
                                <th>Module</th>
                                <th>Quiz</th>
                                <th>Grade</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($quizgrades as $quizgrade)
                                <tr>
                                    <td>
                                        {{$quizgrade->modtitle ? $quizgrade->modtitle :"no module"}}

                                    </td>
                                    <td>
                                        {{$quizgrade->quiztitle ? $quizgrade->quiztitle :"no title"}}

                                    </td>
                                    <td>
                                        {{$quizgrade->grade ? $quizgrade->grade : "not set yet"}} / {{$quizgrade->total_grade ? $quizgrade->total_grade : "-"}}

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12">
                        <h5 class="f-rw-bold text-muted mb-3 ml-1"><i class="fas fa-asterisk fa-xs"></i> Other grades</h5>
                        <table class="table">
                            <thead class="bg-light">
                            <tr>
                                <th>Midterm</th>
                                <th>Practical</th>
                                <th>Final Exam</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>

                                        {{$student[0]->midterm ? $student[0]->midterm . '/'. $student[0]->midterm_fullmark : "not set yet"}}

                                    </td>
                                    <td>

                                        {{$student[0]->practical ? $student[0]->practical. '/'. $student[0]->practical_fullmark : "no practical"}}

                                    </td>
                                    <td>

                                        {{$student[0]->finalgrade ? $student[0]->finalgrade .'/'. $student[0]->final_fullmark : "not set yet"}}

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-12">
                            <h5 class="f-rw-bold text-muted mb-3 ml-1"><i class="fas fa-asterisk fa-xs"></i> Total</h5>
                            <table class="table">
                                <thead class="bg-light">
                                <tr>
                                    <th>Assignment Grade  <br> {{$assw=$student[0]->assignments_weight *100}}%</th>
                                    <th>Quizzes Grade <br> {{$qw=$student[0]->quizzes_weight *100}}%</th>
                                    <th>Midterm Grade <br> {{$mw=$student[0]->midterm_weight *100}}%</th>
                                    <th>Practical Grade <br> {{$pw=$student[0]->practical_weight *100}}%</th>
                                    <th>Final Exam Grade <br> {{$fw=$student[0]->finalexam_weight *100}}%</th>
                                    <th>Total Grade <br> {{$assw + $qw +$mw+$pw+$fw}}%</th>
                                    <th>Letter Grade</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            @if($assgrades->where('user_id', $student_id)->sum('grade') && $assgrades->where('user_id', $student_id)->sum('full_mark'))

                                                {{ $assignment= number_format(
                                                       ($assgrades->where('user_id', $student_id)->sum('grade')
                                                      / $assgrades->where('user_id', $student_id)->sum('full_mark') )
                                                       * $assw
                                                     , 2)
                                                }}%

                                            @else
                                                {{$assignment=0}}
                                            @endif

                                        </td>

                                        <td>
                                            @if($quizgrades->where('user_id', $student_id)->sum('grade') && $quizgrades->where('user_id', $student_id)->sum('total_grade') )

                                                {{ $quiz= number_format(
                                                       ($quizgrades->where('user_id', $student_id)->sum('grade')
                                                      / $quizgrades->where('user_id', $student_id)->sum('total_grade') )
                                                       * $qw
                                                     , 2)
                                                }}%

                                            @else
                                                {{$quiz=0}}
                                            @endif

                                        </td>
                                        <td>
                                            @if($student[0]->midterm && $student[0]->midterm_fullmark)
                                                {{number_format($midterm=$student[0]->midterm ? ($student[0]->midterm/$student[0]->midterm_fullmark) * $mw: 0 , 2)}}%
                                            @else()
                                                {{$midterm=0}}
                                            @endif
                                        </td>

                                        <td>
                                            @if($student[0]->practical && $student[0]->practical_fullmark)
                                                {{number_format($practical=$student[0]->practical ? ($student[0]->practical/$student[0]->practical_fullmark)*$pw :0 , 2)}}%
                                            @else

                                                {{$practical=0}}
                                            @endif
                                        </td>


                                        <td>
                                            @if($student[0]->final_fullmark && $student[0]->final_fullmark)
                                                {{number_format($finalexam=$student[0]->finalgrade ? ($student[0]->finalgrade/$student[0]->final_fullmark)*$fw :0 , 2)}}%
                                            @else
                                                {{$finalexam=0}}
                                            @endif
                                        </td>

                                        <td class="text-success">
                                            {{number_format($avg=(($finalexam+$quiz+$practical+$midterm+$assignment) /($fw + $pw+ $mw +$qw +$assw) *100)  , 2)}}%
                                        </td>

                                        <td class="text-success">

                                            @if ($avg >= 90)
                                                {{$lettergrade = "A"}}
                                            @elseif ($avg >= 80 && $avg <= 89)
                                                {{$lettergrade = "B"}}
                                            @elseif ($avg >= 70 && $avg <= 79)
                                                {{$lettergrade = "C"}}
                                            @elseif ($avg >= 51 && $avg <= 69)
                                                {{$lettergrade = "D"}}
                                            @elseif ($avg <= 50)
                                                {{$lettergrade = "F"}}
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    @endif
                @endif
        </div>
@stop