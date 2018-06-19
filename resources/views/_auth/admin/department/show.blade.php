@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Departments')


@section('admin_content')
<!-- Start: Content -->


<div class="card">
  	<div class="card-body">
		<h3 class="f-rw">Departments</h3>
	    @if (count($departments)>0)
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>Name</th>
						<th>No. of Specializations</th>
						<th>No. of Courses</th>
						<th>No. of Students</th>
                        <th>Actions</th>
	                </tr>
	            </thead>
	            <tbody>
	                @foreach ($departments as $dep)
	                <tr id="department_container_{{$dep->id}}">
	                    <td>
	                        <a href="{{ route('department.show',$dep->id)}}" class="font-weight-bold forum-nav">{{$dep->name}}</a>
	                    </td>
						<td>{{count($dep->specializations)}}</td>
						<td>{{count($dep->courses)}}</td>
						<td>{{count($dep->getStudents)}}</td>
	                    <td>
							<a href="{{ route('department.edit',$dep->id)}}"><button class="btn btn-success mb-1"><i class="fas fa-edit" title="Edit Department"></i></button></a>
							<button class="btn btn-danger mb-1" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$dep->id}}" data-type="department">
									<span class="fas fa-trash fa-lg "></span>
							</button>
	                    </td>
	                </tr>
	                @endforeach
	            </tbody>
	        </table>
	    @else
	        <div class="col-md-12 col-sm-12">
	            <br>
	            <a href="{{ route('department.create') }}" class="btn btn-success">
	                No Departments . Create Department Here !
	            </a>
	        </div>
	    @endif
  	</div>
</div>
@include('_partials.modal_confirm')

@endsection
@section('scripts')
<script src="{{asset('js/axios.min.js')}}"></script>
<script>
  var api_token = "{{ Auth::user()->api_token}}";
</script>
<script src="{{asset('js/modal_confirm.js')}}" charset="utf-8"></script>
@endsection
