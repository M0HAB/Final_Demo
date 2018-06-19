<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Reply;
use Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate', 'checkUserEnrollmentInCourse']);
    }
    public function store(Request $request)
    {
      if($request->ajax()){
        $comment = new Comment;
        $comment->body = $request->body;
        $comment->reply_id = $request->id;
        $comment->user_id = Auth::user()->id;
        $comment->save();
        $reply = Reply::find($request->id);
        $comments = $reply->comments()->latest()->get();
        return response()->json([
          'comments_body' => view('_auth.posts.load_comments')->with('comments', $comments)->render(),
          'votes' => count($reply->votes),
          'comments' => count($comments),
          'voters' => $reply->voters()
        ]);
      }
    }
    public function edit(Request $request)
    {
      if($request->ajax()){
        $comment = Comment::find($request->id);
        $comment->body = $request->body;
        $comment->save();
        return response()->json([
          'body' => $comment->body,
        ]);
      }
    }
    public function delete(Request $request,$id)
    {
      if($request->ajax()){
        $comment = Comment::find($id);
        if ($comment->user_id == Auth::user()->id){
          if($comment->delete()){
            return 1;
          }
        }
        return 0;
      }

    }
}
