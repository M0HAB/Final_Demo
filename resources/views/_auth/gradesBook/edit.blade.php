@extends('_layouts.app')
@section('title', 'Edit grades book')


@section('content')
    <a href="{{ route('course.listUserCourses') }}" class="btn go-back-btn mb-4"><i class="fas fa-arrow-left fa-1x"></i> Back</a> 
    <!-- Start: Content -->
    <div class="row ">
        <div class="col-lg-12">
            <h1 class="f-rw">Edit Grade Book ( {{$gradebook->course->title }} )</h1>
            <div class="alert alert-dismissible alert-info mt-4">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>NOTE:</strong> These weights are percentage
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @include('_partials.errors')
            <form action="{{ route('course.gradeBook.update',['course_id' => $course_id,'gradebook_id'=>$gradebook->id])}}" method="POST" role="form" autocomplete="off">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="assw">Assignments weight</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="assw"
                        name="assw" value="{{$gradebook->assignments_weight * 100}}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="quizw">Quizzes weight</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="quizw"
                            name="quizw" value="{{$gradebook->quizzes_weight * 100}}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="midw">Midterm weight</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="midw"
                            name="midw" value="{{$gradebook->midterm_weight * 100}}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="finalw">Final Exam weight:</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="finalw"
                            name="finalw" value="{{$gradebook->finalexam_weight * 100}}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="practw">Practical weight <strong>(leave it empty if course has no practical)</strong></label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="practw"
                            name="practw" value="{{$gradebook->practical_weight * 100}}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@stop