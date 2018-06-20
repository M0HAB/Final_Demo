<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Reply;
use Auth;
use URL;
use App\FileUp;

class PostController extends Controller
{
    private $controllerName = "Discussion";
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate', 'checkUserEnrollmentInCourse']);
    }
      private function getImgData($data,$k){
        list(, $data['src']) = explode(',', $data['src']);
        $decode_data = base64_decode($data['src']);
        $size = (strlen($decode_data)/1024);
        if($size > 2048 ){
          return 0;
        }
        $image_name= time().$k.'.'.$data['ext'];
        $path = public_path() . '\files\\' . $image_name;
        file_put_contents($path, $decode_data);
        $image_name = '/files/'.$image_name;
        return $image_name;

      }
      private function saveFiles($files){
        foreach ($files as $k => $file) {
          if(substr($file['src'], 0, 1) == '/'){
            $files[$k]['skip']=true;
            continue;
          }
          $files[$k]['src'] = $this->getImgData($file,$k);
          if($files[$k]['src']===0)return 0;
        }
        return $files;
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
                }else { $record = Post::find($request->id);}
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
          if(canCreate($this->controllerName)){
              if($request->ajax()){
                //filterRecordType takes the request and boolean to indicate if it is edit or new
                $newRecord = $this->filterRecordType($request,false);
                //if the filtering returned a 404 then return error not found
                if ($newRecord === 0) return redirect()->route('error.api', 'Not Found');
                $body = $request->body;
                //save the received body if not empty to the $newRecord->body
                $newRecord->body = $body;
                //set the user id of new record to current auth user
                $newRecord->user_id = Auth::user()->id;
                //if new record failed to save return 404;
                if(!$newRecord->save()) return redirect()->route('error.api', 'Failed to save Try Resubmitting');
                //get array of sources
                $files = $this->saveFiles($request->file_list);
                if ($files === 0) return redirect()->route('error.api', 'File too big, maximum 2mb per File');
                //loop on each source and store in DB to get later
                foreach ($files as $file) {
                  $file_rec = new FileUp;
                  $file_rec->relate_type = $request->type;
                  $file_rec->relate_id = $newRecord->id;
                  $file_rec->filename = $file['src'];
                  $file_rec->type = $file['type'];
                  $file_rec->save();
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
          }else{
              return redirect()->route('error.api', 'Unauthorized Operation!');
          }


      }
      public function edit(Request $request)
      {
          if(canUpdate($this->controllerName)){
              if($request->ajax()){
                $record = $this->filterRecordType($request,true);
                if($record === 0) return redirect()->route('error.api', 'Not Found');
                $body = $request->body;
                //save the received body to the $newRecord->body
                $record->body = $request->body;
                if(!$record->save()) return redirect()->route('error.api','Failed to save please retry');
                //get array of sources
                $files = $this->saveFiles($request->file_list);
                if ($files === 0) return redirect()->route('error.api', 'File too big, maximum 2mb per File');
                foreach ($request->delete_list as $file) {
                  FileUp::where('filename', $file['src'])->first()->delete();
                }
                //loop on each source and store in DB to get later
                foreach ($files as $file) {
                  if(isset($file['skip'])){
                    continue;
                  }
                  $file_rec = new FileUp;
                  $file_rec->relate_type = $request->type;
                  $file_rec->relate_id = $record->id;
                  $file_rec->filename = $file['src'];
                  $file_rec->type = $file['type'];
                  $file_rec->save();
                }
                return response()->json([
                  "record" => $record,
                  "srcs" =>$record->files
                ]);
              }
          }else{
              return redirect()->route('error.api', 'Unauthorized Operation!');
          }

      }
      public function delete(Request $request,$id)
      {
          if(canDelete($this->controllerName)){
              if($request->ajax()){
                $post = Post::find($id);
                if ($post->user_id == Auth::user()->id){
                  if($post->delete()){
                    return 1;
                  }
                }
                return 0;
              }
          }else{
              return redirect()->route('error.api', 'Unauthorized Operation!');
          }


      }
}
