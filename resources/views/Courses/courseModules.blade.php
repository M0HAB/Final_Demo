@extends('_layouts.app')

@section('title')
    {{ $course->title }}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="row mt-3">
                        <div class="col-lg-2">
                            @if (Auth::user()->gender != 1)
                                <img class="mb-2" src="{{ asset('profile pictures/avatar2.png') }}" alt="Avatar" style="border-radius: 50%;width: 80px;height: 80px;">
                            @else
                                <img class="mb-2" src="{{ asset('profile pictures/avatar1.png') }}" alt="Avatar" style="border-radius: 50%;width: 80px;height: 80px;">
                            @endif
                        </div>
                        <div class="col-lg-10">
                            <h3 class="d-inline-block f-rw">{{ $course->title }}</h3>
                            <h6 class="d-block">Dr/ {{ $course->fname }} {{ $course->lname }}</h6>
                            <a href="#" class="btn btn-outline-primary mt-1">View Course Info.</a>
                        </div>
                    </div>
                </div>
                {{--  Modules Section  --}}
                <div class="col-lg-12">
                    <div class="card dark-border mb-3">
                        <div class="card-header f-rw-bold bg-smookie text-uppercase"><i class="fas fa-list-ol mr-2"></i> Modules</div>
                        @if(count($modules) > 0)
                            <div class="card-body">
                                @for($i=0; $i < count($modules); $i++)
                                    <div class="card border-light mb-4">
                                        <div class="card-header bg-white f-rw font-weight-bold">Module {{ $i + 1 }}</div>
                                        <div class="card-body">
                                            <h4 class="card-title f-rw mb-2">{{ $modules[$i]->title }}</h4>
                                            <p class="mb-4">{{ $modules[$i]->introduction }}</p>
                                            <a href="{{ route('course.displayLessonsOfModules',['course_id' => $course->id, 'module_id'=> $modules[$i]->id]) }}" class="btn  btn-outline-primary mt-2">View Module</a>
                                            <p class="mt-3"><i class="far fa-clock text-success"></i> Commitment: {{ $modules[$i]->commitment }} hours</p>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        @else
                            <div class="card-body">
                                <p class="text-center text-muted"><strong>No modules are found</strong>, Please create new module from <a href="{{ route('course.getNewModuleForm', ['id' => $course->id]) }}">Here</a></p>
                            </div>
                        @endif
                    </div>
                </div> <!--End: Modules-->
            </div>
        </div>

        <div class="col-lg-4">
                <div class="list-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card mt-4">
                                    <div class="card-header f-rw-bold bg-smookie text-uppercase">Course Activities</div>
                                    <div class="card-block mb-2 p-3">
                                        @if (Auth::user()->isInstructor())
                                            @if(canUpdate('Course'))
                                                <p class="my-1">
                                                    <a href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}" class=" text-capitalize text-primary"><i class="fa fa-edit mr-1"></i> update course information</a>
                                                </p>
                                            @endif
                                            @if(canCreate('Course'))
                                                <p class="mb-1">
                                                    <a href="{{ route('course.getNewModuleForm', ['id' => $course->id]) }}" class="mt-2 text-capitalize text-primary"><i class="fa fa-plus mr-2"></i> add new module</a>
                                                </p>
                                            @endif
                                            @if(canDelete('Course'))
                                                <form id="submit-course-activation">
                                                    @if(!$course->is_active)
                                                        <input type="hidden" name="is_active" value='1'>
                                                        <p id="submit-status ">
                                                            <i id="icon-course-status" class="fas fa-toggle-off"></i><button id="submit-course-status" class="text-primary" style="border: none;background-color: transparent;cursor: pointer">Activate The Course</button>
                                                        </p>
                                                    @else
                                                        <input type="hidden" name="is_active" value='0'>
                                                        <p id="submit-status">
                                                            <i id="icon-course-status" class="fas fa-toggle-on text-success"></i><button  class="text-primary" style="border: none;background-color: transparent;cursor: pointer">Deactivate The Course</button>
                                                        </p>
                                                    @endif
                                                </form>
                                            @endif
                                            <div id="response-message-success" class="alert alert-success mt-2" style="display: none"></div>
                                            <div id="response-message-danger" class="alert alert-danger mt-2" style="display: none"></div>
                                            @if(canCreate('Course')||canUpdate('Course')||canDelete('Course'))<hr>@endif
                                            @if(canRead('Grade'))
                                                <p class="mb-1">
                                                    <a href="{{ route('course.gradeBook.index', ['id' => $course->id]) }}" class="text-primary"><i class="fas fa-cogs mr-2"></i>Grades book settings</a>
                                                </p>

                                                <p>
                                                    <a href="{{ route('course.studentGrades.index', ['id' => $course->id]) }}" class="text-primary"><i class="fas fa-graduation-cap mr-2"></i>Students grades</a>
                                                </p>
                                            @endif
                                        @elseif (Auth::user()->isStudent())
                                            @if(canRead('Grade'))
                                                <p>
                                                    <a href="{{route('course.studentGrades.show', ['course' =>$course->id, 'student_id' => Auth::user()->id])}}" class="text-primary"><i class="fas fa-graduation-cap mr-2"></i>My grades</a>
                                                </p>
                                            @endif
                                        @endif
                                        @if(count($modules)>0 && $courseModal->discussion && canRead('Discussion'))
                                        <p>
                                            <a href="{{ route('discussion.show', $courseModal->discussion->id) }}" class="text-primary"><i class="fas fa-graduation-cap mr-2"></i>Course Discussion forum</a>
                                        </p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-4 text-center px-0">
                                    <a href="{{ route('course.listUserCourses') }}" class="btn btn-primary btn-block"><i class="fas fa-list"></i> Courses Catalog</a>
                                </div>
                            </div>
                        </div>
                    </div>
        </div>
    </div> <!--End-row-->


@endsection

@section('scripts')
    @if(Auth::User()->isInstructor())
        <script>
            var courseID = {!! json_encode($course->id) !!};
        </script>
    @endif
    <script src="{{ asset('js/courseModules.js') }}"></script>
@endsection
