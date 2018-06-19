@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Edit Specialization '.$specialization->name)


@section('admin_content')

<div class="card">
  	<div class="card-body">
		@include('_partials.errors')
		<h3 class="f-rw">Edit Specialization : <a href="{{ route('specialization.show',$specialization->id)}}"><strong>{{$specialization->name}}</strong></a></h3>
		<form action="{{ route('specialization.update',$specialization->id) }}" method="POST" role="form" autocomplete="off">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
			<div class="form-group">
			  <label for="specialization">Specialization Name:</label>
			  <input type="text" class="form-control" id="specialization"
				  placeholder="Enter Specialization Name" name="specialization"
				  @if (!empty(old('specialization')))
					value="{{ old('specialization') }}"
				  @else
					value="{{ $specialization->name }}"
				  @endif
				  >
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		  </form>
	</div>
</div>

@endsection
