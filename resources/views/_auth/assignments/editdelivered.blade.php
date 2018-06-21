@extends('_layouts.app')
@section('title', 'Edit Delivered Assginment ')


@section('content')
    {{--  <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
    </div>  --}}
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('course.listUserCourses') }}" class="btn go-back-btn mb-4"><i class="fas fa-arrow-left fa-1x"></i> Back</a> 
        </div>
        <div class="col-lg-12">
            <h1 class="f-rw mb-4">Edit Delivered Assginment</h1>
        </div>
    </div>
    <!-- Start: Content -->
    <div class="row">
        <div class="col-lg-12">
            @include('_partials.errors')
            <h6><strong class="mr-1">Student Name:</strong> <span class="text-success">{{$delivered->student->fname}}</span> </h6>
            <h6><strong class="mr-1">Assginment:</strong> <span class="text-success">{{$delivered->assignment->title}}</span> </h6>
            <h6><strong class="mr-1">Grade:</strong> <span class="text-success">{{$delivered->grade ? $delivered->grade : "-"}}/{{$delivered->assignment->full_mark}}</span> </h6>

            <form class="mt-5" action="{{ route('assdelivered.update',['course'=>$course->id, 'module'=>$module->id, 'assignment'=>$delivered->id]) }}" method="POST" role="form" autocomplete="off">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <label for="comment">Comment:</label>
                    <input type="text" class="form-control" id="comment"
                            name="comment"

                        value="{{$delivered->comment ? $delivered->comment : 'No comment'}}"

                    >
                </div>
                <div class="form-group">
                    <label for="grade">Grade:</label>
                    <input type="number"step=".01" class="form-control" id="grade"
                            name="grade"
                            @if (!empty($delivered->grade))
                            value="{{$delivered->grade}}"
                            @else
                            placeholder="Grade not set yet"
                            @endif
                    >

                </div>
                {{ method_field('PATCH') }}
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@stop