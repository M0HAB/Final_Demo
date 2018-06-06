<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
use App\Vote;
use App\Reply;
use Auth;
class DiscussionController extends Controller
{
    protected $controllerName = "Discussion";

    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }
    public function index()
    {
      // return view('_auth.department.show')->with('departments', $departments);
      // return view('_auth.discussions.index');
      return "yo";
    }
    public function show($id,$module_order)
    {
      $discussion = Discussion::find($id);
      $module_data = $discussion->course->modules->where('module_order', $module_order)->first();
      // return $module->posts;
      return view('_auth.discussions.show')->with('discussion', $discussion)->with('module_data', $module_data);
    }
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
