@extends('_layouts.app')

@section('title')
    {{ $course->title }}
@endsection

@section('styles')
    <style>
        body{
            background: url('{{ asset('course_images/courseBackground.png') }}');
            background-color: #fafbfc;
            height: auto;
            background-size: 100%;
        }
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
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="jumbotron  text-center mt-5" style="background-color: white;box-shadow: 5px 5px 10px gray">
                <img class="mb-2" src="{{ asset('profile pictures/avatar2.png') }}" alt="Avatar" style="border-radius: 50%;width: 150px;height: 150px;box-shadow: 5px 5px 10px 5px gray">
                <h3  style="color: #ad660e">{{ $course->title }}</h3>
                <h6>By: Dr/{{ $course->fname }} {{ $course->lname }}</h6>
                <a href="#" class="btn btn-primary mt-3">View Course Info.</a>
            </div>
        </div>
        <div class="col-sm-8 mb-4">
            <h6 class="text-uppercase border-left border-primary"><strong class="ml-2">Course Modules</strong></h6>
            @if(count($modules) > 0)
                @for($i=0; $i < count($modules); $i++)
                    <div class="card mt-4" style="box-shadow: 5px 5px 10px gray">
                        <div class="card-block mt-3 mb-3 p-2">
                            <h6 class="card-title text-uppercase text-success">Module {{ $i + 1 }}</h6>
                            <h4 class="card-title text-muted">{{ $modules[$i]->title }}</h4>
                            <p>{{ $modules[$i]->introduction }}</p>
                            <a href="{{ route('course.displayLessonsOfModules',['course_id' => $course->id, 'module_id'=> $modules[$i]->id]) }}" class="btn  btn-outline-primary mt-2">View Module</a>
                            <hr>
                            <p><b><i class="far fa-clock text-success"></i> Commitment:</b> {{ $modules[$i]->commitment }} hours</p>
                        </div>
                    </div>
                @endfor
            @else
                <div class="alert alert-info mt-4">
                    <p><i class="fa fa-info-circle mr-2"></i>This course has no modules.Click <a href="{{ route('course.getNewModuleForm', ['id' => $course->id]) }}"> here </a> to add modules</p>
                </div>
            @endif
        </div>
        <div class="col-sm-4 mb-3">
            <div class="list-group">
                <div class="row">
                    @if(Auth::User()->role == 'instructor')
                        <div class="col-sm-12">
                            <h6 class="text-uppercase border-left border-primary"><strong class="ml-2">Course Activities</strong></h6>
                            <div class="card mt-4" style="box-shadow: 5px 5px 10px gray">
                                <div class="card-block mt-4 mb-3 p-2">
                                    <p>
                                        <a href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}" class="mt-2 text-capitalize"><i class="fa fa-edit"></i> update course information</a>
                                    </p>
                                    <p>
                                        <a href="{{ route('course.getNewModuleForm', ['id' => $course->id]) }}" class="mt-2 text-capitalize"><i class="fa fa-plus"></i> add new module</a>
                                    </p>
                                    <hr>
                                    <form id="submit-course-activation">
                                        @if(!$course->is_active)
                                            <input type="hidden" name="is_active" value='1'>
                                            <p id="submit-status ">
                                                <i id="icon-course-status" class="fas fa-toggle-off "></i><button id="submit-course-status" class="text-success mt-2" style="border: none;background-color: transparent;cursor: pointer">Activate The Course</button>
                                            </p>
                                        @else
                                            <input type="hidden" name="is_active" value='0'>
                                            <p id="submit-status">
                                                <i id="icon-course-status" class="fas fa-toggle-on text-success"></i><button id="submit-course-status" class="text-success mt-2" style="border: none;background-color: transparent;cursor: pointer">Deactivate The Course</button>
                                            </p>
                                        @endif
                                    </form>
                                    <div id="response-message-success" class="alert alert-success mt-2" style="display: none"></div>
                                    <div id="response-message-danger" class="alert alert-danger mt-2" style="display: none"></div>
                                </div>
                    <div class="col-sm-12">
                        <h6 class="text-uppercase border-left border-primary"><strong class="ml-2">Course Activities</strong></h6>
                        <div class="card mt-4" style="box-shadow: 5px 5px 10px gray">
                            <div class="card-block mt-4 mb-3 p-2">
                                <p>
                                    <a href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}" class="mt-2 text-capitalize"><i class="fa fa-edit"></i> update course information</a>
                                </p>
                                <p>
                                    <a href="{{ route('course.getNewModuleForm', ['id' => $course->id]) }}" class="mt-2 text-capitalize"><i class="fa fa-plus"></i> add new module</a>
                                </p>
                                @if (Auth::user()->role == 'instructor')
                                <p>
                                    <a href="{{ route('course.gradeBook.index', ['id' => $course->id]) }}" class="ml-1"><i class="fas fa-cogs mr-1"></i>Grades book setting</a>
                                </p>

                                <p>
                                    <a href="{{ route('course.studentGrades.index', ['id' => $course->id]) }}" class="ml-1"><i class="fas fa-graduation-cap mr-1"></i>Students grades</a>
                                </p>

                                @elseif (Auth::user()->role == 'student')
                                <p>
                                    <a href="{{route('course.studentGrades.show', ['student_id' => Auth::user()->id,'course_id' =>$course->id])}}" class="ml-1"><i class="fas fa-graduation-cap mr-1"></i>My grades</a>
                                </p>
                                @endif

                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12 mt-4  text-center">
                        <a href="{{ route('course.listUserCourses') }}" style="width: 100%" class="btn btn-primary"><i class="fas fa-list"></i> Courses Catalog</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
    </div>
@endsection

@section('scripts')
    @if(Auth::User()->role == 'instructor')
        <script>
            var courseID = {!! json_encode($course->id) !!};
        </script>
    @endif
    <script src="{{ asset('js/courseModules.js') }}"></script>
@endsection

