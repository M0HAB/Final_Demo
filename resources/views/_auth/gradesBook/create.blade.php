@extends('_layouts.app')
@section('title', 'Create grades book')


@section('content')



    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-4" xmlns:text-align="http://www.w3.org/1999/xhtml"
         xmlns:margin-left="http://www.w3.org/1999/xhtml">
        <div class="container">

            <h1>Create Grade Book:</h1>
            <h6 style="color: green"><strong>NOTE:</strong>These weights are percentage</h6>
            <div class="row justify-content-center">
                <div class="col-lg-10 col-sm-12">
                    <br>
                    @include('_partials.errors')
                    <form action="{{ route('course.gradeBook.store', ['course_id' => $course->id]) }}" method="POST" role="form" autocomplete="off">
                        {{ csrf_field() }}


                        <div class="form-group">
                            <label for="assw">Assignments weight:</label>
                            <input type="number" class="form-control" style="width: 90px;" size="2" id="assw"
                                   name="assw">
                        </div>
                        <div class="form-group">
                            <label for="quizw">Quizzes weight:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="quizw"
                                   name="quizw" >
                        </div>
                        <div class="form-group">
                            <label for="midw">Midterm Weight:</label>
                            <input type="number" class="form-control" style="width: 90px;" id="midw"
                                   name="midw" >
                        </div>
                        <div class="form-group">
                            <label for="finalw">Final Exam weight</label>
                            <input type="number" class="form-control" style="width: 90px;" id="finalw"
                                   name="finalw" >
                        </div>
                        <div class="form-group">
                            <label for="practw">Practical weight:(leave it empty if course has no practical)</label>
                            <input type="number" class="form-control" style="width: 90px;" id="finalw"
                                   name="practw" >
                        </div>

                        <button type="submit" name="submit" class="btn btn-primary">Create</button>
                    </form>

                </div>
            </div>
        </div>
    </div> <!-- End: Content -->




@stop