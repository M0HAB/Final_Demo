<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reply;
use App\Vote;
use Auth;

class ReplyController extends Controller
{
  
  public function setVote(Request $request)
  {
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
      if (Auth::user()->isInstructor()){
        if ( $reply->approved == 0  ){
          $reply->approved = 1;
          $reply->save();
        }


      }
      return view('_auth.discussions.reply')->with('reply', $reply);
    }

    ($vote->delete())? ($set = 1): ($set = 0);
    if (Auth::user()->isInstructor()){
      if (count($reply->whoApproved()) == 0){
        $reply->approved = 0;
        $reply->save();
      }

    }
    return view('_auth.discussions.reply')->with('reply', $reply);


  }
}
