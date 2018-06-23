@extends('_layouts.app')

@section('title')
    Add New File
@endsection

@section('content')
    <div id="response-message-success" class="alert alert-success" style="display: none"></div>
    <div class="row">
        <div class="col-lg-12">
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend><i class="fa fa-plus"></i> Add New File</legend>
                    <form class="mt-4" action="{{ route('course.uploadFile', ['course' => $course->id, 'module' => $module->id]) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="inputTitle">File Title</label>
                                    <input type="text" name="title" class="form-control" id="inputTitle"  placeholder="Enter the file title">
                                </div>
                                <div class="form-group">
                                    <label for="inputFileDescription">File Description</label>
                                    <textarea name="description" class="form-control" id="inputFileDescription"  placeholder="Enter the file description"></textarea>
                                </div>
                            </div>
        
                            <div class="col-md-12">
                                <input type="file" name="lesson_file" id="file">
                            </div>
        
                            <div class="col-md-3">
                                <br>
                                <button  class="btn btn-primary">Create New File</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
@endsection
