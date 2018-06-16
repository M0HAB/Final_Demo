@extends('_layouts.app')
@section('title', 'Create Specialization')


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-5">
		<div class="row">
			<div class="offset-lg-1 col-lg-10 col-sm-12">
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
	</div>
@endsection
