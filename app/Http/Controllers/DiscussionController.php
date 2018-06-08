<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
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
    public function show($id)
    {
      if(isset($_GET['post'])){
        $post = Discussion::find($id)->posts()->where('id', $_GET['post'])->first();
        return view('_auth.discussions.show_post')->with('post', $post);
      }
      if(isset($_GET['module_order']))
      {
        $module_order = $_GET['module_order'];
      }else{
        $module_order = 1;
      }
      $discussion = Discussion::find($id);
      if(!$discussion){
        return "404";
      }
      $module_data = $discussion->course->modules->where('module_order', $module_order)->first();
      if ($module_data){
        return view('_auth.posts.index')->with('discussion', $discussion)->with('module_data', $module_data);
      }else{
        return redirect()->back()->with('error', 'Module Not Found');
      }
    }
    public function searchPosts(Request $request, $id)
    {
        $arabicTest = mb_convert_encoding($request->q, 'HTML-ENTITIES', "UTF-8");
        $results = Discussion::find($id)
        ->posts()
        ->whereRaw('body LIKE "%'.$request->q.'%" or title LIKE "%'.$request->q.'%"')
        ->orWhereRaw('body LIKE "%'.$arabicTest.'%" or title LIKE "%'.$arabicTest.'%"')
        ->latest()->get();
        return view('_auth.discussions.search')->with('results', $results);
    }


}
