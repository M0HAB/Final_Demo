@extends('_layouts.app')
@section('title', $specialization->name.' - Specializations')


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$specialization->name}}</strong> specialization Departments</h3>
</div>
<div class="row">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">No. of Courses in this department</th>
            </tr>
        </thead>

        <tbody>
            @foreach($specialization->departments as $department)
            <tr>
                <td>{{$department->id}}</td>
                <td><a href="{{route('user.department.show', $department->id)}}">{{ucfirst($department->name)}}</a></td>
                <td>{{count($department->courses->where('course_department', $department->id))}}</td>
            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
