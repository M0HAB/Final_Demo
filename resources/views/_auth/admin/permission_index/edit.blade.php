@extends('_layouts.app')
@section('title', 'Edit Permission '.$permission->name)


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
            
			<h1>Edit Permission : <strong>{{$permission->name}}</strong> ({{$permission->index}})</h1>
			<div class="row justify-content-center">		
				<div class="col-lg-10 col-sm-12">					
					<br>
					@include('_partials.errors')					
                    <form action="{{ route('permission.update',$permission->index) }}" method="POST" role="form" autocomplete="off">                        
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
						<div class="form-group">
						  <label for="permission">Module Name:</label>
						  <input type="text" class="form-control" id="permission" 
                              placeholder="Enter Permission Name" name="permission" 
                              @if (!empty(old('permission')))
                                value="{{ old('permission') }}"
                              @else
                                value="{{ $permission->name }}"
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