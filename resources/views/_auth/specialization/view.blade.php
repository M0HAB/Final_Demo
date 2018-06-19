@extends('_layouts.app')
@section('title', 'View Specialization '.$specialization->name)


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$specialization->name}}</strong> Specialization</h3>
</div>
<div class="row">
    <table class="table">
        <tbody>
			<tr>
                <td>Specialization Courses</td>
                <td><a href="{{route('user.specialization.courses', $specialization->id)}}">View Courses</a></td>
            </tr>
            <tr>
                <td>Specialization Departments</td>
                <td><a href="{{route('user.specialization.departments', $specialization->id)}}">View Departments</a></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
