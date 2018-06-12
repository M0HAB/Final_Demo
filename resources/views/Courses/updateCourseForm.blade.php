@extends('_layouts.app')

@section('title')
    Update Course
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
                    <legend><i class="fa fa-edit"></i> Update <span id="form-course-title-parent"><span id="form-course-title-child">{{ $course->title }}</span></span> Course</legend>
                    <hr>
                    <form id="submit-update-course">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputTitle">Course Title</label>
                                    <input type="text" name="title" class="form-control" id="inputTitle" value="{{ $course->title }}" >
                                </div>
                                <div class="form-group">
                                    <label for="inputCode">Course Code</label>
                                    <input type="text" name="code" class="form-control" id="inputCode" value="{{ $course->code }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputStartDate">Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="inputStartDate" value="{{ $course->start_date }}">
                                </div>
                                <div class="form-group">
                                    <label for="inputEndDate">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="inputEndDate" value="{{ $course->end_date }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseSpecialization">Course Specialization</label>
                                    <select name="course_specialization" class="form-control" id="inputCourseSpecialization" value="{{ Request::old('gender')? : '' }}"  style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value="Computer Science" {{ $course->course_specialization === 'Computer Science'? 'selected' : '' }}>Computer Science</option>
                                        <option value="Data Science" {{ $course->course_specialization === 'Data Science'? 'selected' : '' }}>Data Science</option>
                                        <option value="Embedded System" {{ $course->course_specialization === 'Embedded System'? 'selected' : '' }}>Embedded System</option>
                                        <option value="Communication" {{ $course->course_specialization === 'Communication'? 'selected' : '' }}>Communication</option>
                                        <option value="Electronics" {{ $course->course_specialization === 'Electronics'? 'selected' : '' }}>Electronics</option>
                                        <option value="Basic Science" {{ $course->course_specialization === 'Basic Science'? 'selected' : '' }}>Basic Science</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseLanguage">Course Language</label>
                                    <select name="course_language" class="form-control" id="inputCourseLanguage" style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value="English" {{ $course->course_language === 'English'? 'selected' : '' }}>English</option>
                                        <option value="Arabic" {{ $course->course_language === 'Arabic'? 'selected' : '' }}>Arabic</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCourseDepartment">Course Department</label>
                                    <select name="course_department" class="form-control" id="inputCourseDepartment"   style="width: 100%">
                                        <option value="">Select....</option>
                                        @foreach($departments as $department)
                                        <option value="{{$department->id}}" {{ $course->course_department == $department->id ? 'selected' : '' }}>{{$department->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="inputCommitment">Course Commitment</label>
                                    <select name="commitment" class="form-control" id="inputCommitment"   style="width: 100%">
                                        <option value="">Select....</option>
                                        <option value=1 {{ $course->commitment === 1? 'selected': '' }}>1</option>
                                        <option value=2 {{ $course->commitment === 2? 'selected': '' }}>2</option>
                                        <option value=3 {{ $course->commitment === 3? 'selected': '' }}>3</option>
                                        <option value=4 {{ $course->commitment === 4? 'selected': '' }}>4</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group}}">
                                    <label for="inputCourseDescription">Course Description</label>
                                    <textarea name="description" class="form-control"  id="inputCourseDescription">{{ $course->description }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputHowToPass">How To Pass The Course</label>
                                    <textarea name="how_to_pass" class="form-control" id="inputHowToPass">{{ $course->how_to_pass }}</textarea>
                                </div>
                            </div>

                            <input type="hidden" id="course-id" value="{{ $course->id }}">

                            <div class="col-md-3">
                                <br>
                                <button  class="btn btn-primary">Update The Course</button>
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
    <script src="{{ asset('js/updateCourseForm.js') }}"></script>
    <script>
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
@endsection
