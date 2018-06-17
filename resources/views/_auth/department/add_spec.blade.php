@extends('_layouts.app')
@section('title', 'Add Specialization to '.$department->name)


@section('content')
<!-- Start: Content -->
		<div class="row">
            @if(count($specializations)>0)
    			<div class="offset-lg-1 col-lg-10 col-sm-12">
                    @include('_partials.errors')
    				<h3 class="f-rw ">Add Specialization to <strong>{{$department->name}}</strong> Department</h3>

                    <form action="{{ route('department.spec.store', $department->id) }}" method="POST" role="form" autocomplete="off">
    					{{ csrf_field() }}

                        <div class="form-group">
                            <label for="specialization">Select Specialization</label>
                            <select class="form-control" id="specialization" name="specialization">
                                @foreach($specializations as $specialization)
                                <option value="{{$specialization->id}}">{{$specialization->name}}</option>
                                @endforeach
                            </select>
                        </div>
    					<button type="submit" name="submit" class="btn btn-primary">Add</button>
    				</form>
    			</div>
            @else
                <div class="alert alert-info alert-dismissible fade show w-100" role="alert">
                    <strong>No specializations found!</strong> either you added them all or none are there
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
		</div>
@endsection
