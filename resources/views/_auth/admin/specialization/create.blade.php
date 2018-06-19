@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Create Specialization')


@section('admin_content')
<!-- Start: Content -->
<div class="card">
  	<div class="card-body">
		@include('_partials.errors')
		<h3 class="f-rw ">Create a New <strong>Specialization</strong></h3>
		<form action="{{ route('specialization.store') }}" method="POST" role="form" autocomplete="off">
			{{ csrf_field() }}
			<div class="form-group">
			<label for="specialization">Specialization Name:</label>
			<input type="text" class="form-control" id="specialization"
				placeholder="Enter Specialization Name" name="specialization" value="{{ old('specialization', '') }}">
			</div>
			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
</div>
@endsection
