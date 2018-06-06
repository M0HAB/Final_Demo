  <div class="card-body
  @if ($reply->approved)
  bg-success text-white
  @endif
  ">
    <h4 class="card-title">
      <img src="http://via.placeholder.com/50x50" class="rounded-circle mr-2">
      <a href="#"
      @if ($reply->approved)
      class="text-white"
      @endif
      >{{$reply->user->fname.' '.$reply->user->lname}}</a>
    </h4>
  </div>
  <div class="card-body">
    <p class="card-text">
      {{$reply->body}}
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
    <button type="button" id="reply_{{$reply->id}}" class="btn btn-info btn-lg rounded-0 mr-3" title="Upvote" onclick="vote({{$reply->id}})">
      <li class="fas fa-arrow-up"></li>
    </button>
    <button type="button" class="btn btn-success btn-lg rounded-0"  id="approve_{{$reply->id}}" title="Approve"
      @if(!Auth::user()->isInstructor())
        disabled
      @else
      onclick="vote({{$reply->id}})"
      @endif
    >
      <span class="fas fa-check"></span>
      </span>
    </button>
  </div>
