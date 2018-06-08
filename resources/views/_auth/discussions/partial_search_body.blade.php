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
</div>
