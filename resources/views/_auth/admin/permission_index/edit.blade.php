@extends('_layouts.app')
@section('title', 'Edit Permission Index '.$pindex->name)


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">

			<h1>Edit Permission Index : <strong>{{$pindex->name}}</strong> ({{$pindex->index}})</h1>
			<div class="row justify-content-center">
				<div class="col-lg-10 col-sm-12">
					<br>
					@include('_partials.errors')
                    <form action="{{ route('pindex.update',$pindex->index) }}" method="POST" role="form" autocomplete="off">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
						<div class="form-group">
						  <label for="pindex">Module Name:</label>
						  <input type="text" class="form-control" id="pindex"
                              placeholder="Enter Permission Name" name="pindex"
                              @if (!empty(old('pindex')))
                                value="{{ old('pindex') }}"
                              @else
                                value="{{ $pindex->name }}"
                              @endif
                              >
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Submit</button>
					  </form>

				</div>
			</div>
		</div>
	</div> <!-- End: Content -->
@endsection
