@extends('_layouts.app')
@section('title', $department->name.' - Specializations')


@section('content')
<!-- Start: Content -->
<div class="row">
    <h3 class="f-rw"><strong>{{$department->name}}</strong> department Specializations</h3>
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
            @foreach($department->specializations as $specialization)
            <tr>
                <td>{{$specialization->id}}</td>
                <td><a href="{{route('specialization.show', $specialization->id)}}">{{ucfirst($specialization->name)}}</a></td>
                <td>{{count($specialization->courses->where('course_department', $department->id))}}</td>

            </tr>
            @endforeach

        </tbody>
    </table>
</div>
@endsection
