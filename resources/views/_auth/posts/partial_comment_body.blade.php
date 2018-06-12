<div class="card my-3 comment" id="comment_container_{{$comment->id}}">
    <div class="card-header comment-header">
        <span class="username-post">
            <i class="fas fa-reply mr-2"></i>
            {{$comment->user->fname. '' . $comment->user->lname}}
            <span class="ml-2"><small>{{$comment->created_at}}</small></span>
        </span>
        <div class="dropdown float-right">
            <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v font-weight-bold browse-icon"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right text-left">
              @if(Auth::user()->id != $comment->user->id)
              <a class="dropdown-item" href="{{route('messages.show', $comment->user->id)}}">Send Message</a>
              @endif
              @if(Auth::user()->id == $comment->user->id)
              <a class="dropdown-item" href="JavaScript:void(0)"
              data-toggle="modal" data-target="#req" data-type="comment" data-id="{{$comment->id}}" data-mode="edit">
                Edit
              </a>
              <a class="dropdown-item" href="JavaScript:void(0)"
              data-toggle="modal" data-target="#confirm" data-id="{{$comment->id}}" data-type="comment">
                Delete
              </a>
              @endif
            </div>
        </div>
    </div>
    <div class="card-body py-2">
        <div class="card-text edit_body">{{$comment->body}}</div>
    </div>
</div>
