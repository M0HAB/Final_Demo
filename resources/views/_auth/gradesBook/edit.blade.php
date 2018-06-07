@extends('_layouts.app')
@section('title', 'Edit grades book')


@section('content')



    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-4" xmlns:text-align="http://www.w3.org/1999/xhtml"
         xmlns:margin-left="http://www.w3.org/1999/xhtml">
        <div class="container">

            <h1>Edit Grade Book for {{$gradebook->course->title }}:</h1>
            <h6 style="color: green"><strong>NOTE:</strong>These weights are percentage</h6>
            <div class="row justify-content-center">
                <div class="col-lg-10 col-sm-12">
                    <br>
                    @include('_partials.errors')
                    <form action="{{ route('course.gradeBook.update',['course_id' => $course_id,'gradebook_id'=>$gradebook->id])}}" method="POST" role="form" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">


                        <div class="form-group">
                            <label for="assw">Assignments weight:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="assw"
                                   name="assw" value="{{$gradebook->assignments_weight * 100}}">
                        </div>
                        <div class="form-group">
                            <label for="quizw">Quizzes weight:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="quizw"
                                   name="quizw" value="{{$gradebook->quizzes_weight * 100}}">
                        </div>
                        <div class="form-group">
                            <label for="midw">Midterm weight:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="midw"
                                   name="midw" value="{{$gradebook->midterm_weight * 100}}">
                        </div>
                        <div class="form-group">
                            <label for="finalw">Final Exam weight:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="finalw"
                                   name="finalw" value="{{$gradebook->finalexam_weight * 100}}">
                        </div>
                        <div class="form-group">
                            <label for="practw">Practical weight:(leave it empty if course has no practical)</label>
                            <input type="number" class="form-control" style="width: 90px;" id="practw"
                                   name="practw" value="{{$gradebook->practical_weight * 100}}">
                        </div>



                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                    </form>

                </div>
            </div>
        </div>
    </div> <!-- End: Content -->




@stop