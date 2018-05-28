@extends('_layouts.app')
@section('title', 'Deliver Assignment ')


@section('content')


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
                        <label for="assignment_answer">Your Answer:</label>
                        <textarea type="text" class="form-control" id="assignment_answer"
                                  name="assignment_answer" value=""></textarea>
                    </div>

                    <div class="form-group">
                        <label for="upload_file">Upload File (Optional)</label>
                        <input class="form-control" type="file" name="upload_file" id="upload_file">

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