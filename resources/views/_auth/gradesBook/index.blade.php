@extends('_layouts.app')
@section('title', 'View grades book')


@section('content')

    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-4">
        <div class="container">
            <h1>Grades Book
                @if (count($gradesBooks) ==0)
                    <a href="{{route('course.gradeBook.create', ['course_id' => $course_id])}}" class="btn btn-info" role="button">Create</a>
                @endif

            </h1>
            <div class="row justify-content-center">
                @if (count($gradesBooks)>0)
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Code</th>
                            <th>Course Name</th>
                            <th>Assignments weight</th>
                            <th>Quizzes weight</th>
                            <th>Midterm weight</th>
                            <th>Final Exam weight</th>
                            <th>Practical weight</th>
                            <th>Total</th>
                            <th>Actions</th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($gradesBooks as $gradesBook)
                            <tr>
                                <td>
                                    {{$gradesBook->course->code ? $gradesBook->course->code : "course has no code"}}
                                </td>
                                <td>
                                    {{$gradesBook->course->title ? $gradesBook->course->title : "course has no title"}}
                                </td>
                                <td>
                                    {{$gradesBook->assignments_weight ? $gradesBook->assignments_weight * 100 : 'Ø'}}%
                                </td>
                                <td>
                                    {{$gradesBook->quizzes_weight ? $gradesBook->quizzes_weight * 100 : 'Ø'}}%
                                </td>
                                <td>
                                    {{$gradesBook->midterm_weight ? $gradesBook->midterm_weight * 100 : 'Ø'}}%
                                </td>
                                <td>
                                    {{$gradesBook->finalexam_weight ? $gradesBook->finalexam_weight * 100 : 'Ø'}}%
                                </td>
                                <td>
                                    {{$gradesBook->practical_weight ? $gradesBook->practical_weight * 100 : 'Ø'}}%
                                </td>

                                <td>

                                    {{($gradesBook->assignments_weight + $gradesBook->quizzes_weight + $gradesBook->midterm_weight + $gradesBook->finalexam_weight + $gradesBook->practical_weight) * 100}}%


                                </td>

                                <td>
                                    <button  class="btn btn-group-sm btn-link"><a href="{{route('course.gradeBook.edit', ['gradesBook_id' => $gradesBook->id,'course_id' => $course->id])}}"><i class="far fa-edit fa-lg fam-mod"></i> </a> </button>

                                </td>

                            </tr>
                        @endforeach
                        @else
                            <strong style="color: red"> No Grade book yet for this course please create one</strong>
                        </tbody>
                    </table>
                    <script>

                        function ConfirmDelete(){
                            return confirm('Are you sure you ? THIS CANNOT BE UNDONE');
                        }

                    </script>
                @endif

            </div>
        </div>
    </div> <!-- End: Content -->

@stop



