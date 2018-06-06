@foreach($post->replies as $reply)
  <div class="card mt-2" id="reply_body_{{$reply->id}}">
    @include('_auth.discussions.reply')
  </div>
@endforeach
