@extends('_layouts.app')

@section('title')
    Update {{ $module->title }}
@endsection

@section('content')
    <div class="content mt-5 mb-5">
        <div class="container">
            <div class=" mt-5 text-left" style="font-size: large">
                <a href="{{ route('course.displayLessonsOfModules',['course_id' => $course->id, 'module_id'=> $module->id]) }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
            </div>
            <div id="response-message-success" class="alert alert-success mt-2" style="display: none"></div>
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend><i class="fa fa-edit mr-1"></i>Update <span id="form-module-title-parent"><span id="form-module-title-child">{{ $module->title }}</span></span></legend>
                    <hr>
                    <form id="submit-update-module">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputTitle">Module Title</label>
                                    <input type="text" name="title" class="form-control" id="inputTitle" value="{{ $module->title }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCommitment">Commitment</label>
                                    <input type="text" name="commitment" class="form-control" id="inputCommitment" value="{{ $module->commitment }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputOrder">Module Order</label>
                                    <input type="text" name="module_order" class="form-control" id="inputOrder" value="{{ $module->module_order }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputModuleIntroduction">Module Introduction</label>
                                    <textarea name="introduction" class="form-control" id="inputModuleIntroduction">{{ $module->introduction }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <br>
                                <button  class="btn btn-primary">Update Module</button>
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
        var courseID = {!! json_encode($course->id) !!};
        var moduleID = {!! json_encode($module->id) !!};
    </script>
    <script src="{{ asset('js/updateModuleForm.js') }}"></script>
@endsection