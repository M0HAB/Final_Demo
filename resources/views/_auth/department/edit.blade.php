@extends('_layouts.app')
@section('title', 'Edit Department '.$department->name)


@section('content')
<!-- Start: Content -->
	<div class="content mt-5 mb-4">
		<div class="container">
            
			<h1>Edit Department : <strong>{{$department->name}}</strong></h1>
			<div class="row justify-content-center">		
				<div class="col-lg-10 col-sm-12">					
					<br>
					@include('_partials.errors')					
                    <form action="{{ route('department.update',$department->id) }}" method="POST" role="form" autocomplete="off">                        
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
						<div class="form-group">
						  <label for="department">Department Name:</label>
						  <input type="text" class="form-control" id="department" 
                              placeholder="Enter Department Name" name="department" 
                              @if (!empty(old('department')))
                                value="{{ old('department') }}"
                              @else
                                value="{{ $department->name }}"
                              @endif
                              >
						</div>
						@if (count($users) > 0)
						<div class="form-group">
								<label for="instructor">Instructor:</label>
								<select class="form-control" id="instructor" name="instructor">
									<option value="null">Please Choose an Instructor</option>
                                    @foreach ($users as $user)
                                        @if (!empty(old('instructor')))
                                            <option value="{{$user->id}}" {{ old('instructor') == $user->id ?'selected':'' }}>
                                                {{$user->fname.' '.$user->lname}}
                                            </option>
                                        @else
                                            <option value="{{$user->id}}" {{ $department->Dep_Head_ID == $user->id ?'selected':'' }}>
                                                {{$user->fname.' '.$user->lname}}
                                            </option>
                                        @endif
										
									@endforeach
								</select>
							</div>
						@else
							No Instructors Available
						@endif
						<button type="submit" name="submit" class="btn btn-primary">Submit</button>
					  </form>

				</div>
			</div>
		</div>
	</div> <!-- End: Content -->
@endsection