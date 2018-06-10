<div class="card my-3 comment">
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
                <a class="dropdown-item" href="#">Send Message</a>
                <a class="dropdown-item" href="#">Edit</a>
                <a class="dropdown-item" href="#">Delete</a>
            </div>
        </div>
    </div>
    <div class="card-body py-2">
        <p class="card-text">{{$comment->body}}</p>
    </div>
</div>
