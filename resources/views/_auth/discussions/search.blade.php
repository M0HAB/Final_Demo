
@extends('_layouts.app')
@section('title', 'discussion form')

@section('stylesheets')
<link href="{{asset('css/quill.snow.css')}}" rel="stylesheet">
@endsection
@section('content')
    <div class="row">
        {{--  left-side  --}}
        <div class="col-lg-4 col-sm-12 mb-4" style="box-sizing:border-box;">
            <div class="card mb-3 left-side-card">
                <div class="card-header left-side-card-header">
                    <div class="mb-3">
                        <i class="fas fa-search left-side-h-search-icon"></i>
                        <span class="pl-2 left-side-search-title">Search for a post</span>
                    </div>
                    <input type="text" class="my-2 form-control" name="search" id="search-btn" placeholder="Search for posts here...">
                </div>
            </div>
        </div>

        {{--  Result  --}}
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-12">
                    @if(count($results) == 0)
                    <div class="alert alert-dismissible alert-danger">
                        <strong>Result Not Found!</strong> Please try again
                    </div>
                    @else
                    <div class="alert alert-dismissible alert-success">
                        <strong>Result Found: <span class="badge badge-light badge-pill" style="font-size:14px">{{count($results)}}</span></strong>
                    </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12" id="posts">
                    @foreach($results as $post)
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
  var api_token     = "{{ Auth::user()->api_token}}";
</script>
<script src="{{asset('js/discussion.js')}}" charset="utf-8"></script>
<script src="{{asset('js/modal_confirm.js')}}" charset="utf-8"></script>
@endsection
