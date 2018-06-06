@extends('_layouts.app')
@section('title', 'Discussions - '.$discussion->course->title)

@section('stylesheets')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('content')
<!-- Start: Discussions -->
<div class="row">

  <div class="col-lg-4 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title">
          <span class="fas fa-search"></span> Search for a post
        </h5>
        <div class="form-group">
          <input type="text" class="form-control" id="discussionSearch" placeholder="Search here.." name="discussionSearch">
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
            <li>{{$module->title}}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>

  <div class="col-lg-8 col-sm-12 mb-4">

    <h4 class="mb-4 pl-2">
      {{$discussion->course->title}} Discussion Forum | Module: {{$module_data->title}} [{{$module_data->module_order}}]
      <button type="button" class="btn btn-primary btn-lg float-right" onclick="" data-toggle="modal" data-target="#post" data-id="{{$module->id}}">
        Create Post
      </button>
    </h4>
      @foreach ($module_data->posts as $post)
      <div class="card mb-5">
        <div class="card-body">
          <h4 class="card-title">
            <img src="http://via.placeholder.com/50x50" class="rounded-circle mr-2">
            <a href="#">{{$post->user->fname.' '.$post->user->lname}}</a>
          </h4>
          <h5><a href="#">{{$post->title}}</a></h5>
          <p class="card-text">{{$post->body}}</p>
        </div>
        <div class="card-footer">
          <div id="before-1" class="row">
            <div class="col-md-auto">
              <div class="alert alert-secondary text-center" role="alert">
                <strong>{{count($post->replies)}}</strong> Reply
              </div>
            </div>
            <div class="col">
              <button type="button" class="btn btn-dark btn-lg btn-block" onclick="reply({{$post->id}})">
                Add Reply
              </button>
            </div>
          </div>



          @foreach($post->replies as $reply)
            <div class="card mt-2" id="body_{{$reply->id}}">
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
            </div>



          @endforeach
        </div>
      </div>

        @endforeach


  </div>
  @include('_partials.modal_post')
</div> <!-- End: Discussion -->
@endsection
@section('scripts')
<script src="{{asset('js/quill.min.js')}}"></script>
<script src="{{asset('js/axios.min.js')}}"></script>
<script>
  var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block'],
    ['link', 'image'],
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    [{ 'direction': 'rtl' }],                         // text direction

    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown

    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'align': [] }],

    ['clean']                                         // remove formatting button
  ];


  var quill = new Quill('#message-text', {
      modules: {
        toolbar: toolbarOptions
      },
      theme: 'snow'
  });
  function vote(id){
    axios.post('/api/vote/'+id+'/set',{
      id: id,
      api_token : "{{Auth::user()->api_token}}"
    })
    .then( (response) => {
      $('#body_'+id).html(response.data);
    })
    .catch(function (error) {
      console.log(error);
    });
  }
  $('#post').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var id = button.data('id') // Extract info from data-* attributes
    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
    var modal = $(this)
    console.log(id)
    modal.find('#id').val(id)
    modal.find('#type').val(id)
    modal.find('#recipient-name').val(id)
  })
</script>
@endsection
