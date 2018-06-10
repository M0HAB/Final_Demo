<div id="before-1" class="row">
  <div class="col-md-auto">
    <div class="alert alert-secondary text-center" role="alert">
      <strong>{{count($post->replies)}}</strong> Reply
    </div>
  </div>
  <div class="col">

    <button type="button"
    class="btn btn-dark btn-lg btn-block"
    id="btn_replies_{{$post->id}}"
    data-toggle="modal" data-target="#req" data-type="reply" data-id="{{$post->id}}">
      Add Reply
    </button>

  </div>
</div>



    @foreach($post->replies as $reply)
      <div class="card mt-2" id="reply_container_{{$reply->id}}">
        @include('_auth.discussions.reply')
      </div>
    @endforeach


</div>
