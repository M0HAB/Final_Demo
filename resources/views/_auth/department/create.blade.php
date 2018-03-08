@extends('_layouts.app')
@section('title', 'Create Department')


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-5">
		<div class="row">
			<div class="offset-lg-1 col-lg-10 col-sm-12">					
				@include('_partials.errors')
				<h1 class="display-4 mb-5 f-rw ">Create a New Department</h1>					
				<form action="{{ route('department.store') }}" method="POST" role="form" autocomplete="off">
					{{ csrf_field() }}
					<div class="form-group">
					<label for="department">Department Name:</label>
					<input type="text" class="form-control" id="department" 
						placeholder="Enter Department Name" name="department" value="{{ old('department', '') }}">
					</div>
					@if (count($users) > 0)
					<div class="form-group">
							<label for="instructor">Instructor:</label>
							<select class="form-control" id="instructor" name="instructor">
								<option value="null">Please Choose an Instructor</option>
								@foreach ($users as $user)
									<option value="{{$user->id}}" {{ old('instructor') == $user->id ?'selected':'' }}>
										{{$user->fname.' '.$user->lname}}
									</option>
								@endforeach
							</select>
						</div>
					@else
						No Instructors Available
					@endif
					<button type="submit" name="submit" class="btn btn-primary">Submit</button>
				</form>

			</div>
		</div>
	</div>
@endsection