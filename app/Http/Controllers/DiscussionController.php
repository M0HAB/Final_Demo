<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discussion;
use Auth;
class DiscussionController extends Controller
{
    private $controllerName = "Discussion";

    public function __construct()
    {
        $this->middleware(['auth', 'revalidate', 'checkUserEnrollmentInCourse']);
    }
    public function index()
    {
      // return view('_auth.department.show')->with('departments', $departments);
      // return view('_auth.discussions.index');
     // return "yo";
    }
    public function show($id)
    {
        if(canRead($this->controllerName)){
            if(isset($_GET['post'])){
              $post = Discussion::find($id)->posts()->where('id', $_GET['post'])->first();
              if(!$post){
                return redirect()->route('error.web');
              }
              return view('_auth.posts.show_post')->with('post', $post);
            }
            if(isset($_GET['module_order']))
            {
              $module_order = $_GET['module_order'];
            }else{
              $module_order = 1;
            }
            $discussion = Discussion::find($id);
            if(!$discussion){
              return redirect()->route('error.web');
            }
            $module_data = $discussion->course->modules->where('module_order', $module_order)->first();
            if ($module_data){
              return view('_auth.posts.index')->with('discussion', $discussion)->with('module_data', $module_data);
            }else{
                return redirect()->route('user.dashboard')->with('error', 'This Course has no modules');
            }
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access!');
        }

    }
    public function searchPosts(Request $request, $id)
    {
        if(canRead($this->controllerName)){
            $results = Discussion::find($id)
            ->posts()
            ->whereRaw('(body LIKE "%'.$request->q.'%" or title LIKE "%'.$request->q.'%")')
            ->latest()->get();
            if($request->ajax()){
              return response()->json([
                  'body' => view('_auth.discussions.partial_search_body')->with('results', $results)->with('discussion_id', $id)->render()
              ]);
            }
            return view('_auth.discussions.search')->with('results', $results)->with('discussion_id', $id);
        }else{
            if($request->ajax()) return 0;
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access!');
        }

    }


}
