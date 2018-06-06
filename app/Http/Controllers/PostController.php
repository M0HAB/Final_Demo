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
      public static function getImgData($data,$k){
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

      public function store(Request $request)
      {

            switch ($request->type) {
                case "post":
                case "Post":
                    $newRecord = new Post;
                    $newRecord->discussion_id = $request->discussion_id;
                    $newRecord->module_id = $request->module_id;
                    $newRecord->title = $request->title;
                    break;
                case "reply":
                case "Reply":
                    $newRecord = new Reply;
                    $newRecord->post_id = $request->post_id;
                    break;
                default:
                    return "404";
            }


            $details = $request->body;
            $doms = new \domdocument();
            $doms->loadHtml($details, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
            $details = $doms->savehtml();

            $newRecord->body = $details;
            $newRecord->user_id = Auth::user()->id;
            $newRecord->save();
            if($request->type == "reply" || $request->type == "Reply"){
              $post = Post::find($newRecord->post_id);
              return view('_auth.discussions.load_replies')->with('post', $post);
            }
            $post = Post::find($newRecord->id);
            return view('_auth.discussions.post')->with('post', $post);
      }
}
