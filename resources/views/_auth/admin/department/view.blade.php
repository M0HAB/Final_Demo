@extends('_Auth.admin.admin_layout.admin')
@section('title', 'View Department '.$department->name)


@section('admin_content')



<div class="card">
  	<div class="card-body">
		@include('_partials.errors')
        <h3 class="f-rw"><strong>{{$department->name}}</strong> Department
            <a class="btn btn-link text-primary p-0" href="{{ route('department.edit',$department->id)}}" title="Edit Department"><i class="fas fa-edit fa-lg"></i></a>
            <a class="btn btn-link text-primary p-0" href="{{ route('department.spec.add',$department->id)}}" title="Add Specialization"><i class="fas fa-plus"></i></a>
        </h3>
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
                <tr>
                    <td>Number of Students</td>
                    <td>{{$department->student_count}}</td>
                </tr>
            </tbody>
        </table>
  	</div>
</div>

@endsection
