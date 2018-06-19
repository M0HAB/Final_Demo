@extends('_layouts.app')
@section('title', 'Post - '.$post->title)

@section('stylesheets')
<link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row disscusion" id="app">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-1 col-sm-12">
                <a href="{{route('discussion.show',$post->discussion->id)}}?module_order={{$post->module->module_order}}" class="btn go-back-btn mb-4"><i class="fas fa-arrow-left fa-1x"></i></a>
            </div>
            <div class="col-lg-11 mb-3">
                {{-- Post --}}
                <div class="discussion-container" id="post_container_{{$post->id}}">
                    <div class="row">
                        <div class="col-lg-11">
                            <h3 class="post-title font-weight-bold edit_title">{{$post->title}}</h3>
                        </div>
                        <div class="col-lg-1">
                            @if(Auth::user()->id != $post->user->id || canUpdate('Discussion') || canDelete('Discussion'))
                                <div class="dropdown float-right">
                                    <button type="button" class="btn btn-light browse-btn" data-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v font-weight-bold browse-icon"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right text-left">
                                        @if(Auth::user()->id != $post->user->id)
                                        <a class="dropdown-item" href="{{route('messages.show', $post->user->id)}}">Send Message</a>
                                        @endif
                                        @if(Auth::user()->id == $post->user->id)
                                            @if(canUpdate('Discussion'))
                                                <a class="dropdown-item" href="JavaScript:void(0)"
                                                data-toggle="modal" data-target="#req" data-type="post" data-id="{{$post->id}}" data-mode="edit">
                                                  Edit
                                                </a>
                                            @endif
                                            @if(canDelete('Discussion'))
                                                <a class="dropdown-item" href="JavaScript:void(0)"
                                                data-toggle="modal" data-target="#confirm" data-id="{{$post->id}}" data-type="post" data-redirect="true">
                                                  Delete
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <p class="text-muted">at <strong>{{$post->created_at}} by <span class="text-success">{{$post->user->fname. ' ' . $post->user->lname}}</span></strong></p>
                    <div class="user-content my-4">
                        <div class="discussion-body-content mb-4 edit_post">{{ $post->body }}</div>
                        <div class="edit_image" hidden>@foreach($post->files as $file){{$file->type.';'.$file->filename}},@endforeach</div>
                        <div id="carouselExampleIndicators" class="carousel slide" data-interval="false" data-ride="carousel">
                            <span class="indicators">
                            <ol class="carousel-indicators">
                                {{-- image counter indicator --}}
                                @foreach($post->files()->where('type', 'image')->get() as $k => $photo)
                                <li data-target="#carouselExampleIndicators" data-slide-to="{{$k}}"
                                @if($k==0)
                                class="active"
                                @endif
                                ></li>
                                @endforeach
                            </ol>
                            </span>
                            <div class="carousel-inner">
                                {{-- First image displayed as default --}}
                                @foreach($post->files()->where('type', 'image')->get() as $k => $photo)
                                <div class="carousel-item
                                @if($k == 0)
                                active
                                @endif
                                ">
                                    <a href="{{$photo->filename}}" data-lightbox="test">
                                        <img class="d-block w-100" src="{{$photo->filename}}" alt="slide {{$k}}">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="text-muted list-files post_files" style="max-height:100px;overflow-y: auto">
                      @foreach($post->files as $file)
                      <div class="card float-left ml-2 mb-1" style="width: 5rem;" id="div-1">
                          @if($file->type == "image")
                          <a href="{{$file->filename}}" data-lightbox="{{$post->id}}">
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
                </div>
            </div>
        </div>

        {{-- Replies --}}
        <div class="row reply-form">
            <div class="offset-lg-1 col-lg-11 mb-5">
                @if(canCreate('Discussion'))
                    <div class="row">
                        <div class="col-lg-12">
                            <button id="add-reply-btn" class="btn btn-light btn-block" data-toggle="modal" data-target="#req" data-type="reply" data-id="{{$post->id}}"><i class="fas fa-reply mr-2"></i> Reply</button>
                        </div>
                    </div>
                @endif

            </div>
        </div>
        <div class="row replies">
            <div class="offset-lg-1 col-lg-11" id="reply_container">
                {{-- default Reply --}}
                @foreach($post->replies as $reply)
                @include('_auth.posts.partial_reply_body')
                @endforeach
            </div>
        </div>
    </div>
</div>

@include('_auth.discussions.modal_post')
@include('_partials.modal_confirm')
@include('_auth.discussions.modal_comment')

@endsection
@section('scripts')
<script src="{{asset('js/dropBox.js')}}"></script>
<script src="{{asset('js/axios.min.js')}}"></script>
<script>
  var api_token = "{{ Auth::user()->api_token}}";
</script>
<script src="{{asset('js/discussion.js')}}" charset="utf-8"></script>
<script src="{{asset('js/modal_confirm.js')}}" charset="utf-8"></script>
@endsection
