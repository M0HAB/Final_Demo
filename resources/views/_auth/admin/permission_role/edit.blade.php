@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Edit '.$role->name.' Permissions')


@section('admin_content')
<div class="card">
	<div class="card-body">
		<h3 class="mb-2 f-rw ">Edit <strong>{{$role->name}}</strong> Permissions</h3>
		@include('_partials.errors')
		<form action="{{ route('prole.update',$role->id) }}" method="POST" role="form" autocomplete="off">
			{{ csrf_field() }}
			<input type="hidden" name="_method" value="PUT">
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
					@foreach ($pindexes as $pindex)
					<tr>
						<td>
							{{$pindex->index}}
						</td>
						<td>
							{{$pindex->name}}
						</td>
						<td>
							<input class="form-check-input" type="checkbox" name="create{{$pindex->index}}"
															@if(old('create'.$pindex->index))
															checked
															@endif
															>
						</td>
						<td>
							<input class="form-check-input" type="checkbox" name="read{{$pindex->index}}"
															@if(old('read'.$pindex->index))
															checked
															@endif
															>
						</td>
						<td>
							<input class="form-check-input" type="checkbox" name="update{{$pindex->index}}"
															@if(old('update'.$pindex->index))
															checked
															@endif
															>
						</td>
						<td>
							<input class="form-check-input" type="checkbox" name="delete{{$pindex->index}}"
															@if(old('delete'.$pindex->index))
															checked
															@endif
															>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>

			<button type="submit" name="submit" class="btn btn-primary float-right">Submit</button>
		</form>
	</div>
</div>
<!-- Start: Content -->
	<div class="content">
		<div class="row">
			<div class="offset-lg-1 col-lg-10 col-sm-12">


			</div>
		</div>
	</div>
@endsection
