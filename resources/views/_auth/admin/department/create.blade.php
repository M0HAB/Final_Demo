@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Create Department')


@section('admin_content')
<div class="card">
  	<div class="card-body">
	  	<h3 class="pb-2 f-rw ">Create new department</h3>
        @include('_partials.errors')
        <form action="{{ route('department.store') }}" method="POST" role="form" autocomplete="off">
            {{ csrf_field() }}
            <div class="form-group">
            <label for="department">Department Name:</label>
            <input type="text" class="form-control" id="department"
                placeholder="Enter Department Name" name="department" value="{{ old('department', '') }}">
            </div>
            @if (count($users) > 0)
            <div class="form-group">
                    <label for="instructor">Instructor:</label>
                    <select class="form-control" id="instructor" name="instructor">
                        <option value="null">Please Choose an Instructor</option>
                        @foreach ($users as $user)
                            <option value="{{$user->id}}" {{ old('instructor') == $user->id ?'selected':'' }}>
                                {{$user->fname.' '.$user->lname}}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <p>No Instructors Available</p>
            @endif
            <button type="submit" name="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
  	</div>
</div>
@endsection
