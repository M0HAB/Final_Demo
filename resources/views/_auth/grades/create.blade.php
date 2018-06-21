@extends('_layouts.app')
@section('title', 'Add Student grades ')


@section('content')
    <a href="{{ route('course.listUserCourses') }}" class="btn go-back-btn mb-4"><i class="fas fa-arrow-left fa-1x"></i> Back</a> 

    <!-- Start: Content -->

    <h1 class="f-rw">Edit Student Grades</h1>
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <h6><strong>Student name:</strong> <span class="text-success">{{$student->fname. ' ' . $student->lname}}</span> </h6>
            <h6><strong>Student email:</strong> <span class="text-success">{{$student->email}}</span></h6>

            <br>
            @include('_partials.errors')


            <form action="{{ route('course.studentGrades.store',['student_id' => $student_id,'course_id' => $course_id])}}" method="POST" role="form" autocomplete="off">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="midtermgrade">Midterm grade:</label>
                    <input type="number" class="form-control" id="midtermgrade"
                            name="midtermgrade" value="">
                </div>
                <div class="form-group">
                    <label for="midtermfullmark">Midterm Full mark:</label>
                    <input type="number" class="form-control" id="midtermfullmark"
                            name="midtermfullmark" value="">
                </div>
                <div class="form-group">
                    <label for="practicalgrade">Practical grade:<small>(leave it blank if no practical exam)</small></label>
                    <input type="number" class="form-control" id="practicalgrade"
                            name="practicalgrade" value="">
                </div>
                <div class="form-group">
                    <label for="practicalfullmark">Practical Fullmark:<small>(leave it blank if no practical exam)</small></label>
                    <input type="number" class="form-control" id="practicalfullmark"
                            name="practicalfullmark" value="">
                </div>
                <div class="form-group">
                    <label for="finalexam">Final Exam grade:</label>
                    <input type="number" class="form-control" id="finalexam"
                            name="finalexam" value="">
                </div>
                <div class="form-group">
                    <label for="finalexamfullmark">Final Exam Fullmark:</label>
                    <input type="number" class="form-control" id="finalexamfullmark"
                            name="finalexamfullmark" value="">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>


    </div>
@stop