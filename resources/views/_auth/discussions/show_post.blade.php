@extends('_layouts.app')
@section('title', 'Post - '.$post->title)

@section('stylesheets')
<link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection
@section('content')
<!-- Start: Discussions -->
<div class="row">


  <div class="col col-sm-12 mb-4">
    @include('_auth.discussions.post')
  </div>
  @include('_auth.discussions.modal_post')
</div> <!-- End: Discussion -->
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
