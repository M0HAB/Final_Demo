@extends('_layouts.app')
@section('title', 'View student grades')


@section('content')


    <div class="content mt-5 mb-4">
        <div class="container">
            <h1>View All students grades</h1>
            <div class="row justify-content-center">
                @if (count($students)>0)
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
                                    {{ $assignment= number_format(
                                           ($assgrades->where('user_id', $student->std_id)->sum('grade')
                                          / $assgrades->where('user_id', $student->std_id)->sum('full_mark') )
                                           * $student->assignments_weight *100
                                         , 2)
                                    }}%

                                </td>

                                <td>
                                    TODO

                                </td>
                                <td>
                                    {{$midterm=$student->midterm ? ($student->midterm/$student->midterm_fullmark) * $student->midterm_weight*100 : 0}}%

                                </td>

                                <td>
                                    {{$practical=$student->practical ? ($student->practical/$student->practical_fullmark)*$student->practical_weight  *100 :0}}%

                                </td>


                                <td>
                                    {{$finalexam=$student->finalgrade ? ($student->finalgrade/$student->final_fullmark)*$student->finalexam_weight *100 :0}}%

                                </td>

                                <td style="color: green">

                                        {{$avg=$finalexam+$practical+$midterm+$assignment}}%


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
                                    <button  class="btn btn-group-sm btn-link"><a href="#"><i class="fas fa-eye fa-1x"></i> </a> </button>
                                    <button  class="btn btn-group-sm btn-link"><a href="#"><i class="far fa-edit fa-1x fam-mod"></i> </a> </button>

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