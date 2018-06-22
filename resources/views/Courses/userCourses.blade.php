@extends('_layouts.app')

@section('title')
    {{ Auth::User()->fname }}s Courses
@endsection

@section('styles')
    <style>
        body{
            /*background-color: #fafbfc;*/
            height: auto;
        }

    </style>
@endsection

@section('content')
    <!-- Start: Content -->

    {{--  <div class="text-right">
        <a class="btn btn-success" href="{{ route('course.getNewCourseForm') }}" ><i class="fa fa-plus"></i> <strong>Add New Course</strong></a>
    </div>  --}}

    <div class="row">
        <div class="col-lg-4">
            <h6 class="text-uppercase text-primary text-muted mb-2" style="position:relative;top:10px;">current enrollments</h6>
        </div>
        @if(Auth::User()->isInstructor() && canCreate('Course'))
            <div class="offset-lg-6 col-lg-2">
                <a class="btn btn-success" href="{{ route('course.getNewCourseForm') }}"><i class="fa fa-plus"></i> <strong>Add New Course</strong></a>
            </div>
        @endif
    </div>

    <hr class="mb-5">

    <div class="row">
        @foreach($courses as $course)
            <div class="col-lg-6">
                <div class="card dark-border mb-3">
                    <div class="card-body">
                        <h4 class="card-title f-rw mb-3">{{ $course->title }}</h4>
                        <p class="card-text text-muted mb-1">{{ $course->description }}</p>
                        <span class="badge text-white text-uppercase mb-4 {{ $course->is_active ? 'badge-success': 'bg-danger' }}">{{ $course->is_active ? 'Active': 'Not Active' }}</span>
                        <div class="row">
                            <div class="col-lg-6">
                                <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" class="btn btn-outline-primary ">View Course</a>
                            </div>
                            @if(Auth::User()->isInstructor() && canUpdate('Course'))
                                <div class="col-lg-6">
                                    <a class="btn btn-outline-primary float-right" href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}">Update Course</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
