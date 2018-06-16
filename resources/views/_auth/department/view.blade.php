@extends('_layouts.app')
@section('title', 'View Department '.$department->name)


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$department->name}}</strong> Department</h3>
    @if (canUpdate('Department'))
        <a href="{{ route('departments.edit',$department->id)}}">
            <span class="far fa-edit" data-toggle="tooltip" data-placement="top" title="Edit this Department"></span>
        </a>
    @endif
</div>
<div class="row">
    <table class="table">
        <tbody>
            <tr>
                <td>Department Head</td>
                <td>{{$department->head_name}}</td>
            </tr>
			<tr>
                <td>Department Courses</td>
                <td><a href="{{route('department.courses', $department->id)}}">View Courses</a></td>
            </tr>
            <tr>
                <td>Department Courses</td>
                <td><a href="{{route('department.specializations', $department->id)}}">View Specializations</a></td>
            </tr>
            @if (canUpdate('Department'))
                <tr>
                    <td>Number of Students</td>
                    <td>{{$department->student_count}}</td>
                </tr>
             @endif

        </tbody>
    </table>
</div>
@endsection
