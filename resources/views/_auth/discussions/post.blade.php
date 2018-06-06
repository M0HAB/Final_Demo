<div class="card mb-5" id="post_body_{{$post->id}}">
<div class="card-body">
  <h4 class="card-title">
    <img src="/images/50x50.png" class="rounded-circle mr-2">
    <a href="#">{{$post->user->fname.' '.$post->user->lname}}</a>
  </h4>
  <h5><a href="#">{{$post->title}}</a></h5>
  <p class="card-text">{!! $post->body !!}</p>
</div>
<div class="card-footer">
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
      data-toggle="modal" data-target="#req" data-type="Reply" data-id="{{$post->id}}">
        Add Reply
      </button>
      @endif

    </div>
  </div>


  <div id="replies_{{$post->id}}">

  </div>

</div>
</div>
