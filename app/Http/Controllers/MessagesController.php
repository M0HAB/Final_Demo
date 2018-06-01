<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageEvent;
use App\User;
use App\Message;
use Auth;

class MessagesController extends Controller
{

    public function __construct()
    {
      $this->middleware(['auth', 'revalidate']);
    }
    public function filterMessages($messages)
    {
      //init the return array
      $msgreturn= array();
      //loop on received messages to remove the sender/receiver conflicts
      //i.e if latest is from user 1 to user 2 then remove the message from user 2 to user 1
      for ($i=0;$i<count($messages);$i++){
        $skip = false;
        for($j=$i+1;$j<=count($messages)-1;$j++){
          if($messages[$i]->user_id == $messages[$j]->friend_id && $messages[$j]->user_id == $messages[$i]->friend_id){
            $skip = true;
            continue;
          }
        }
        if($skip) continue;
        $messages[$i] = Message::find($messages[$i]->id);
        array_unshift($msgreturn,$messages[$i]);
      }
      return $msgreturn;
    }

    public function index()
    {
      $messages = Auth::user()->msg_list;
      $msgreturn = $this->filterMessages($messages);
      // return $msgreturn;
      return view('_auth.messages.index')->with('messages', $msgreturn);
    }

    public function latestMessages()
    {
      //get last 8 messages for this auth
      $messages = Auth::user()->msg_list;
      $msgreturn = $this->filterMessages($messages);
      if(count($msgreturn)>4){
          $msgreturn = array_slice($msgreturn, 0, 4);
      }
      return $msgreturn;
      //to decode json_decode();

    }

    public function selectMessage($id)
    {
      $friend = User::find($id);
      if ($friend){
        //get latest Message
        $msg = Message::where([
                                ['friend_id', '=', Auth::user()->id],
                                ['user_id', '=', $id]
                              ])->latest()->first();
        //Mark as read if there is message
        if($msg){
          $msg->read = true;
          //save
          $msg->save();
        }
        //get messeages with this friend
        $messages = Auth::user()->messages($id);
        //get channel between user and friend
        $a = Auth::user()->id;
        $b = $id;
        $channel = array($a,$b);
        sort($channel);
        $channel = $channel[0].$channel[1];
        //returns
        if($messages){
          return view('_auth.messages.show')->with('messages', $messages)->with('friend', $friend)->with('channel', $channel);
        }else{
          return "404";
        }
      }else{
        return "404";
      }


    }

    public function allRead()
    {
      Message::where('friend_id', Auth::user()->id)->update(['read' => true]);
      return redirect()->back()->with('success', 'Marked all as read');
    }

    public function readFromUser(Request $request,$id)
    {
      Message::where('friend_id', Auth::user()->id)
             ->where('user_id', $id)
             ->update(['read' => true]);
      return 1;
    }

    public function send(Request $request,$friend_id)
    {
      $body = strip_tags($request->message);
      $message = Message::create([
        'body' => $body,
        'user_id' => Auth::user()->id,
        'friend_id' => $friend_id
      ]);
      broadcast(new MessageEvent($message))->toOthers();
      return $message->toJson();
    }




}
