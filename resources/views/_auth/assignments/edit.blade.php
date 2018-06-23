@extends('_layouts.app')
@section('title', 'Edit Assignments ')

@section('content')

    <!-- Start: Content -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="f-rw">Edit Assignment</h1>
        </div>
    </div>
    <div class="rowr">
        <div class="col-lg-12">
            <br>
            @include('_partials.errors')
            <form action="{{ route('assignments.update',['course_id' => $course->id, 'module_id' => $module->id, 'ass_id' => $assignment->id]) }}" method="POST" enctype="multipart/form-data" role="form" autocomplete="off">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">

                <div class="form-group">
                    <label for="asstitle">Title:</label>
                    <input type="text" class="form-control" name="asstitle"
                            @if (!empty(old('asstitle')))
                            value="{{ old('asstitle') }}"
                            @else
                            value="{{ $assignment->title ? $assignment->title : "NO TITLE"}}"
                            @endif
                    >
                </div>
                <div class="form-group">
                    <label for="assdescription">Description:</label>
                    <textarea rows="3" style="text-align:left" type="text" class="form-control" id="assdescription" name="assdescription">@if (!empty(old('assdescription'))){{ old('assdescription') }}@else{{ $assignment->description}}@endif</textarea>

                    <div class="form-group">
                        <label for="deadline">Deadline:</label>
                        <input type="date" class="form-control" name="deadline"
                                value="{{ old('deadline',date('Y-m-d')) }}"
                        >
                    </div>


                    <div class="form-group">
                        <label for="upload_file">Change File Uploaded (Current file:{{$assignment->file ? $assignment->file : "No file attached "}})</label>
                        <input class="form-control" type="file" name="upload_file" id="upload_file">
                    </div>

                </div>

                <div class="form-group">
                    <label for="fullmark">Full Mark:</label>
                    <input type="number" class="form-control" id="fullmark"
                            name="fullmark" value="{{$assignment->full_mark}}">
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>

@endsection