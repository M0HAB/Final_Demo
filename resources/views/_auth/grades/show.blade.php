@extends('_layouts.app')
@section('title', 'View student grades')


@section('content')

    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>


    <div class="content mt-5 mb-4">
        <div class="container">
            <h3>Viewing <strong>{{$student[0]->fname . ' '. $student[0]->lname}}</strong> grades in details</h3>
            <strong>For course {{$student[0]->title}}</strong>
            <div class="row justify-content-center">
                @if (count($student)>0)
                    <h4 style="color: #1b4f72">Assginments grades</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Assginments</th>
                            <th>Grade</th>
                            <th>Feedback</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($student as $stdass)

                            <tr>
                                <td>
                                    {{$stdass->asstitle}}

                                </td>
                                <td>
                                    {{$stdass->assgrade .'/'. $stdass->assfullmark}}

                                </td>
                                <td>
                                    {{$stdass->comment ? $stdass->comment : "no feedback"}}

                                </td>


                            </tr>
                            @endforeach


                        </tbody>
                    </table>


                    <h4 style="color: #1b4f72">Quizzes grades</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Quiz</th>
                            <th>Grade</th>

                        </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>

                                </td>

                            </tr>



                        </tbody>
                    </table>

                    <h4 style="color: #1b4f72">Other grades</h4>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Midterm</th>
                            <th>Practical</th>
                            <th>Final Exam</th>

                        </tr>
                        </thead>
                        <tbody>


                            <tr>
                                <td>

                                    {{$student[0]->midterm . '/'. $student[0]->midterm_fullmark}}

                                </td>
                                <td>

                                    {{$student[0]->practical ? $student[0]->practical. '/'. $student[0]->practical_fullmark : "no practical"}}

                                </td>
                                <td>

                                    {{$student[0]->finalgrade .'/'. $student[0]->final_fullmark}}

                                </td>




                            </tr>



                        </tbody>
                    </table>

                    <h4 style="color: #1b4f72">Total</h4>



                        <table class="table table-hover">
                            <thead>
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
                                        TODO

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





                                </tr>


                            </tbody>
                        </table>

                        @endif

                    </div>






        </div>
    </div> <!-- End: Content -->





@stop