@extends('_layouts.app')
@section('title', 'Messages')

@section('content')
	<div class="row">
		<div class="offset-lg-2 col-lg-8 col-sm-12 mb-4">
					@if(count($messages) >0)
					<h1 class="display-5 mb-3 f-rw">Messages
						<a href="{{ route('messages.read')}}" class="btn btn-primary mb-2">
							<span class="fas fa-check mr-2"></span> Mark all as read
						</a>	
					</h1>			
							
					@endif

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
