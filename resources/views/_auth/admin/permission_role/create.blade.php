@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Create Role')


@section('admin_content')
<div class="card">
  	<div class="card-body">
	  	<h3 class="pb-2 f-rw ">New Role and Permissions</h3>

		@include('_partials.errors')
		<form action="{{ route('prole.store') }}" method="POST" role="form" autocomplete="off">
			{{ csrf_field() }}
			<div class="form-group">
				<label for="name">Role Name:</label>
				<input type="text" class="form-control" id="name"
					placeholder="Enter Role Name" name="name" value="{{ old('name', '') }}" required>
			</div>
			<div class="row">
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Create</th>
								<th>Read</th>
								<th>Update</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($pindexes as $key => $pindex)
							<tr>
								<td>
									{{$pindex->index}}
								</td>
								<td>
									{{$pindex->name}}
								</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck1-{{$key}}" name="create{{$pindex->index}}">
										<label class="custom-control-label" for="customCheck1-{{$key}}"></label>
									</div>

									{{-- <input class="form-check-input" type="checkbox" name="create{{$pindex->index}}"> --}}
								</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck2-{{$key}}" name="read{{$pindex->index}}">
										<label class="custom-control-label" for="customCheck2-{{$key}}"></label>
									</div>

									{{-- <input class="form-check-input" type="checkbox" name="read{{$pindex->index}}"> --}}
								</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck3-{{$key}}" name="update{{$pindex->index}}">
										<label class="custom-control-label" for="customCheck3-{{$key}}"></label>
									</div>
									{{-- <input class="form-check-input" type="checkbox" name="update{{$pindex->index}}"> --}}
								</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck4-{{$key}}" name="delete{{$pindex->index}}">
										<label class="custom-control-label" for="customCheck4-{{$key}}"></label>
									</div>
									{{-- <input class="form-check-input" type="checkbox" name="delete{{$pindex->index}}"> --}}
								</td>


							</tr>
							@endforeach
						</tbody>
					</table>

				</div>

			<button type="submit" name="submit" class="btn btn-primary">Submit</button>
		</form>

  	</div>
</div>
@endsection
