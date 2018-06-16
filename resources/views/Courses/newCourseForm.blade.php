@extends('_layouts.app')

@section('title')
    Add New Course
@endsection

@section('styles')
    <style>

        /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
        .modal {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 )
            url('{{ asset('course_images/ajax-loader2.gif') }}')
            50% 50%
            no-repeat;
        }

        /* When the body has the loading class, we turn
           the scrollbar off with overflow:hidden */
        body.loading .modal {
            overflow: hidden;
        }

        /* Anytime the body has the loading class, our
           modal element will be visible */
        body.loading .modal {
            display: block;
        }

    </style>
@endsection

@section('content')
    <div class="content mt-5 mb-5">
        <div class="container">
            <div id="response-message-success" class="alert alert-success" style="display: none"></div>
            <fieldset>
                <div class="reg-log-form p-3 my-3">
                    <legend><i class="fa fa-plus"></i> Add New Course</legend>
                    <hr>
                    <form id="submit-new-course">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputTitle">Course Title</label>
                                    <input type="text" name="title" class="form-control" id="inputTitle" value="{{ Request::old('title')? : '' }}"  placeholder="Enter the course title">
                                </div>
                                <div class="form-group">
                                    <label for="inputCode">Course Code</label>
                                    <input type="text" name="code" class="form-control" id="inputCode" value="{{ Request::old('code')? : '' }}"  placeholder="Enter the course code">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputStartDate">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="inputStartDate" value="{{ Request::old('start_date')? : '' }}"  placeholder="Enter the course start date">
                                </div>
                                <div class="form-group">
                                    <label for="inputEndDate">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="inputEndDate" value="{{ Request::old('end_date')? : '' }}"  placeholder="Enter the course end date">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseSpecialization">Course Specialization</label>
                                    <select name="course_specialization" class="form-control" id="inputCourseSpecialization" value="{{ Request::old('course_specialization')? : '' }}"  data-placeholder="Select the specialization" style="width: 100%">
                                        <option value="null">Select....</option>
                                        @foreach($specializations as $specialization)
                                        <option class="specs @foreach($specialization->departments as $department) spec-{{$department->id}}@endforeach" value="{{$specialization->id}}">{{$specialization->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseLanguage">Course Language</label>
                                    <select name="course_language" class="form-control" id="inputCourseLanguage"  data-placeholder="Select the language" style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value="English">English</option>
                                        <option value="Arabic">Arabic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseDepartment">Course Department</label>
                                    <select name="course_department" class="form-control" id="inputCourseDepartment"  value="{{ Request::old('course_department')? : '' }}" style="width: 100%">
                                        <option value="null">Select....</option>
                                        @foreach($departments as $department)
                                        <option class="deps @foreach($department->specializations as $specialization) dep-{{$specialization->id}}@endforeach" value="{{$department->id}}">{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCommitment">Course Commitment</label>
                                    <select name="commitment" class="form-control" id="inputCommitment"   style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value=1>1</option>
                                        <option value=2>2</option>
                                        <option value=3>3</option>
                                        <option value=4>4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group}}">
                                    <label for="inputCourseDescription">Course Description</label>
                                    <textarea name="description" class="form-control" id="inputCourseDescription"  placeholder="Enter the course description"></textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputHowToPass">How To Pass The Course</label>
                                    <textarea name="how_to_pass" class="form-control" id="inputHowToPass"  placeholder="How student pass this course?"></textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <br>
                                <button  class="btn btn-primary">Create New Course</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/newCourseForm.js') }}"></script>
    <script>
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
@endsection
