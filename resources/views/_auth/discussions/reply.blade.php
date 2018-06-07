<div id="reply_container_{{$reply->id}}">
  <div class="card-body
  @if ($reply->approved)
  bg-success text-white
  @endif
  ">
    <h4 class="card-title">
      <img src="/images/50x50.png" class="rounded-circle mr-2">
      <a href="#"
      @if ($reply->approved)
      class="text-white"
      @endif
      >{{$reply->user->fname.' '.$reply->user->lname}}</a>
      <a href="JavaScript:Void(0);" class="
      @if($reply->approved)
      text-white
      @else
      text-dark
      @endif
      float-right" title="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fas fa-ellipsis-h"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-right mt-0" aria-labelledby="optionMenu">
        <button class="dropdown-item" type="button">Edit</button>
        <button class="dropdown-item" data-toggle="modal" data-target="#confirm" data-type="reply" data-id="{{$reply->id}}" data-post="{{$reply->post->id}}" type="button">Delete</button>
      </div>
    </h4>
  </div>
  <div class="card-body">
    <p class="card-text">
      {!! $reply->body !!}
    </p>
  </div>
  <div class="card-footer">
    <p>
      <a href="#"
      title="
      @foreach ($reply->votes as $voter)
      {{$voter->user->fname}}
      @endforeach
      "
      ><strong>{{count($reply->votes)}}</strong> Upvote</a>
      <span class="text-secondary">|</span>
      <a href="#"
      title="
      @foreach ($reply->whoApproved() as $approver)
      {{$approver->fname}}
      @endforeach
      "
      ><strong>{{ count( $reply->whoApproved() ) }}</strong> Approve</a>
    </p>
  </div>
  <div class="card-footer">
    <button type="button" id="reply_{{$reply->id}}" class="btn btn-info btn-lg rounded-0 mr-3" title="Upvote" onclick="vote({{$reply->id}},{{$reply->post->id}})">
      @if(Auth::user()->voted($reply))
      <li class="fas fa-arrow-down"></li>
      @else
      <li class="fas fa-arrow-up"></li>
      @endif
    </button>
    <button type="button" class="btn btn-success btn-lg rounded-0"  id="approve_{{$reply->id}}" title="Approve"
      @if(!Auth::user()->isInstructor())
        disabled>
        <span class="fas fa-check"></span>
      @else
      onclick="vote({{$reply->id}},{{$reply->post->id}})">
        @if(Auth::user()->voted($reply))
        <span class="fas fa-times"></span>
        @else
        <span class="fas fa-check"></span>
        @endif
      @endif
    </button>
  </div>
</div>
