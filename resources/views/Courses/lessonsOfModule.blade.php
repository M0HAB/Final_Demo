@extends('_layouts.app')

@section('title')
    {{ $module->title }}
@endsection

@section('styles')
    <style>
        /*body{
            background-color: #fafbfc;
            height: auto;
        }*/
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
    {{-- Start Breadcrumbs--}}
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item text-success">Courses</li>
                    <li class="breadcrumb-item text-success"><a href="/Courses/{{$course->id}}">{{ $course->title }}</a></li>
                    <li class="breadcrumb-item text-success">Module</li>
                    <li class="breadcrumb-item active"><a href="/Courses/{{$course->id. "/Modules/" .$module->id}}">{{ $module->title }}</a></li>

                </ol>
            </div>
        </div>
        {{-- End Breadcrumbs--}}

    <div class="row">
        <div class="col-lg-12">
            <div class="jumbotron bg-white text-left p-3 mb-5">
                <h4 class="text-muted text-uppercase">module</h4>
                <h2 class="f-rw" style="letter-spacing: 2px">{{ $module->title }}</h2>
                <p>{{ $module->introduction }}</p>
                <a href="#" class="btn btn-primary mt-3">View Module Info.</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="col-lg-12">
                <table class="table" style="border: 1px solid #DEE2E6">
                    <thead class="bg-light text-black">
                        <tr>
                            <th class="f-rw-bold">LESSONS</th>
                        </tr>
                    </thead>
                    <tbody id="module-lessons">
                    </tbody>
                </table>
            </div>

            <!--------------------------------------------------------------------->
            <div class="col-lg-12">
                <table class="table mt-5" style="border: 1px solid #DEE2E6">
                    <thead class="bg-light">
                    <tr>
                        <th class="f-rw-bold">ASSESSMENTS</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($assignments as $assignment)
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-lg-12">
                                        @if(is_null($assignment->file))
                                            No File Attached
                                        @else
                                            <a class="font-weight-bold text-success forum-nav" href="{{ asset("uploads\assignments") }}\{{$assignment->file}}" download="{{$assignment->file}}">
                                                <i class="fa fa-download mr-2"></i>
                                                {{ $assignment->title }}
                                            </a>
                                        @endif
                                    </div>
                                    <div class="col-sm-7">
                                        <p class="ml-4"><span class="text-muted font-weight-bold">Due:</span><span class="text-danger ml-1">{{date('d-m-Y', strtotime($assignment->deadline))}}</span></p>
                                    </div>
                                    @if(Auth::User()->isStudent())
                                        <div class="col-sm-5">
                                            @if(!Auth::User()->checkIfStudentDeliveredAss($assignment))
                                                <a href="{{ route('assignment.deliver', ['course_id' => $course->id, 'module_id' => $module->id, 'id' => $assignment->id]) }}" class="text-info"><i class="far fa-envelope-open mr-1"></i>Deliver</a>
                                            @else
                                                <span class="text-success"><i class="fas fa-check mr-1"></i>Delivered</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <span>The module has no assignments</span>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <td>
                            <a href="{{ route('assignments.index', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="text-primary font-weight-bold">Show More Details & Actions<i class="fa fa-angle-right ml-1"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--------------------------------------------------------------------->
            <div class="col-lg-12">
                <table class="table table-hover mt-5" style="border: 1px solid #DEE2E6">
                    <thead class="bg-primary f-rw-bold bg-light">
                    <tr>
                        <th class="f-rw-bold text-uppercase">Quizzes</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($quizzes as $quiz)
                        <tr>
                            <td>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <span class="font-weight-bold text-success forum-nav">
                                            <i class="fas fa-question-circle mr-1"></i>
                                            {{ $quiz->title }}
                                            @if(Auth::User()->isInstructor())
                                                <span id="quiz-status" class="p-1 rounded text-white  {{ $quiz->is_active ? 'badge badge-success': 'badge badge-danger' }}" >{{ $quiz->is_active ? 'Activated quiz': 'Deactivated quiz' }}</span>
                                            @endif

                                        </span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-7">
                                        <p class="ml-4"><span class="text-muted font-weight-bold">Due:</span><span class="text-danger ml-1">{{date('d-m-Y', strtotime($quiz->deadline))}}</span></p>
                                    </div>
                                    @if(Auth::User()->isStudent())
                                        <div class="col-sm-5">
                                            @if(!Auth::User()->checkIfStudentSubmittedQuiz($quiz))
                                                <a href="{{ route('quiz.getSubmitQuizForm', ['course_id' => $course->id, 'module_id' => $module->id, 'quiz_id' => $quiz->id]) }}" class="text-info"><i class="far fa-file mr-1"></i>Start quiz</a>
                                            @else
                                                <span class="text-success"><i class="fas fa-check mr-1"></i>Submitted</span>
                                            @endif
                                        </div>
                                    @elseif(Auth::User()->isInstructor())
                                        <div class="col-sm-5">
                                            <a href="#" class="text-info"><i class="fas fa-eye mr-1"></i>preview</a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <span>The module has no Quizzes</span>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!--------------------------------------------------------------------->
            <div class="col-lg-12">
                <table class="table table-hover mt-5 " style="border: 1px solid #DEE2E6">
                        <thead class="bg-primary bg-light f-rw-bold">
                            <tr>
                                <th>ACTIVITIES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(Auth::User()->isInstructor())
                                <tr>
                                    <td>
                                        <a href="{{ route('course.addNewVideo', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1 text-primary"><i class="fas fa-plus mr-1"></i>Add New Lesson</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('quiz.getNewQuizForm', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1 text-primary"><i class="fas fa-plus mr-1"></i>Add New Quiz</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('assignments.create', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1 text-primary"><i class="fas fa-plus mr-1"></i>Add New Assignment</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('course.getUpdateModuleForm', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1 text-primary"><i class="fas fa-edit mr-1"></i>Update The Module</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('assignment.delivered', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1 text-primary"><i class="fas fa-eye mr-1"></i>Student Assignments</a>
                                    </td>
                                </tr>

                            @elseif(Auth::User()->isStudent())
                                <tr>
                                    <td>
                                        <a href="{{ route('assignment.delivered', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1 text-primary"><i class="fas fa-folder mr-1"></i>My Assignment Directory</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="ml-1"><i class="fas fa-question mr-1"></i>Discussion Forum</a>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                </table>
            </div>
            <div class="col-lg-12 mt-4 mb-2 text-center">
                <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" style="width: 100%" class="btn btn-primary"><i class="fas fa-angle-left mr-1"></i> Course Modules</a>
            </div>
        </div>

        <div class="col-lg-8 border mb-3">
            <div class="card-block mt-3 mb-3 p-2">
                <h6 class="card-title text-uppercase text-primary"><b>Lesson:</b></h6>
                <div id="lesson-details"></div>
                <hr>
                <div class="col-sm12 mt-3" id="my-video"></div>
                <hr>
                <h6 class="card-title text-uppercase text-primary"><b>Recap:</b></h6>
                <p id="lesson-recap"></p>
            </div>
        </div>
        <div class="modal"><!-- Place at bottom of page --></div>
    </div>
@endsection

@section('scripts')
    <script>
        var courseID = {!! json_encode($course->id) !!};
        var moduleID = {!! json_encode($module->id) !!};
        $body = $("body");
        $(document).on({
            ajaxStart: function() { $body.addClass("loading"); },
            ajaxStop: function() { $body.removeClass("loading"); }
        });
    </script>
    <Script src="{{ asset('js/lessonsOfModule.js')}}"></Script>
@endsection
