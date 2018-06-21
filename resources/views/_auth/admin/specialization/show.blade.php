@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Specializations')


@section('admin_content')
<div class="card">
  	<div class="card-body">
		<h3>Specializations</h3>
	        @if (count($specializations)>0)
	            <table class="table">
	                <thead>
	                    <tr>
	                        <th>Specialization Name</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    @foreach ($specializations as $spec)
	                    <tr id="specialization_container_{{$spec->id}}">
	                        <td>
	                            <a href="{{ route('specialization.show',$spec->id)}}" class="font-weight-bold forum-nav">{{$spec->name}}</a>
	                        </td>
                            <td>
								<button class="btn btn-link text-primary p-0" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$spec->id}}" data-type="specialization">
										<span class="fas fa-trash fa-lg "></span>
								</button>
                            </td>
	                    </tr>
	                    @endforeach
	                </tbody>
	            </table>
	        @else
	            <div class="col-md-12 col-sm-12">
	                    No Specializations Found
	            </div>
	        @endif

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
