@extends('_layouts.app')
@section('title', 'Messages')

@section('content')
	<!-- Start: Dashboard -->
	<div class="row">
		<div class="col-lg-12 col-sm-12 mb-4">
				<h1>Messages
					@if(count($messages) >0)
					<a href="{{ route('messages.read')}}">
						<button class="btn btn-primary" href="{{ route('messages.read')}}" data-toggle="tooltip" data-placement="top" title="Create">
							<span class="fas fa-check"></span> Mark all as read
						</button>
					</a>
					@endif
				</h1>

						@if(count($messages) == 0)

						<div class="alert alert-secondary text-center" role="alert">
						  <h4 class="alert-heading">No Messages Found</h4>
						  <p>Don't Worry about that it's not like you dont have any friends or anything </p>
							<p>It is just <strong>YOU</strong> are too cool too awesome too unique for them </p>
							<p>Just kidding you will stay alone forever MWAHAHAHA :"D</p>
						  <hr>
						  <p class="mb-0">Forever Alone 2.0</p>
						</div>

						@endif
            @foreach ($messages as $msg)
						<div class="alert {{ ( !($msg->read) && (Auth::user()->id == $msg->friend_id) )? 'alert-primary':'alert-light'}}" role="alert">
							@if ( Auth::user()->id == $msg->user_id )
                <a href="{{route('messages.show', $msg->friend_id)}}" class="font-weight-bold forum-nav">
                	{{$msg->receiver->fname." ".$msg->receiver->lname}}
                </a>
              @else
                <a href="{{route('messages.show', $msg->user_id)}}" class="font-weight-bold forum-nav">
									{{$msg->sender->fname." ".$msg->sender->lname}}
								</a>
              @endif
								<p class="text-muted pt-1 forum-p">{{$msg->body}}</p>
						</div>
            @endforeach

			</div>
		</div>
@endsection
