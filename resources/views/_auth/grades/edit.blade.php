@extends('_layouts.app')
@section('title', 'Edit Student grades ')


@section('content')


    <!-- Start: Content -->
        <h1 class="f-rw">Edit Student Grades</h1>
        <div class="row">
            <div class="col-lg-12">
                <h6>Student name: <span class="text-success">{{$student->fname. ' ' . $student->lname}}</span> </h6>
                <h6>Student email: <span class="text-success">{{$student->email}}</span></h6>

                <br>
                @include('_partials.errors')


                <form action="{{ route('course.studentGrades.update',['course_id' => $grades->course_id,'grade_id'=>$grades->id])}}" method="POST" role="form" autocomplete="off">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-group">
                        <label for="midtermgrade">Midterm grade:</label>
                        <input type="number" class="form-control" id="midtermgrade"
                                name="midtermgrade" value="{{$grades->midterm}}">
                    </div>
                    <div class="form-group">
                        <label for="midtermfullmark">Midterm Full mark:</label>
                        <input type="number" class="form-control" id="midtermfullmark"
                                name="midtermfullmark" value="{{$grades->midterm_fullmark}}">
                    </div>
                    <div class="form-group">
                        <label for="practicalgrade">Practical grade:<small>(leave it blank if no practical exam)</small></label>
                        <input type="number" class="form-control" id="practicalgrade"
                                name="practicalgrade" value="{{$grades->practical}}">
                    </div>
                    <div class="form-group">
                        <label for="practicalfullmark">Practical Fullmark:<small>(leave it blank if no practical exam)</small></label>
                        <input type="number" class="form-control" id="practicalfullmark"
                                name="practicalfullmark" value="{{$grades->practical_fullmark}}">
                    </div>
                    <div class="form-group">
                        <label for="finalexam">Final Exam grade:</label>
                        <input type="number" class="form-control" id="finalexam"
                                name="finalexam" value="{{$grades->finalgrade}}">
                    </div>
                    <div class="form-group">
                        <label for="finalexamfullmark">Final Exam Fullmark:</label>
                        <input type="number" class="form-control" id="finalexamfullmark"
                                name="finalexamfullmark" value="{{$grades->final_fullmark}}">
                    </div>

                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>


        </div>
@endsection