@extends('_layouts.app')
@section('title', 'Assignments')
@section('content')

    <!-- Start: Content -->
    <div class="content mt-5 mb-5">
        <div class="row">
            <div class="offset-lg-1 col-lg-10 col-sm-12">
                @include('_partials.errors')
                <h1 class="display-4 mb-5 f-rw ">Create New Assignment</h1>
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
                        <label for="upload_file">Upload File (Optional)</label>
                        <input class="form-control" type="file" name="upload_file" id="upload_file">

                    </div>



                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>




    @stop