@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Roles-Permissions')


@section('admin_content')
<div class="card">
  <div class="card-body">
	  <h3 class="pb-2 f-rw">Permissions</h1>
  		<div class="row justify-content-center">
  			<table class="table">
  				<thead>
  					<tr>
  						<th>#</th>
  						<th>Name</th>
  						<th>Permission</th>
  						<th></th>
  						<th></th>
  					</tr>
  				</thead>
  				<tbody>
  					@foreach ($perRole as $x)
  					<tr id="prole_container_{{$x->id}}">
  						<td>
  							{{$x->id}}
  						</td>
  						<td>
  							{{$x->name}}
  						</td>
  						<td>
  							<a href={{ route('prole.show',$x->id)}}>View Permissions for this role</a>
  						</td>
                        <td>
  							<a class="btn btn-link text-primary p-0" href="{{ route('prole.edit',$x->id)}}" title="Edit"><span class="fas fa-edit fa-lg"></span></a>
  						</td>
                        @if($x->id == 1 || $x->id == 2)
  						<td>
							<button class="btn btn-link text-primary p-0" disabled>
									<span class="fas fa-trash fa-lg"></span>
							</button>
  						</td>
                        @else
  						<td>
							<button class="btn btn-link text-primary p-0" type="submit" data-toggle="modal" data-target="#confirm" title="Delete" data-id="{{$x->id}}" data-type="prole">
									<span class="far fa-trash-alt fa-lg"></span>
							</button>
  						</td>
                        @endif
  					</tr>
  					@endforeach
  				</tbody>
  			</table>
  		</div>
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
