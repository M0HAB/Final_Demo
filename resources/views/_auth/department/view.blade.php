@extends('_layouts.app')
@section('title', 'View Department '.$department->name)


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$department->name}}</strong> Department</h3>
</div>
<div class="row">
    <table class="table">
        <tbody>
            <tr>
                <td>Department Head</td>
                @if(Auth::user()->id != $department->Dep_Head_ID)
                    <td><a href="{{route('messages.show', $department->Dep_Head_ID)}}">{{$department->head_name}}</a></td>
                @else
                    <td>{{$department->head_name}}</td>
                @endif
            </tr>
			<tr>
                <td>Department Courses</td>
                <td><a href="{{route('user.department.courses', $department->id)}}">View Courses</a></td>
            </tr>
            <tr>
                <td>Department Courses</td>
                <td><a href="{{route('user.department.specializations', $department->id)}}">View Specializations</a></td>
            </tr>
            <tr>
                <td>Number of Students</td>
                <td>{{$department->student_count}}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
