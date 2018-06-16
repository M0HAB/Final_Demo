@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Users List')


@section('admin_content')
<div class="card">
  	<div class="card-body">
	  	<h3 class="pb-2 f-rw " >Users List</h3>
        <input type="text" class="my-2 form-control" name="search" id="search" placeholder="Search for Users here...">
        <div style="overflow-y:auto;max-height:400px">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th>Email</th>

                    </tr>
                </thead>
                <tbody id="users_body">
                    @foreach($users as $user)
                    <tr>
                        <td>{{$user->fname.' '.$user->lname}}</td>
                        <td>{{$user->department->name}}</td>
                        <td>{{$user->level}}</td>
                        <td>{{$user->email}}</td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>


  	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    var api_token     = "{{ Auth::user()->api_token}}";
</script>
<script src="{{asset('js/axios.min.js')}}"></script>
<script src="{{asset('js/user.js')}}" charset="utf-8"></script>
@endsection
