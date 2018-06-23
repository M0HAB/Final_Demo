@extends('_layouts.app')
@section('title', 'Create grades book')


@section('content')
    <!-- Start: Content -->

    <div class="row">
        <div class="col-lg-12">
            <h1 class="f-rw">Create Grade Book</h1>
            <div class="alert alert-dismissible alert-info mt-4">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>NOTE:</strong> These weights are percentage
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @include('_partials.errors')
            <form action="{{ route('course.gradeBook.store', ['course_id' => $course->id]) }}" method="POST" role="form" autocomplete="off">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="assw">Assignments weight</label>
                    <div class="input-group">
                        <input type="number" class="form-control" size="2" id="assw"
                            name="assw" value="{{ old('assw') }}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="quizw">Quizzes weight</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="quizw"
                            name="quizw" value="{{ old('quizw') }}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="midw">Midterm Weight</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="midw"
                            name="midw" value="{{ old('midw') }}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="finalw">Final Exam weight</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="finalw"
                            name="finalw" value="{{ old('finalw') }}">
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="practw">Practical weight <strong>(leave it empty if course has no practical)</strong></label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="finalw"
                            name="practw" >
                        <div class="input-group-append">
                            <span class="input-group-text" id="basic-addon2">%</span>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@stop