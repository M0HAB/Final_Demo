@extends('_layouts.app')
@section('title', 'Departments')


@section('content')
<!-- Start: Content -->

<h3 class="f-rw">Departments
	@if(canCreate('Department'))
	<a href="{{ route('departments.create')}}">
		<button class="btn btn-primary" href="{{ route('departments.create')}}" title="Create">
			<span class="fas fa-plus"></span> Create Department
		</button>
	</a>
	@endif
</h3>
<div class="row justify-content-center">
    @if (count($departments)>0)
        <table class="table">
            <thead>
                <tr>
                    <th>Department Name</th>
                    @if (canDelete('Department'))
                        <th></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($departments as $dep)
                <tr id="department_container_{{$dep->id}}">
                    <td>
                        <a href="{{ route('departments.show',$dep->id)}}" class="font-weight-bold forum-nav">{{$dep->name}}</a>
                    </td>
                    @if (canDelete('Department'))
                        <td>
																<button class="btn btn-danger" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$dep->id}}" data-type="department">
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
            @if (canCreate('Department'))
                <a href="{{ route('departments.create') }}" class="btn btn-success">
                    No Departments . Create Department Here !
                </a>
            @else
                No Departments Found
            @endif

        </div>
    @endif

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
