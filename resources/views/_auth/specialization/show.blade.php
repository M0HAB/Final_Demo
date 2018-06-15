@extends('_layouts.app')
@section('title', 'Specializations')


@section('content')
<!-- Start: Content -->
<div class="content mt-5 mb-4">
	<h3>Specializations
		@if(canCreate('Specialization'))
		<a href="{{ route('specialization.create')}}">
			<button class="btn btn-primary" href="{{ route('specialization.create')}}" title="Create">
				<span class="fas fa-plus"></span> Create Specialization
			</button>
		</a>
		@endif
	</h3>
	<div class="row justify-content-center">
        @if (count($specializations)>0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Specialization Name</th>
                        @if (canDelete('Specialization'))
                            <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($specializations as $spec)
                    <tr id="specialization_container_{{$spec->id}}">
                        <td>
                            <a href="{{ route('specialization.show',$spec->id)}}" class="font-weight-bold forum-nav">{{$spec->name}}</a>
                        </td>
                        @if (canDelete('Specialization'))
                            <td>
								<button class="btn btn-danger" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$spec->id}}" data-type="specialization">
										<span class="far fa-trash-alt fa-lg "></span>
								</button>
                            </td>
                        @endif

                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="col-md-12 col-sm-12">
                <br>
                @if (canCreate('Specialization'))
                    <a href="{{ route('specialization.create') }}" class="btn btn-success">
                        No Specializations . Create Specialization Here !
                    </a>
                @else
                    No Specializations Found
                @endif

            </div>
        @endif
	</div>
</div> <!-- End: Content -->
@include('_partials.modal_confirm')

@endsection
@section('scripts')
<script src="{{asset('js/axios.min.js')}}"></script>
<script>
  var api_token = "{{ Auth::user()->api_token}}";
</script>
<script src="{{asset('js/modal_confirm.js')}}" charset="utf-8"></script>
@endsection
