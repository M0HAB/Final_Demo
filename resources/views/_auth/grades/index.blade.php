@extends('_layouts.app')
@section('title', 'View student grades')


@section('content')

    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>


    <div class="content mt-5 mb-4">
        <div class="container">
            <h1>View All students grades</h1>
            @if (count($students)>0)

            <div class="row justify-content-center">

                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Student Email</th>
                            <th>Assignment Grade</th>
                            <th>Quizzes Grade</th>
                            <th>Midterm Grade</th>
                            <th>Practical Grade</th>
                            <th>Final Exam Grade</th>
                            <th>Total Grade</th>
                            <th>Letter Grade</th>
                            <th>Actions</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($students as $student)

                            <tr>
                                <td>

                                    {{$student->fname}}  {{$student->lname}}
                                </td>
                                <td>
                                    {{$student->email}}
                                </td>
                                <td>
                                    @if($assgrades->where('user_id', $student->std_id)->sum('grade') && $assgrades->where('user_id', $student->std_id)->sum('full_mark'))

                                    {{ $assignment= number_format(
                                           ($assgrades->where('user_id', $student->std_id)->sum('grade')
                                          / $assgrades->where('user_id', $student->std_id)->sum('full_mark') )
                                           * $student->assignments_weight *100
                                         , 2)
                                    }}%

                                        @else
                                        {{$assignment=0}}
                                        @endif

                                </td>

                                <td>
                                    TODO

                                </td>
                                <td>
                                    @if($student->midterm && $student->midterm_fullmark)
                                    {{number_format($midterm=$student->midterm ? ($student->midterm/$student->midterm_fullmark) * $student->midterm_weight*100 : 0 , 2)}}%
                                    @else()
                                    {{$midterm=0}}
                                    @endif
                                </td>

                                <td>
                                    @if($student->practical && $student->practical_fullmark)
                                    {{number_format($practical=$student->practical ? ($student->practical/$student->practical_fullmark)*$student->practical_weight  *100 :0 , 2)}}%
                                    @else

                                    {{$practical=0}}
                                    @endif
                                </td>


                                <td>
                                    @if($student->final_fullmark && $student->final_fullmark)
                                    {{number_format($finalexam=$student->finalgrade ? ($student->finalgrade/$student->final_fullmark)*$student->finalexam_weight *100 :0 , 2)}}%
                                        @else
                                    {{$finalexam=0}}
                                    @endif
                                </td>

                                <td style="color: green">

                                        {{number_format($avg=$finalexam+$practical+$midterm+$assignment , 2)}}%


                                </td>

                                <td style="color: green">

                                        @if ($avg >= 97)
                                        {{$lettergrade = "A+"}}
                                        @elseif ($avg >= 93 && $avg <= 96)
                                            {{$lettergrade = "A"}}
                                        @elseif ($avg >= 84 && $avg <= 93)
                                            {{$lettergrade = "B"}}
                                        @elseif ($avg >= 74 && $avg <= 73)
                                            {{$lettergrade = "C"}}
                                        @elseif ($avg >= 64 && $avg <= 73)
                                            {{$lettergrade = "D"}}
                                        @elseif ($avg >= 50 && $avg <= 63)
                                            {{$lettergrade = "D-"}}
                                        @else($avg < 50)
                                            {{$lettergrade = "F"}}
                                        @endif


                                </td>

                                <td>
                                    <button  class="btn btn-group-sm btn-link"><a href="{{route('course.studentGrades.show', ['student_id' => $student->std_id,'course_id' => $student->course_id])}}"><i class="fas fa-eye fa-1x"></i> </a> </button>
                                    <button  class="btn btn-group-sm btn-link"><a href="{{route('course.studentGrades.edit', ['student_id' => $student->std_id,'course_id' => $student->course_id])}}"><i class="far fa-edit fa-1x fam-mod"></i> </a> </button>

                                </td>



                            </tr>

                        @endforeach
                        </tbody>
                    </table>

                @endif

            </div>
        </div>
    </div> <!-- End: Content -->


@stop