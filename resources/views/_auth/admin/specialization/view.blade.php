@extends('_Auth.admin.admin_layout.admin')
@section('title', 'View Specialization '.$specialization->name)


@section('admin_content')
<div class="card">
  	<div class="card-body">
        <h3 class="f-rw"><strong>{{$specialization->name}}</strong> Specialization
            <a href="{{ route('specialization.edit',$specialization->id)}}" title="Edit Specialization"><button class="btn btn-success"><i class="fas fa-edit"></i></button></a>
        </h3>
        <table class="table">
            <tbody>
    			<tr>
                    <td>Specialization Courses</td>
                    <td><a href="{{route('specialization.courses', $specialization->id)}}">View Courses</a></td>
                </tr>
                <tr>
                    <td>Specialization Departments</td>
                    <td><a href="{{route('specialization.departments', $specialization->id)}}">View Departments</a></td>
                </tr>
            </tbody>
        </table>
	</div>
</div>
@endsection
