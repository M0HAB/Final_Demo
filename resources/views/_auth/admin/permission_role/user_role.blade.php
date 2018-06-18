@extends('_Auth.admin.admin_layout.admin')
@section('title', 'User '.$user->fname.' Permissions')


@section('admin_content')
<div class="card">
  	<div class="card-body">
	  	<h3 class="pb-2 f-rw "><strong><a href="{{route('admin.user.profile', ['id'=>$user->id])}}">{{$user->fname.' '.$user->lname}}</a></strong> permissions
            @if($user->permission === null)
            <span class="badge badge-light">Default</span>
            @else
            <span class="badge badge-light">Custom</span>
            @endif
        </h3>

		@include('_partials.errors')
		<form action="{{ route('prole.user.store', ['id' => $user->id ]) }}" method="POST" role="form" autocomplete="off">
			{{ csrf_field() }}

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
										<input type="checkbox" class="custom-control-input" id="customCheck1-{{$key}}" name="create{{$pindex->index}}"
                                        @if(old('create'.$pindex->index))
                                        checked
                                        @endif>
										<label class="custom-control-label" for="customCheck1-{{$key}}"></label>
									</div>

									{{-- <input class="form-check-input" type="checkbox" name="create{{$pindex->index}}"> --}}
								</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck2-{{$key}}" name="read{{$pindex->index}}"
                                        @if(old('read'.$pindex->index))
                                        checked
                                        @endif>
										<label class="custom-control-label" for="customCheck2-{{$key}}"></label>
									</div>

									{{-- <input class="form-check-input" type="checkbox" name="read{{$pindex->index}}"> --}}
								</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck3-{{$key}}" name="update{{$pindex->index}}"
                                        @if(old('update'.$pindex->index))
                                        checked
                                        @endif>
										<label class="custom-control-label" for="customCheck3-{{$key}}"></label>
									</div>
									{{-- <input class="form-check-input" type="checkbox" name="update{{$pindex->index}}"> --}}
								</td>
								<td>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="customCheck4-{{$key}}" name="delete{{$pindex->index}}"
                                        @if(old('delete'.$pindex->index))
                                        checked
                                        @endif>
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
            <button type="submit" name="revert" class="btn btn-primary float-right">Revert to default</button>

		</form>

  	</div>
</div>
@endsection
