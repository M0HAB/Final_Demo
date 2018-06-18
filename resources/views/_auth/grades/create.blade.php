@extends('_layouts.app')
@section('title', 'Add Student grades ')


@section('content')


    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-4">
        <div class="container">

            <h1>Edit Student Grades :</h1>
            <div class="row justify-content-center">
                <div class="col-lg-10 col-sm-12">
                    <h4>Student name: {{$student->fname. ' ' . $student->lname}} </h4>
                    <h4>Student email: {{$student->email}}</h4>

                    <br>
                    @include('_partials.errors')


                    <form action="{{ route('course.studentGrades.store',['student_id' => $student_id,'course_id' => $course_id])}}" method="POST" role="form" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="midtermgrade">Midterm grade:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="midtermgrade"
                                   name="midtermgrade" value="">
                        </div>
                        <div class="form-group">
                            <label for="midtermfullmark">Midterm Full mark:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="midtermfullmark"
                                   name="midtermfullmark" value="">
                        </div>
                        <div class="form-group">
                            <label for="practicalgrade">Practical grade:<small>(leave it blank if no practical exam)</small></label>
                            <input type="number" class="form-control" style="width: 90px;" id="practicalgrade"
                                   name="practicalgrade" value="">
                        </div>
                        <div class="form-group">
                            <label for="practicalfullmark">Practical Fullmark:<small>(leave it blank if no practical exam)</small></label>
                            <input type="number" class="form-control" style="width: 90px;" id="practicalfullmark"
                                   name="practicalfullmark" value="">
                        </div>
                        <div class="form-group">
                            <label for="finalexam">Final Exam grade:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="finalexam"
                                   name="finalexam" value="">
                        </div>
                        <div class="form-group">
                            <label for="finalexamfullmark">Final Exam Fullmark:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="finalexamfullmark"
                                   name="finalexamfullmark" value="">
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>

                </div>


            </div>
        </div>
    </div> <!-- End: Content -->


@stop