@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Users List')


@section('admin_content')

<div class="card">
  	<div class="card-body">

        <form class="form-inline">
            <h3 class="pb-2 mr-3 f-rw " >Users List</h3>
            <h3>
            <div class="form-group mr-3 pb-2">
                <select class="form-control form-control-sm" id="type">
                    @foreach($roles as $role)
                    <option value="{{$role->id}}" {{($role->id == 2)? 'selected':''}}>{{ucfirst($role->name)}}</option>
                    @endforeach
                </select>
            </div>
            </h3>
            <h3>
            <div class="form-group mr-3 pb-2">
                <select class="form-control form-control-sm" id="dep">
                    @foreach($departments as $department)
                        <option>{{$department->name}}</option>
                    @endforeach
                </select>
            </div>
            </h3>
            <h3>
            <div class="form-group mr-3 pb-2" id="levelGrp">
                <select class="form-control form-control-sm" id="level">
                    <option>Select level..</option>
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            </h3>
        </form>

        <input type="text" class="my-2 form-control" name="search" id="search" placeholder="Search for Users here...">
        <div style="overflow-y:auto;max-height:400px">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th id="level_table">Level</th>
                        <th>Email</th>
                        <th>Actions</th>

                    </tr>
                </thead>
                <tbody id="users_body">
                    @foreach($users as $user)
                    <tr id="user_container_{{$user->id}}">
                        <td><a href="{{route('admin.user.profile', ['id'=>$user->id])}}">{{$user->fname.' '.$user->lname}}</a></td>
                        <td>{{$user->department->name}}</td>
                        <td>{{$user->level}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                            <button class="btn btn-success" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            @if(!$user->trashed())
                                <button class="btn btn-danger" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$user->id}}" data-type="user" data-keep="3" title="Delete">
                                        <span class="fas fa-trash"></span>
                                </button>
                            @else
                                <button class="btn btn-info" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$user->id}}" data-type="user" data-keep="2" title="UnDelete">
                                        <span class="fas fa-undo"></span>
                                </button>
                            @endif
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>


  	</div>
</div>
@include('_partials.modal_confirm')
@endsection
@section('scripts')
<script type="text/javascript">
    var api_token    = "{{ Auth::user()->api_token}}",
        profileRoute = "{{route('admin.user.profile')}}";
</script>
<script src="{{asset('js/axios.min.js')}}"></script>
<script src="{{asset('js/user.js')}}" charset="utf-8"></script>
<script src="{{asset('js/modal_confirm.js')}}" charset="utf-8"></script>
@endsection
