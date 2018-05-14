@extends('_layouts.app')

@section('title')
    Add New Module
@endsection

@section('content')
    <div class="content mt-5 mb-5">
        <div class="container">
            <div class=" mt-5 text-left" style="font-size: large">
                <a href="{{ route('course.viewCourseModules', ['id' => $course_id]) }}"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
            </div>
            <div id="response-message-success" class="alert alert-success" style="display: none"></div>
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend><i class="fa fa-plus"></i> Add New Module</legend>
                    <hr>
                    <form id="submit-new-module">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputTitle">Module Title</label>
                                    <input type="text" name="title" class="form-control" id="inputTitle"   placeholder="Enter the module title">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCommitment">Commitment</label>
                                    <input type="text" name="commitment" class="form-control" id="inputCommitment"  placeholder="Enter the number of hours for this module">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputOrder">Module Order</label>
                                    <input type="text" name="module_order" class="form-control" id="inputOrder"  placeholder="Enter the module order">
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputModuleIntroduction">Module Introduction</label>
                                    <textarea name="introduction" class="form-control" id="inputModuleIntroduction"  placeholder="Enter the module introduction"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <br>
                                <button  class="btn btn-primary">Create New Module</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/newModuleForm.js') }}"></script>
@endsection