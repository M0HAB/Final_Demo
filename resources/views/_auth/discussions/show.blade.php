@extends('_layouts.app')
@section('title', 'Discussions - '.$discussion->course->title)

@section('stylesheets')
<link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- Start: Discussions -->
<div class="row">

  <div class="col-lg-4 col-sm-12">
    <div class="card" id="left_bar">
      <div class="card-header">
        <h5 class="card-title">
          <span class="fas fa-search"></span> Search for a post
        </h5>
        <div class="form-group">
          <div class="dropdown" id="search_containers">

            <input type="text" class="form-control" id="discussionSearch" placeholder="Search here.." name="discussionSearch"  aria-expanded="false">
            <div class="dropdown-menu w-100" id="data" aria-labelledby="discussionSearch">

            </div>
          </div>
        </div>
      </div>
      <div class="card-body">
        <h5>Course Info</h5>
        <p>Name: <strong>{{$discussion->course->title}}</strong></p>
        <p>Code: <strong>{{$discussion->course->code}}</strong></p>
        <p>Department:
          <strong>
            <a href="{{ route('department.show', $discussion->course->course_department)}}">
              {{('App\Department')::find($discussion->course->course_department)->name}}
            </a>
          </strong>
        </p>
        <p>Language: <strong>{{$discussion->course->course_language}}</strong></p>
        <p>Start Date: <strong>{{$discussion->course->start_date}}</strong></p>
      </div>
      <div class="card-footer">
        <h5>Filter by Modules</h5>
        <ul>

          @foreach($discussion->course->modules as $module)
            <li>
              <a href="{{ route('discussion.show', $discussion->id)}}?module_order={{$module->module_order}}">
                {{$module->title}}
              </a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8 col-sm-12 mb-4">

    <h4 class="mb-4 pl-2">
      {{$discussion->course->title}} Discussion Forum | Module: {{$module_data->title}} [{{$module_data->module_order}}]
      <button type="button" class="btn btn-primary btn-lg float-right" onclick="" data-toggle="modal" data-target="#req" data-type="Post">
        Create Post
      </button>
    </h4>
    <div id="posts">
      @foreach ($module_data->posts as $post)
        @include('_auth.discussions.post')
        @endforeach
    </div>

  </div>
  @include('_auth.discussions.modal_post')
</div> <!-- End: Discussion -->
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
@endsection
