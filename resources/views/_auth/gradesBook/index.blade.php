@extends('_layouts.app')
@section('title', 'View grades book')


@section('content')
    <div class="row">
            {{-- Start Breadcrumbs--}}
    <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb breadcrumb-custom">
                        <li class="breadcrumb-item text-success"><a href="/Courses/">Courses</a></li>
                        <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id}}">{{ $course->title }}</a></li>
                        <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id}}/gradesBook"> Grades Book</a></li>
                    </ol>
                </div>
            </div>
        {{-- End Breadcrumbs--}}
        <!-- Start: Content -->
        <div class="row mt-4">
            <div class="col-lg-8">
                <h1 class="f-rw">Grades Book</h1>
            </div>
            <div class="col-lg-4">
                @if (count($gradesBooks) ==0)
                    <a href="{{route('course.gradeBook.create', ['course_id' => $course_id])}}" class="btn btn-success float-right" role="button">Create</a>
                @endif
            </div>
            <div class="col-lg-12 mt-4">
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
                        @if(canUpdate('Grade'))
                            <th>Actions</th>
                        @endif
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
                                {{$gradesBook->assignments_weight ? $gradesBook->assignments_weight * 100 : '-'}}%
                            </td>
                            <td>
                                {{$gradesBook->quizzes_weight ? $gradesBook->quizzes_weight * 100 : '-'}}%
                            </td>
                            <td>
                                {{$gradesBook->midterm_weight ? $gradesBook->midterm_weight * 100 : '-'}}%
                            </td>
                            <td>
                                {{$gradesBook->finalexam_weight ? $gradesBook->finalexam_weight * 100 : '-'}}%
                            </td>
                            <td>
                                {{$gradesBook->practical_weight ? $gradesBook->practical_weight * 100 : '-'}}%
                            </td>

                            <td>
                                {{($gradesBook->assignments_weight + $gradesBook->quizzes_weight + $gradesBook->midterm_weight + $gradesBook->finalexam_weight + $gradesBook->practical_weight) * 100}}%

                            </td>
                            @if(canUpdate('Grade'))
                                <td>
                                    <a href="{{route('course.gradeBook.edit', ['course' => $course->id, 'gradesBook_id' => $gradesBook->id])}}" class="btn btn-link py-0"><i class="far fa-edit fa-lg text-dark"></i> </a>
                                </td>
                            @endif

                        </tr>
                    @endforeach
                    @else
                        <div class="alert alert-dismissible alert-light mt-3">
                            <strong>No Grade book yet</strong> for this course please create one
                        </div>
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
    </div>
@stop
