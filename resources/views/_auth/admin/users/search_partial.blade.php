@foreach($users as $user)
<tr id="user_container_{{$user->id}}">
    <td><a href="{{route('admin.user.profile', ['id'=>$user->id])}}">{{$user->fname.' '.$user->lname}}</a></td>
    <td>{{$user->department->name}}</td>
    <td>{{$user->level}}</td>
    <td>{{$user->email}}</td>
    <td>
        <a href="{{route('admin.user.edit', ['id'=>$user->id])}}"><button class="btn btn-success mb-1" title="Edit">
            <i class="fas fa-edit"></i>
        </button></a>
        @if(!$user->trashed())
            <button class="btn btn-danger mb-1" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$user->id}}" data-type="user" data-keep="3" title="Delete">
                    <i class="fas fa-trash"></i>
            </button>
        @else
            <button class="btn btn-info mb-1" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$user->id}}" data-type="user" data-keep="2" title="UnDelete">
                    <i class="fas fa-undo"></i>
            </button>
        @endif
    </td>
</tr>

@endforeach
