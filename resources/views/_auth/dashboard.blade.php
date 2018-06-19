@extends('_layouts.app')
@section('title', Auth::user()->fname)

@section('content')
	<!-- Start: Dashboard -->
	<div class="row">
		<div class="col-lg-8 col-sm-12 mb-4">
			<div class="user-dashboard-diss-forum-prev">
				<h1 class="display-4">Hello, {{ Auth::user()->fname }}</h1>
				<div class="bbp-breadcrumb pb-4">
					<p>
						<a href="#" class="bbp-breadcrumb-home forum-nav">Home</a>
						<span class="bbp-breadcrumb-sep">&rsaquo;</span>
						<span class="bbp-breadcrumb-current">{{ getEndPoint() }}</span>
					</p>
				</div>
				@if(count(Auth::user()->courses) == 0)
					<div class="alert alert-info alert-dismissible fade show w-100" role="alert">
						You are not in any course!
					  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					  </button>
					</div>
				@else
					<table class="table">
						<thead>
							<tr>
								<th>Discussion Forum</th>
								<th>Posts</th>
								<th>Replies</th>
								<th>Recent Post</th>
							</tr>
						</thead>
						<tbody>
							@foreach(Auth::user()->courses as $course)
							<tr>
								<td>
									<a href="{{route('discussion.show', $course->discussion->id)}}" class="font-weight-bold forum-nav">{{$course->title}}</a>
									<p class="text-muted pt-1 forum-p">{{$course->description}}</p>
								</td>
								<td>
									<i class="far fa-comment fa-lg fam-mod"></i> <span class="forum-lbl">{{count($course->discussion->posts)}}</span>
								</td>
								<td>
									@php
										$countReps = 0;
										foreach($course->discussion->posts as $post){
											$countReps += count($post->replies);
										}
									@endphp
									<i class="far fa-comments fa-lg fam-mod"></i> <span class="forum-lbl">{{$countReps}}</span>
								</td>
								<td>

									@if(count($course->discussion->posts)>0)
										<span class="text-muted forum-recent-time">{{$course->discussion->posts()->latest()->first()->created_at->diffForHumans()}}</span>
									@else
										<span class="text-muted forum-recent-time">No Posts Yet</span>
									@endif
								</td>
							</tr>
							@endforeach

						</tbody>
					</table>
				@endif
			</div>
		</div>
		<div class="col-lg-4 col-sm-12">
			<h4 class="mb-4 pl-2">Recent Topics</h4>
			<div class="list-group">
				@php
					$recents;
					$first = true;
					foreach(Auth::user()->courses as $k => $course){
						if(count($course->discussion->posts)>0){
							if($first){
								$first = false;
								$recents = $course->discussion->posts()->latest()->get();
							}else{
								$recents = $recents->merge($course->discussion->posts()->latest()->get());
							}
						}
					}
					$recents = $recents->sortbyDesc('id')->take(5);
				@endphp
				@foreach($recents as $recent)
					<a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
						<div class="d-flex w-100 justify-content-between">
							<h5 class="mb-2">{{$recent->title}}</h5>
							<small class="text-muted txt-lbl">{{$recent->created_at->diffForHumans()}}</small>
						</div>
						<p class="mb-1 recent-p-mod text-truncate">{{$recent->body}}</p>
						<small class="text-muted txt-lbl">Posted by: <span class="font-weight-bold">{{$recent->user->fname.' '.$recent->user->lname}}</span></small>
					</a>
				@endforeach
			</div>
			{{-- <div class="arrow"></div> --}}
		</div>
	</div> <!-- End: Dashboard -->
@endsection
