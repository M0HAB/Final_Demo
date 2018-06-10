<div class="card mb-5" id="post_container_{{$post->id}}">
<div class="card-body">
  <h4 class="card-title">
    <img src="/images/50x50.png" class="rounded-circle mr-2">
    <a href="#">{{$post->user->fname.' '.$post->user->lname}}</a>
      @if(Auth::user()->id == $post->user_id )
      <a href="JavaScript:Void(0);" class="text-dark float-right" title="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fas fa-ellipsis-h"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right mt-0" aria-labelledby="optionMenu">
        <button class="dropdown-item"
        data-toggle="modal" data-target="#req" data-type="post" data-id="{{$post->id}}" data-mode="edit"
        type="button">Edit</button>
        <button class="dropdown-item" data-toggle="modal" data-target="#confirm" data-id="{{$post->id}}" data-type="post" type="button">Delete</button>
      </div>
      @endif
  </h4>
  <h5><a href="#" class="edit_title">{{$post->title}}</a></h5>
  <div class="card-text edit_body">{!! $post->body !!}</div>
</div>
<div class="card-footer" id="post_footer_{{$post->id}}">
  <div id="before-1" class="row">
    <div class="col-md-auto">
      <div class="alert alert-secondary text-center" role="alert">
        <strong>{{count($post->replies)}}</strong> Reply
      </div>
    </div>
    <div class="col">
      @if(count($post->replies) > 0)
      <button type="button" class="btn btn-primary btn-lg btn-block" id="btn_replies_{{$post->id}}"  onclick="view_replies({{$post->id}})">
        View Replies
      </button>
      @else
      <button type="button"
      class="btn btn-dark btn-lg btn-block"
      id="btn_replies_{{$post->id}}"
      data-toggle="modal" data-target="#req" data-type="reply" data-id="{{$post->id}}">
        Add Reply
      </button>
      @endif

    </div>
  </div>



</div>
</div>
