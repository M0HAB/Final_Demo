@extends('_layouts.app')
@section('title', 'Departments')


@section('content')
<!-- Start: Content -->

<h3 class="f-rw">Departments</h3>
<div class="row justify-content-center">
    @if (count($departments)>0)
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
					<th>No. of Specializations</th>
					<th>No. of Courses</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $dep)
                <tr id="department_container_{{$dep->id}}">
                    <td>
                        <a href="{{ route('user.department.show',$dep->id)}}" class="font-weight-bold forum-nav">{{$dep->name}}</a>
                    </td>
					<td>{{count($dep->specializations)}}</td>
					<td>{{count($dep->courses)}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="col-md-12 col-sm-12">
            No Departments Found
        </div>
    @endif

</div>

@endsection
