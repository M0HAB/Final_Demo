@extends('_layouts.app')
@section('title', 'Edit Specialization '.$specialization->name)


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
			<div class="row justify-content-center">
				<div class="col-lg-10 col-sm-12">
					@include('_partials.errors')
					<h3 class="f-rw">Edit Specialization : <strong>{{$specialization->name}}</strong></h3>
                    <form action="{{ route('specialization.update',$specialization->id) }}" method="POST" role="form" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
						<div class="form-group">
						  <label for="specialization">Specialization Name:</label>
						  <input type="text" class="form-control" id="specialization"
                              placeholder="Enter Specialization Name" name="specialization"
                              @if (!empty(old('specialization')))
                                value="{{ old('specialization') }}"
                              @else
                                value="{{ $specialization->name }}"
                              @endif
                              >
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Submit</button>
					  </form>

				</div>
			</div>
	</div> <!-- End: Content -->
@endsection
