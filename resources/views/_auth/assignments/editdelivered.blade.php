@extends('_layouts.app')
@section('title', 'Edit Delivered Assginment ')


@section('content')
    <div class="reg-log-form p-3 my-3">
        <a href="{{ URL::previous() }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>

    </div>
    <!-- Start: Content -->
    <div class="content mt-5 mb-4">
        <div class="container">

            <h1>Edit Delivered Assginment : </h1>
            <div class="row justify-content-center">
                <div class="col-lg-10 col-sm-12">
                    <br>
                    @include('_partials.errors')
                    <h4>Student Name:{{$delivered->student->fname}} </h4>
                    <h4>Assginment: {{$delivered->assignment->title}} </h4>
                    <h4>Grade: {{$delivered->grade ? $delivered->grade : "Ø"}}/{{$delivered->assignment->full_mark}} </h4>

                    <form action="{{ route('assdelivered.update',$delivered->id) }}" method="POST" role="form" autocomplete="off">
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
        </div>
    </div> <!-- End: Content -->

@stop