<div class="card mb-5 reply-wrapper
@if($reply->approved)
best-solution
@endif
" id="reply_container_{{$reply->id}}">
    <div class="card-header reply-header">
        <span class="username-post">{{$reply->user->fname.' '.$reply->user->lname}}<span></span></span>
        @if(Auth::user()->id != $reply->user->id || canUpdate('Discussion') || canDelete('Discussion'))
            <div class="dropdown float-right">
                <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                    <i class="fas fa-chevron-down font-weight-bold browse-icon"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right text-left">
                  @if(Auth::user()->id != $reply->user->id)
                  <a class="dropdown-item" href="{{route('messages.show', $reply->user->id)}}">Send Message</a>
                  @endif
                  @if(Auth::user()->id == $reply->user->id)
                      @if(canUpdate('Discussion'))
                          <a class="dropdown-item" href="JavaScript:void(0)"
                          data-toggle="modal" data-target="#req" data-type="reply" data-id="{{$reply->id}}" data-mode="edit">
                            Edit
                          </a>
                      @endif
                      @if(canDelete('Discussion'))
                          <a class="dropdown-item" href="JavaScript:void(0)"
                          data-toggle="modal" data-target="#confirm" data-id="{{$reply->id}}" data-type="reply">
                            Delete
                          </a>
                      @endif
                  @endif
                </div>
            </div>
        @endif
        <span class="lb"><small>Created at: {{$reply->created_at}}</small></span>
    </div>
    <div class="card-body pb-1">
          <span class="reply_msg edit_reply">{{$reply->body}}</span>
          <div class="edit_image" hidden>@foreach($reply->files as $file){{$file->type.';'.$file->filename}},@endforeach</div>
        <div class="row">
            @if($reply->approved)
            <div class="col-lg-12 mt-2 mb-3">
                <p class="lbl best-solution-show-lbl"><strong><span class="badge badge-success badge-pill"><i class="fas fa-check mr-1"></i>  BEST SOLUTION</span></strong></p>
            </div>
            @else
            <div class="col-lg-12 mt-2 mb-3">
                <p class="lbl best-solution-hide-lbl"><strong><span class="badge badge-success badge-pill"><i class="fas fa-check mr-1"></i>  BEST SOLUTION</span></strong></p>
            </div>
            @endif
            <div class="col-lg-12 mb-1 pb-3 btn-wrapper" >
                @if(canCreate('Discussion') && canDelete('Discussion'))
                    @if(Auth::user()->isInstructor())
                    <a href="JavaScript:void(0)" class="btn approve
                      @if(Auth::user()->voted($reply))
                      btn-success active
                      @else
                      btn-light
                      @endif
                    mr-2" onclick="vote({{$reply->id}})">
                      <i class="fas fa-check mr-1"></i> Approve</a>
                    @else
                    <a href="JavaScript:void(0)" class="btn vote
                    @if(Auth::user()->voted($reply))
                    btn-primary active
                    @else
                    btn-light
                    @endif
                    mr-2" onclick="vote({{$reply->id}})">
                      <i class="fas fa-thumbs-up mr-1"></i> Vote
                    </a>
                    @endif
                @endif
                @if(canCreate('Discussion'))
                    <a href="JavaScript:void(0)" class="btn btn-light mr-2"
                    data-toggle="modal" data-target="#req" data-id="{{$reply->id}}" data-type="comment">
                      <i class="fas fa-comment-alt mr-1"></i> Comment
                    </a>
                @endif
                <span class="float-right interactive-likes-comments">
                    @php
                    $title = '';
                    $lastkey = count($reply->votes) - 1;
                    foreach($reply->votes as $indx => $vote){
                      if($indx == $lastkey){
                        $title .= $vote->user->fname.' '.$vote->user->lname;
                      }else{
                        $title .= $vote->user->fname.' '.$vote->user->lname.'&#013;&#010;';
                      }
                    }
                    @endphp
                    <a href="" class="btn-link text-primary coll-btn rm-td mr-2 vote_link"  data-html="true" title="{!! $title !!}">
                        <span class="badge badge-dark badge-pill mr-1 votes">{{count($reply->votes)}}</span> Vote
                    </a>
                    <a class="btn-link text-primary coll-btn rm-td comment_link" data-toggle="collapse" href="#reply-{{$reply->id}}" role="button" aria-expanded="false" aria-controls="reply-{{$reply->id}}">
                        <span class="badge badge-dark badge-pill comments">{{count($reply->comments)}}</span> Comments
                    </a>
                </span>
            </div>
            <div class="text-muted list-files w-100 reply_files ml-2" style="max-height:90px;overflow-y: auto;background: none;">
              @foreach($reply->files as $file)
              <div class="card float-left ml-2 mb-1" style="width: 5rem;background: none;" id="div-1">
                  @if($file->type == "image")
                  <a href="{{$file->filename}}" data-lightbox="reply_{{$reply->id}}">
                    <img class="card-img-top" width="70px" height="70px" src="{{$file->filename}}" title="{{(explode("/",$file->filename)[2])}}">
                  </a>
                  @else
                  <a href="{{$file->filename}}">
                    <img class="card-img-top" width="70px" height="70px" src="/images/file.png" title="{{(explode("/",$file->filename)[2])}}">
                  </a>
                  @endif
              </div>
              @endforeach
            </div>
            {{-- Comments --}}
            <div class="col-lg-12">
                <div class="collapse comments-block" id="reply-{{$reply->id}}">
                    @foreach($reply->comments()->latest()->get() as $comment)
                    @include('_auth.posts.partial_comment_body')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
