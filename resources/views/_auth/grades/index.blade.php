@extends('_layouts.app')
@section('title', 'View student grades')


@section('content')

    <div class="row">
        <div class="col-lg-12">
            {{-- Start Breadcrumbs--}}
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb breadcrumb-custom">
                        <li class="breadcrumb-item text-success"><a href="/Courses/">Courses</a></li>
                        <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id}}">{{ $course->title }}</a></li>
                        <li class="breadcrumb-item text-success">Student grades</li>
                    </ol>
                </div>
            </div>
            {{-- End Breadcrumbs--}}
        </div>
    </div>

    <h1 class="f-rw my-4">View All students grades</h1>
    @if(!$gradesbook)
        <div class="reg-log-form p-3 my-3 " style="background-color: #ff343f; ">
            <b>Attention!!</b> Please Fill the Grade Book First from  <a style="color: white" href="{{ route('course.gradeBook.index',['course_id' =>$course_id]) }}"> here</a>
        </div>
    @else
        @if (count($students)>0)
            <div class="row">
                <div class="col-lg-12">
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
                                <th colspan="2">Actions</th>
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
                                        @if($quizgrades->where('user_id', $student->std_id)->sum('grade') && $quizgrades->where('user_id', $student->std_id)->sum('total_grade') && $student->quizzes_weight)
                                            {{ $quiz= number_format(
                                                ($quizgrades->where('user_id', $student->std_id)->sum('grade')
                                                / $quizgrades->where('user_id', $student->std_id)->sum('total_grade') )
                                                * $student->quizzes_weight *100
                                                , 2)
                                            }}%
                                        @else
                                            {{$quiz=0}}
                                        @endif
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
                                        {{number_format($avg=$finalexam+$quiz+$practical+$midterm+$assignment , 2)}}%
                                    </td>
                                    <td style="color: green">
                                        @if ($avg >= 90)
                                            {{$lettergrade = "A"}}
                                        @elseif ($avg >= 80 && $avg <= 89)
                                            {{$lettergrade = "B"}}
                                        @elseif ($avg >= 70 && $avg <= 79)
                                            {{$lettergrade = "C"}}
                                        @elseif ($avg >= 60 && $avg <= 69)
                                            {{$lettergrade = "D"}}
                                        @elseif ($avg <= 59)
                                            {{$lettergrade = "F"}}
                                        @endif
                                    </td>
                                    <td>
                                        <button  class="btn btn-group-sm btn-link"><a href="{{route('course.studentGrades.show', ['student_id' => $student->std_id,'course_id' => $student->course_id])}}"><i class="fas fa-eye fa-1x"></i> </a> </button>
    
                                        @if($student->gradeid)
                                            <button  class="btn btn-group-sm btn-link"><a href="{{route('course.studentGrades.edit', ['student_id' => $student->std_id,'course_id' => $student->course_id])}}"><i class="far fa-edit fa-1x fam-mod"></i> </a> </button>
                                        @else
                                            <button  class="btn btn-group-sm btn-link"><a href="{{route('course.studentGrades.create', ['student_id' => $student->std_id,'course_id' => $student->course_id])}}"><i class="fas fa-plus fa-1x fam-mod"></i> </a> </button>
                                        @endif
                                    </td>
                                </tr>
    
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif
@stop