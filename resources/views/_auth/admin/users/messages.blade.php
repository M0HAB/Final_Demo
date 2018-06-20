@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Users Messages')

@section('admin_content')


<div class="card">
  	<div class="card-body">
        @if(count($messages) == 0)
        <div class="jumbotron text-center" style="background-color:#fff;">
                <i class="far fa-frown mb-2" style="font-size:80px;color:#24A899"></i>
                <h3 class="mb-4" style="font-family:raleway;font-weight:500;font-size:30px">No Messages Found</h3>
                <p class="p-msg-error">Don't Worry about that it's not like you dont have any friends or anything </p>
                <p class="p-msg-error">It is just <strong>YOU</strong> are too cool too awesome too unique for them </p>
                <p class="mb-4 p-msg-error">Just kidding you will stay alone forever MWAHAHAHA</p>
                <hr>
            <p class="mb-0 p-msg-error">Forever Alone 2.0</p>
        </div>

        @endif
        @foreach ($messages as $msg)
            <div class="alert alert-light" role="alert">
                <a href="{{route('admin.messages.show', $msg->id)}}" class="font-weight-bold forum-nav">
                    {{$msg->user->fname." ".$msg->user->lname}}
                </a>
                at <strong>{{$msg->created_at}}</strong>
                <p class="text-muted pt-1 forum-p text-truncate"><strong>Subject : </strong>{{$msg->subject}}</p>
                <p class="text-muted pt-1 forum-p text-truncate"><strong>Message : </strong>{{$msg->body}}</p>
            </div>
        @endforeach
    </div>
</div>

@endsection
