@extends('_layouts.app')
@section('title', 'Post - '.$post->title)

@section('stylesheets')
<link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="row disscusion">
    <div class="col-lg-8">
        <div class="row">
            <div class="col-lg-1 col-sm-12">
                <a href="{{route('discussion.show',$post->discussion->id)}}?module_order={{$post->module->module_order}}" class="btn go-back-btn mb-4"><i class="fas fa-arrow-left fa-1x"></i></a>
            </div>
            <div class="col-lg-11 mb-3">
                {{-- Post --}}
                <div class="discussion-container">
                    <div class="row">
                        <div class="col-lg-11">
                            <h3 class="post-title font-weight-bold">{{$post->title}}</h3>
                        </div>
                        <div class="col-lg-1">
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
                    </div>

                    <p class="text-muted">at <strong>{{$post->created_at}} by <span class="text-success">{{$post->user->fname. ' ' . $post->user->lname}}</span></strong></p>
                    <div class="user-content my-4">
                        <p class="discussion-body-content mb-4">
                            {!! $post->body !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Replies --}}
        <div class="row reply-form">
            <div class="offset-lg-1 col-lg-11 mb-5">
                <div class="row">
                    <div class="col-lg-12">
                        <button id="add-reply-btn" class="btn btn-light btn-block" data-toggle="modal" data-target="#req" data-type="reply" data-id="{{$post->id}}"><i class="fas fa-reply mr-2"></i> Reply</button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row replies">
            <div class="offset-lg-1 col-lg-11" id="reply_container">
                {{-- default Reply --}}
                @foreach($post->replies as $reply)
                <span id="reply_body_{{$reply->id}}">
                @include('_auth.posts.partial_reply_body')
                </span>
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
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/axios.min.js')}}"></script>
<script>
  var api_token     = "{{ Auth::user()->api_token}}",
      module_id     = {{$post->module_id}},
      discussion_id = {{$post->discussion_id}};
</script>
<script src="{{asset('js/discussion.js')}}" charset="utf-8"></script>
@endsection
