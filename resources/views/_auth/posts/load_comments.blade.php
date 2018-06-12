@foreach($comments->sortByDesc('updated_at') as $comment)
@include('_auth.posts.partial_comment_body')
@endforeach
