@extends('_layouts.app')
@section('title', 'discussion form')

@section('stylesheets')
<link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        {{--  left-side  --}}
        <div class="col-lg-4 mb-4" style="box-sizing:border-box;">
            <div class="card mb-3 left-side-card">
                <div class="card-header left-side-card-header">
                    <div class="mb-3">
                        <i class="fas fa-search left-side-h-search-icon"></i>
                        <span class="pl-2 left-side-search-title">Search for a post</span>
                    </div>
                    <form action="{{route('discussion.search',$discussion->id)}}" method="GET">
                        <input type="text" class="my-2 form-control" name="q" id="search" placeholder="Search for posts here...">
                    </form>
                </div>
                <div class="card-body left-side-courseinfo-card">
                    <div class="mb-3">
                        <i class="far fa-question-circle left-side-b-question-icon"></i>
                        <span class="pl-2 left-side-courseinfo-title">Course Info.</span>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
                            Name:
                            <span class="badge badge-pill badge-custom">
                              {{ucfirst($discussion->course->title)}}
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
                            Code:
                            <span class="badge badge-pill badge-custom">
                              {{$discussion->course->code}}
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
                            Department:
                            <span class="badge badge-pill badge-custom">
                              {{ucfirst(('App\Department')::find($discussion->course->course_department)->name)}}
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
                                Language:
                                <span class="badge badge-pill badge-custom">
                                  {{ucfirst($discussion->course->course_language)}}
                                </span>
                        </li>
                        <li class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
                            Start Date:
                            <span class="badge badge-pill badge-custom">
                              {{$discussion->course->start_date}}
                            </span>
                        </li>
                        <li class="list-group-item list-group-item-custom d-flex justify-content-between align-items-center">
                            End Date:
                            <span class="badge badge-pill badge-custom">
                              {{$discussion->course->end_date}}
                            </span>
                        </li>
                    </ul>
                  </div>
                  <div class="card-body filter-module-card">
                        <div class="mb-3">
                            <i class="fas fa-filter left-side-filter-icon"></i>
                            <span class="pl-2 left-side-filter-title">Filter By Modules</span>
                        </div>
                        <div class="module-links">
                            <ul class="nav flex-column pl-2">
                              @foreach($discussion->course->modules as $module)
                              <li class="nav-item">
                                  <a href="{{ route('discussion.show', $discussion->id)}}?module_order={{$module->module_order}}" class="btn btn-link float-left">
                                    {{ucfirst($module->title)}}
                                  </a>
                              </li>
                              @endforeach
                            </ul>
                        </div>
                    </div>
              </div>
        </div>

        {{--  Right-side  --}}
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    <ol class="breadcrumb breadcrumb-custom">
                        <li class="breadcrumb-item text-success">{{ucfirst($discussion->course->title)}}</li>
                        <li class="breadcrumb-item text-success">Discussion Fourm</li>
                        <li class="breadcrumb-item active">{{ucfirst($module_data->title)}}</li>
                    </ol>
                </div>
            </div>
            @if(count($module_data->posts) == 0)
            <div class="row">
                <div class="alert alert-dismissible alert-info mx-3" style="width:100%">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <i class="fas fa-info-circle fa-1x mr-2"></i>
                    <strong>No posts are found</strong>, you can create a new post by hitting <strong>Create Post</strong> button
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <button id="create-post" class="btn btn-success mb-3 float-right"
                     data-toggle="modal" data-target="#req" data-type="post">
                      Create Post
                    </button>
                </div>
            </div>
            {{-- Posts --}}
            <div class="row">
                <div class="col-lg-12" id="posts">
                    @foreach($module_data->posts as $post)
                    @include('_auth.posts.partial_post_body')
                    @endforeach
                </div>
                @include('_auth.discussions.modal_post')
                @include('_auth.discussions.modal_confirm')
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/axios.min.js')}}"></script>
<script>
  var api_token     = "{{ Auth::user()->api_token}}",
      module_id     = {{$module_data->id}},
      discussion_id = {{$discussion->id}};
</script>
<script src="{{asset('js/discussion.js')}}" charset="utf-8"></script>
<script src="{{asset('js/modal_confirm.js')}}" charset="utf-8"></script>
@endsection
