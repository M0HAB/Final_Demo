@extends('_layouts.app')

@section('title')
    {{ $module->title }}
@endsection

@section('styles')
    <style>
        body{
            background-color: #fafbfc;
            height: auto;
        }

    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="jumbotron border text-center mt-5" style="box-shadow: 5px 5px 10px gray;background: url('{{ asset('course_images/courseBackground.png') }}');background-size: 100%">
                <h4 class="text-muted text-uppercase">module</h4>
                <h2 style="color: #02b3e4;letter-spacing: 2px">{{ $module->title }}</h2>
                <p>{{ $module->introduction }}</p>
                <a href="#" class="btn btn-primary mt-3">View Module Info.</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 mb-3">
            <div class="col-sm-12">
                <table class="table table-hover" style="box-shadow: 5px 5px 10px gray">
                    <thead class="bg-primary" style="color: #02b3e4">
                        <tr>
                            <th>LESSONS</th>
                        </tr>
                    </thead>
                    <tbody id="module-lessons">
                    </tbody>
                </table>
            </div>

            <!--------------------------------------------------------------------->
            <div class="col-sm-12">
                <table class="table table-hover mt-5" style="box-shadow: 5px 5px 10px gray">
                    <thead class="bg-primary" style="color: #02b3e4">
                    <tr>
                        <th>ASSESSMENTS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            <a href="#" class="font-weight-bold forum-nav">Assessment 1</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#" class="font-weight-bold forum-nav">Assessment 1</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--------------------------------------------------------------------->
            <div class="col-sm-12">
                <table class="table table-hover mt-5 " style="box-shadow: 5px 5px 10px gray">
                        <thead class="bg-primary" style="color: #02b3e4">
                            <tr>
                                <th>ACTIVITIES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(Auth::User()->role == 'instructor')
                                <tr>
                                    <td>
                                        <a href="{{ route('course.addNewVideo', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1"><i class="fas fa-plus mr-1"></i>Add New Lesson</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="ml-1"><i class="fas fa-plus mr-1"></i>Add New Quiz</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('assignments.create', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1"><i class="fas fa-plus mr-1"></i>Add New Assignment</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('course.getUpdateModuleForm', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1"><i class="fas fa-edit mr-1"></i>Update The Module</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="{{ route('assignment.delivered', ['course_id' => $course->id, 'module_id' => $module->id]) }}" class="ml-1"><i class="fas fa-eye mr-1"></i>Student Assignments</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="ml-1"><i class="fas fa-graduation-cap mr-1"></i>Student Grades</a>
                                    </td>
                                </tr>
                            @elseif(Auth::User()->role == 'student')
                                <tr>
                                    <td>
                                        <a href="#" class="ml-1"><i class="fas fa-plus mr-1"></i>Deliver Assignment</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#" class="ml-1"><i class="fas fa-folder mr-1"></i>My Assignment Directory</a>
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
            <div class="col-sm-12 mt-4 mb-2 text-center">
                <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" style="width: 100%" class="btn btn-success"><i class="fas fa-angle-left mr-1"></i> Course Modules</a>
            </div>
        </div>

        <div class="col-sm-8 border mb-3">
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
    </div>
@endsection

@section('scripts')
    <script>
        var courseID = {!! json_encode($course->id) !!};
        var moduleID = {!! json_encode($module->id) !!};
    </script>
    <Script src="{{ asset('js/lessonsOfModule.js')}}"></Script>
@endsection