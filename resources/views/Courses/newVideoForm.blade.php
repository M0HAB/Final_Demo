@extends('_layouts.app')

@section('title')
    Add New Video
@endsection

@section('content')
    <div class="content mt-5 mb-5">
        <div class="container">
            <div class=" mt-5 text-left" style="font-size: large">
                <a href="#"><i class="fas fa-arrow-alt-circle-left"></i> Back</a>
            </div>
            @include('_inc.messages')
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend><i class="fa fa-plus"></i> Add New Video</legend>
                    <hr>
                    <form action="{{ route('course.uploadVideo', ['course_id' => '1', 'module_id' => '1']) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('title')? 'has-error' : '' }}">
                                    <label for="inputTitle">Video Title</label>
                                    <input type="text" name="title" class="form-control" id="inputTitle"  value="{{ Request::old('title')? : '' }}"  placeholder="Enter the video title">
                                    @if($errors->has('title'))
                                        <Span class="help-block text-danger">{{ $errors->first('title') }}</Span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('privacy')? 'has-error' : '' }}">
                                    <label for="inputCourseLanguage">Video Privacy</label>
                                    <select name="privacy" class="form-control" id="inputVideoPrivacy"  data-placeholder="Select the video privacy" style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value="unlisted">Unlisted</option>
                                        <option value="public">Public</option>
                                    </select>
                                    @if($errors->has('privacy'))
                                        <Span class="help-block text-danger">{{ $errors->first('privacy') }}</Span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('description')? 'has-error' : '' }}">
                                    <label for="inputModuleIntroduction">Video Description</label>
                                    <textarea name="description" class="form-control" id="inputVideoDescription"  placeholder="Enter the video description">{{ Request::old('description')? : '' }}</textarea>
                                    @if($errors->has('description'))
                                        <Span class="help-block text-danger">{{ $errors->first('description') }}</Span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('recap')? 'has-error' : '' }}">
                                    <label for="inputModuleIntroduction">Video Recap</label>
                                    <textarea name="recap" class="form-control" id="inputVideoRecap"  placeholder="Enter the video Recap">{{ Request::old('recap')? : '' }}</textarea>
                                    @if($errors->has('recap'))
                                        <Span class="help-block text-danger">{{ $errors->first('recap') }}</Span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-3 mt-2">
                                <div class="form-group {{ $errors->has('myVideo')? 'has-error' : '' }}">
                                    <input type="file"   name="myVideo" />
                                    @if($errors->has('myVideo'))
                                        <Span class="help-block text-danger">{{ $errors->first('myVideo') }}</Span>
                                    @endif
                                </div>
                                <input type="hidden" name="_token" value="{{ \Illuminate\Support\Facades\Session::token() }}" />
                            </div>
                        </div>
                        <hr>

                        <div class="row">
                            <div class="col-md-3">
                             <input type="submit"  class="btn btn-primary" value="Insert The video" />                            </div>
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