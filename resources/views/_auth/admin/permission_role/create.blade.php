@extends('_layouts.app')
@section('title', 'Create Role')


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-5">
		<div class="row">
			<div class="offset-lg-1 col-lg-10 col-sm-12">
                <h1 class="display-4 mb-5 f-rw ">New Role and Permissions</h1>
								
                @include('_partials.errors')
				<form action="{{ route('prole.store') }}" method="POST" role="form" autocomplete="off">
					{{ csrf_field() }}
					<div class="form-group">
                        <label for="name">Role Name:</label>
                        <input type="text" class="form-control" id="name"
                            placeholder="Enter Role Name" name="name" value="{{ old('name', '') }}" required>
                    </div>
                    <div class="row">
                            <table class="table table-hover">
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
                                            <input class="form-check-input" type="checkbox" name="create{{$pindex->index}}">
                                        </td>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="read{{$pindex->index}}">
                                        </td>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="update{{$pindex->index}}">
                                        </td>
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="delete{{$pindex->index}}">
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
	</div>
@endsection
