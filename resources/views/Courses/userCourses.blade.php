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
                @if(Auth::User()->isInstructor())
                    <div class="offset-lg-6 col-lg-2">
                        <a class="btn btn-success" href="{{ route('course.getNewCourseForm') }}"><i class="fa fa-plus"></i> <strong>Add New Course</strong></a>
                    </div>
                @endif                   
            </div>  

            <hr class="mb-5">
            <div class="row">
                @foreach($courses as $course)
                    <div class=" col-lg-6">
                        <div class="card dark-border mb-3">
                            <div class="card-body">
                                <h4 class="card-title f-rw mb-3">{{ $course->title }}</h4>
                                <p class="card-text text-muted mb-1">{{ $course->description }}</p>
                                <span class="badge text-white text-uppercase mb-4 {{ $course->is_active ? 'badge-success': 'bg-danger' }}">{{ $course->is_active ? 'Active': 'Not Active' }}</span>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" class="btn btn-outline-primary ">View Course</a>
                                    </div>
                                    @if(Auth::User()->isInstructor())
                                        <div class="col-lg-6">
                                            <a class="btn btn-outline-primary float-right" href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}">Update Course</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>










                        {{--  <div class="card text-center mt-5 ">
                            <div class="card-header course-card-header p-0">
                                @if(Auth::User()->isInstructor())
                                <div class="row">
                                    <div class="col-lg-12">
                                        
                                        <a class="nav-link" href="{{ route('course.getUpdateCourseForm', ['id' => $course->id]) }}">Update Course</a>
                                    </div>
                                    <div class="col-lg-6">
                                        
                                        <span id="course-status" class="nav-link text-black font-weight-bold {{ $course->is_active ? 'bg-success': 'bg-white' }}" >{{ $course->is_active ? 'Activated Course': 'Deactivated Course' }}</span>
                                    </div>
                                    <div class="col-lg-6">
                                        
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="card-block mt-3 mb-3 p-2">
                                <h4 class="card-title f-rw text-left">{{ $course->title }}</h4>
                                <span class="badge badge-danger {{ $course->is_active ? 'bg-success': 'bg-danger' }}">{{ $course->is_active ? 'Activated Course': 'Deactivated Course' }}</span>
                                <p class="card-text text-muted">{{ $course->description }}</p>
                                <a href="{{ route('course.viewCourseModules', ['id' => $course->id]) }}" class="btn  btn-outline-primary">View Course</a>
                            </div>

                        </div>  --}}
                    </div>
                @endforeach
            </div>
@endsection
