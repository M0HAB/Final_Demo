@extends('_Auth.admin.admin_layout.admin')
@section('title', 'Users Messages')

@section('admin_content')


<div class="card">
  	<div class="card-body">
        <h3 class="f-rw">From :
            <a href="{{route('admin.user.profile', ['id' => $message->user->id])}}">
                <strong>{{$message->user->fname.' '.$message->user->lname}}</strong>
            </a>
        </h3>

        <div class="card-header"><strong>Subject :<br/></strong>{{$message->subject}}</div>
        <div class="card-footer"><strong>Message :<br/></strong>{{$message->body}}</div>
    </div>
</div>

@endsection
