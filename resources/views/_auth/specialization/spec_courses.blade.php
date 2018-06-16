@extends('_layouts.app')
@section('title', $specialization->name.' - Courses')


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$specialization->name}}</strong> Specialization Courses</h3>
</div>
<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Code</th>
                <th scope="col">Instructor</th>
            </tr>
        </thead>

        <tbody>
            @foreach($specialization->courses as $course)
            <tr>
                <td>{{$course->id}}</td>
                <td><a href="{{route('course.viewCourseModules', $course->id)}}">{{ucfirst($course->title)}}</a></td>
                <td>{{$course->code}}</td>
                @if(Auth::user()->id == $course->instructor->id)
                <td>{{$course->instructor->fname.' '.$course->instructor->lname}}</td>
                @else
                <td><a href="{{route('messages.show', $course->instructor->id)}}">{{$course->instructor->fname.' '.$course->instructor->lname}}</a></td>
                @endif
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
