@extends('_layouts.app')

@section('title')
    {{ Auth::User()->fname }}'s Courses
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
        <!-- Start: Content -->
    <div class="content mt-5 mb-5 pl-2 pr-2">
        <div class="container">
            @if(Auth::User()->role == 'instructor')
                <div class="text-right">
                    <a href="{{ route('course.getNewCourseForm') }}" ><i class="fa fa-plus"></i> <strong>Add New Course</strong></a>
                </div>
            @endif
            <h6 class="text-uppercase  text-primary text-muted" style="display: block">current enrollments</h6>

            <hr>
            <div class="row">
                @foreach($courses as $course)
                    <div class=" col-sm-6">
                        <div class="card text-center mt-5 " style="box-shadow: 5px 5px 10px gray">
                            <div class="card-header">
                                @if(Auth::User()->role === 'instructor')
                                    <ul class="nav nav-pills card-header-pills">
                                        <li class="nav-item">
                                            <span id="course-status" class="nav-link text-white {{ $course->is_active ? 'bg-success': 'bg-danger' }}" >{{ $course->is_active ? 'Activated Course': 'Deactivated Course' }}</span>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}">Update Course</a>
                                        </li>
                                    </ul>
                                @endif

                            </div>
                            <div class="card-block mt-3 mb-3 p-2">
                                <h4 class="card-title">{{ $course->title }}</h4>
                                <p class="card-text text-muted">{{ $course->description }}</p>
                                <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" class="btn  btn-outline-primary">View Course</a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
