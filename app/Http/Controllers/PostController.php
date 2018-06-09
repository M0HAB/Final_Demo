<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Reply;
use Auth;

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
        if($size > 1024 ){
          return 0;
        }
        $image_name= time().$k.'.png';
        $path = public_path() . '\images\\' . $image_name;
        file_put_contents($path, $decode_data);
        return $image_name;
      }
      private function formulateBody($body){
        $doms = new \domdocument();
        $body = mb_convert_encoding($body, 'HTML-ENTITIES', "UTF-8");
        $doms->loadHtml($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
        $body = $doms->savehtml();
        return $body;
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
                return "404";
        }
        return $record;
      }
      //same store function for Post and Reply
      public function store(Request $request)
      {
            if($request->ajax()){
              //filterRecordType takes the request and boolean to indicate if it is edit or new
              $newRecord = $this->filterRecordType($request,false);
              if ($newRecord === "404") return "404";
              $body = $this->formulateBody($request->body);
              if($body === 0) return $body;
              $newRecord->body = $body;
              $newRecord->user_id = Auth::user()->id;
              if(!$newRecord->save()) return "404";
              if($request->type == "reply" || $request->type == "Reply"){
                $post = Post::find($newRecord->post_id);
                return response()->json([
                    'body' => view('_auth.discussions.load_replies')->with('post', $post)->render()
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
          if($record === "404") return "404";
          $body = $this->formulateBody($request->body);
          if($body === 0) return $body;
          $record->body = $body;
          if(!$record->save()) return "404";
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
