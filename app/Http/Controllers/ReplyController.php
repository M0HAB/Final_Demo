<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Vote;
use App\Post;
use Auth;

class ReplyController extends Controller
{
    private $controllerName = "Discussion";
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate', 'checkUserEnrollmentInCourse', 'checkCourseActivation']);
    }

    public function setVote(Request $request)
    {
        if(canCreate($this->controllerName) && canDelete($this->controllerName)){
            $btn;$approve=false;
            $vote = Vote::where([
              'reply_id' => $request->id,
              'user_id' => Auth::user()->id
            ])->first();

            $reply = Reply::find($request->id);

            if (!$vote){
              $vote = Vote::create([
                'reply_id' => $request->id,
                'user_id' => Auth::user()->id
              ]);
              $btn = true;
              if (Auth::user()->isInstructor()){
                $approve = true;
                if ( $reply->approved == 0  ){
                  $reply->approved = 1;
                  $reply->save();
                }


              }
              return response()->json([
                'comments_body' => view('_auth.posts.load_comments')->with('comments', $reply->comments)->render(),
                'btn'=>$btn,
                'reply' => $reply,
                'votes' => count($reply->votes),
                'comments' => count($reply->comments),
                'approve' =>$approve,
                'voters' => $reply->voters()
              ]);

            }
            $vote->delete();
            $btn = false;
            if (Auth::user()->isInstructor()){
              $approve = true;
              if (count($reply->whoApproved()) == 0){
                $reply->approved = 0;
                $reply->save();
              }

            }
            return response()->json([
              'comments_body' => view('_auth.posts.load_comments')->with('comments', $reply->comments)->render(),
              'btn'=>$btn,
              'reply' => $reply,
              'votes' => count($reply->votes),
              'comments' => count($reply->comments),
              'approve' =>$approve,
              'voters' => $reply->voters()
            ]);
        }else{
            return redirect()->route('error.api', 'Unauthorized Operation!');
        }

    }

    public function delete(Request $request)
    {
        if(canDelete($this->controllerName)){
            $reply = Reply::find($request->id);
            if ($reply->user_id == Auth::user()->id){
              $reply->delete();
              $post = Post::find($reply->post_id);
              return view('_auth.discussions.load_replies')->with('post', $post);
            }
            return 0;
        }else{
            return redirect()->route('error.api', 'Unauthorized Operation!');
        }

    }
}
