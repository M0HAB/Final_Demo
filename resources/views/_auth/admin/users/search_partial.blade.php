@foreach($users as $user)
<tr id="user_container_{{$user->id}}">
    <td><a href="{{route('admin.user.profile', ['id'=>$user->id])}}">{{$user->fname.' '.$user->lname}}</a></td>
    <td>{{$user->department->name}}</td>
    <td>{{$user->level}}</td>
    <td>{{$user->email}}</td>
    <td>
        <a href="{{route('admin.user.edit', ['id'=>$user->id])}}"><button class="btn btn-link text-primary p-0" title="Edit">
            <i class="fas fa-edit fa-lg"></i>
        </button></a>
        @if(!$user->trashed())
            <button class="btn btn-link text-primary p-0" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$user->id}}" data-type="user" data-keep="3" title="Delete">
                    <i class="fas fa-trash fa-lg"></i>
            </button>
        @else
            <button class="btn btn-link text-primary p-0" type="submit" data-toggle="modal" data-target="#confirm" data-id="{{$user->id}}" data-type="user" data-keep="2" title="UnDelete">
                    <i class="fas fa-undo fa-lg"></i>
            </button>
        @endif
    </td>
</tr>

@endforeach
