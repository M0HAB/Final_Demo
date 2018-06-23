@extends('_layouts.app')
@section('title', 'Assignments')
@section('content')

    <!-- Start: Content -->
    <div class="row">
        <div class="col-lg-12">
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend class="f-rw"><i class="fa fa-plus"></i> Add New Assignment</legend>
                    <hr>
                    @include('_partials.errors')
                    <form action="{{ route('assignments.store', ['course_id' => $course->id, 'module_id' => $module->id]) }}" method="POST" role="form" enctype="multipart/form-data" autocomplete="off">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="asstitle">Assignment Title:</label>
                            <input type="text" class="form-control" id="assdescription"
                                    placeholder="Enter Assignment Title" name="asstitle" value="">
                        </div>
                        <div class="form-group">
                            <label for="assdescription">Description:</label>
                            <textarea type="text" class="form-control" id="assdescription"
                            name="assdescription" value=""></textarea>
                        </div>
                        <div class="form-group">
                            <label for="deadline">Deadline:</label>
                            <input type="date" class="form-control" id="deadline"
                                    name="deadline" value="">
                        </div>
                        <div class="form-group">
                            <label for="fullmark">Full Mark:</label>
                            <input type="number" class="form-control" id="fullmark"
                                    name="fullmark" value="">
                        </div>
                        <div class="form-group">
                            <label for="upload_file">Upload File (Optional)</label>
                            <input class="form-control" type="file" name="upload_file" id="upload_file">

                        </div>
                        <br>
                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </fieldset>
        </div>
    </div>
@stop