@extends('_layouts.app')
@section('title', 'Deliver Assignment ')


@section('content')
    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-5">
        <div class="row">
            <div class="offset-lg-1 col-lg-10 col-sm-12">
                @include('_partials.errors')
                <h1 class="display-4 mb-5 f-rw ">Submit {{$assignment->title}}: </h1>

                <form action="{{ route('assignment.deliverstore', ['course_id' => $course->id, 'module_id' => $module->id]) }}" method="POST" role="form" enctype="multipart/form-data" autocomplete="off">
                    {{ csrf_field() }}

                    <div class="form-group">
                      <h4>Assignment Description: {{$assignment->description}}  </h4>
                        <input name="assid" type="hidden" value="{{$assignment->id}}">


                    </div>


                    <div class="form-group">
                        <label for="upload_file">Upload File</label>
                        <input class="form-control" type="file" name="upload_file" id="upload_file">

                    </div>
                    <div class="form-group">
                        <label for="assignment_answer">Comment:</label>
                        <textarea type="text" class="form-control" id="assignment_answer"
                                  name="assignment_answer" value=""></textarea>
                    </div>

                    @if ($assdelivered->exists())

                    <button type="submit" name="submit" class="btn btn-primary" disabled>Submit</button>
                        <p style="color: green">You have already submitted this assginment</p>
                    @else

                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        @endif


                </form>

            </div>
        </div>
    </div>



@stop