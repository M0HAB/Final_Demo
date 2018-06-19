@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Add Specialization to '.$department->name)


@section('admin_content')
<div class="card">
  	<div class="card-body">
		  @include('_partials.errors')
		  <h3 class="f-rw ">Add Specialization to <a href="{{ route('department.show',$department->id)}}"><strong>{{$department->name}}</strong></a> Department</h3>
		  @if(count($specializations)>0)

	  			  <form action="{{ route('department.spec.store', $department->id) }}" method="POST" role="form" autocomplete="off">
	  				  {{ csrf_field() }}

	  				  <div class="form-group">
	  					  <label for="specialization">Select Specialization</label>
	  					  <select class="form-control" id="specialization" name="specialization">
	  						  @foreach($specializations as $specialization)
	  						  <option value="{{$specialization->id}}">{{$specialization->name}}</option>
	  						  @endforeach
	  					  </select>
	  				  </div>
	  				  <button type="submit" name="submit" class="btn btn-primary">Add</button>
	  			  </form>
	  	  @else
	  		  <div class="alert alert-info alert-dismissible fade show w-100 mt-4" role="alert">
	  			  <strong>No specializations found!</strong> either you added them all or none are there
	  			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	  				  <span aria-hidden="true">&times;</span>
	  			  </button>
	  		  </div>
	  	  @endif

  	</div>
</div>
@endsection
