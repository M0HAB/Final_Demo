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
                                @endif
                                <p>
                                    <a href="{{ route('course.studentGrades.index', ['id' => $course->id]) }}" class="ml-1"><i class="fas fa-graduation-cap mr-1"></i>Student grades</a>
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-5 text-center">
                        <a href="{{ route('course.listUserCourses') }}" style="width: 100%" class="btn btn-success"><i class="fas fa-list"></i> Courses Catalog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection