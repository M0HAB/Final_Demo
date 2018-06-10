<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Reply;
use Auth;
use URL;
use App\File;
class PostController extends Controller
{
      public function loadReplies($id)
      {
        $post = Post::find($id);
        return view('_auth.discussions.load_replies')->with('post', $post);
      }
      private function getImgData($data,$k){
        list($type, $data) = explode(';', $data);
        list(, $data) = explode(',', $data);
        $decode_data = base64_decode($data);
        $size = (strlen($decode_data)/1024);
        if($size > 2048 ){
          return 0;
        }
        $image_name= time().$k.'.png';
        $path = public_path() . '\images\\' . $image_name;
        file_put_contents($path, $decode_data);
        return $image_name;
      }
      private function formulateBody($body){
        $doms = new \domdocument();
        $doms->preserveWhiteSpace = false;
        $body = mb_convert_encoding($body, 'HTML-ENTITIES', "UTF-8");
        $doms->loadHtml('<div>'.$body.'</div>');
        $container = $doms->getElementsByTagName('div')->item(0);
        $container = $container->parentNode->removeChild($container);
        while ($doms->firstChild) {
            $doms->removeChild($doms->firstChild);
        }
        while ($container->firstChild ) {
            $doms->appendChild($container->firstChild);
        }
        //Edit class of <pre> elemtents in sent request
        $pres = $doms->getelementsbytagname('pre');
        foreach ($pres  as $pre) {
          $pre->setattribute('class', 'p-2 rounded bg-primary text-white text-monospace');
        }
        //Edit images since they are sent in base64 encoding.
        $images = $doms->getelementsbytagname('img');
        //to prevent duplicate images from being stored
        $arr = array();
        foreach ($images as $k => $img) {
          $data = $img->getattribute('src');
          if(substr($data, 0, 1) == '/'){
              $data = 'data:image/png;base64,'.base64_encode(file_get_contents(URL::to('/').$data));
          }
          if(!$arr){
            $image_name = $this->getImgData($data,$k);
            if($image_name == 0)return 0;
            $img->removeattribute('src');
            $image_name = '/images/'.$image_name;
            $img->setattribute('src', $image_name);
            array_push($arr,[
              'data' => $data,
              'src' => $image_name
            ]);
          }else{
            $skip = false;
            foreach ($arr as $test) {
              if($data == $test['data']){
                $img->removeattribute('src');
                $image_name = $test['src'];
                $img->setattribute('src', $image_name);
                $skip = true;
                continue;
              }
            }
            if(!$skip){
              $image_name = $this->getImgData($data,$k);
              if($image_name == 0)return 0;
              $img->removeattribute('src');
              $image_name = '/images/'.$image_name;
              $img->setattribute('src', $image_name);
              array_push($arr,[
                'data' => $data,
                'src' => $image_name
              ]);
            }
          }
          $img->setattribute('class', 'img-thumbnail');
          $img->setattribute('href', $image_name);

        }
        $imgs = array();
        foreach($images as $img) {
            $imgs[] = $img;
        }
        foreach($imgs as $img) {
            $img->parentNode->removeChild($img);
        }
        $body = $doms->savehtml();
        $body = html_entity_decode($body);
        $returns = [
          "body" => $body,
          "arr" => $arr
        ];
        return $returns;
      }
      private function filterRecordType(Request $request,$edit)
      {
        switch ($request->type) {
            case "post":
            case "Post":
                if(!$edit){
                    $record = new Post;
                    $record->discussion_id = $request->discussion_id;
                    $record->module_id = $request->module_id;
                }else { $record = Post::find($request->id); }
                $record->title = $request->title;
                break;
            case "reply":
            case "Reply":
                if(!$edit){
                  $record = new Reply;
                  $record->post_id = $request->post_id;
                }else{ $record = Reply::find($request->id); }
                break;
            default:
                return 0;
        }
        return $record;
      }
      //same store function for Post and Reply
      public function store(Request $request)
      {
            if($request->ajax()){
              //filterRecordType takes the request and boolean to indicate if it is edit or new
              $newRecord = $this->filterRecordType($request,false);
              //if the filtering returned a 404 then return error not found
              if ($newRecord === 0) return redirect()->route('error.api', 'Not Found');
              //formulate the message body
              $returns = $this->formulateBody($request->body);
              $body = $returns['body'];
              if ($body === 0) return redirect()->route('error.api', 'Images too big, maximum 2mb per image');
              //save the received body if not empty to the $newRecord->body
              $newRecord->body = $body;
              //set the user id of new record to current auth user
              $newRecord->user_id = Auth::user()->id;
              //if new record failed to save return 404;
              if(!$newRecord->save()) return redirect()->route('error.api', 'Failed to save Try Resubmitting');
              //get array of sources
              $arr = $returns['arr'];
              //loop on each source and store in DB to get later
              foreach ($arr as $img) {
                $photo = new File;
                $photo->relate_type = $request->type;
                $photo->relate_id = $newRecord->id;
                $photo->filename = $img['src'];
                $photo->type = "image";
                $photo->save();
              }
              if($request->type == "reply" || $request->type == "Reply"){
                $reply = Reply::find($newRecord->id);
                return response()->json([
                    'body' => view('_auth.posts.partial_reply_body')->with('reply', $reply)->render()
                ]);
              }
              $post = Post::find($newRecord->id);
              return response()->json([
                  'body' => view('_auth.posts.partial_post_body')->with('post', $post)->render()
              ]);
            }

      }
      public function edit(Request $request)
      {
        if($request->ajax()){
          $record = $this->filterRecordType($request,true);
          $record->photos->delete();
          if($record === 0) return redirect()->route('error.api', 'Not Found');
          $body = $this->formulateBody($request->body);
          //save the received body to the $newRecord->body
          $record->body = $body;
          if(!$record->save()) return redirect()->route('error.api','Failed to save please retry');
          return $record;
        }
      }
      public function delete(Request $request,$id)
      {
        if($request->ajax()){
          $post = Post::find($id);
          if ($post->user_id == Auth::user()->id){
            if($post->delete()){
              return 1;
            }
          }
          return 0;
        }

      }
}
