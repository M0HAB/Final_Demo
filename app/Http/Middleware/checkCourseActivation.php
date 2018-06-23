<?php

namespace App\Http\Middleware;

use App\Course;
use Closure;
use Illuminate\Support\Facades\Auth;
use App\Discussion;
use Route;
use App\Post;
use App\Reply;
use App\Comment;

class checkCourseActivation
{
    public function formulateForDiscussions($request)
    {
        $id=0;
        if($request->ajax() && !Route::is('discussion.search.api')){
            if(Route::is('discussion.record.*')){
                if($request->id){
                    if($request->type == 'post'){
                        $id = Post::find($request->id)->discussion->id;
                    }else{
                        $id = Reply::find($request->id)->post->discussion->id;
                    }
                }else{
                    if($request->type == 'post'){
                        $id = $request->discussion_id;
                    }else{
                        $id = Post::find($request->post_id)->discussion->id;
                    }
                }
            }elseif (Route::is('discussion.*.delete')) {
                if(Route::is('discussion.post.delete')){
                    $id = Post::find($request->id)->discussion->id;
                }elseif (Route::is('discussion.reply.delete')) {
                    $id = Reply::find($request->id)->post->discussion->id;
                }else{
                    $id = Comment::find($request->id)->reply->post->discussion->id;
                }
            }elseif (Route::is('discussion.comment.*')){
                if(Route::is('discussion.comment.store')){
                    $id = Reply::find($request->id)->post->discussion->id;
                }else{
                    $id = Comment::find($request->id)->reply->post->discussion->id;
                }
            }else{
                $id = Reply::find($request->id)->post->discussion->id;
            }
        }else{
            $id = $request->id;
        }
        return $id;
    }
    public function handle($request, Closure $next)
    {
        //check if route is discussion and formulate request to suite the middleware
        if (Route::is('discussion.*')) {
            $id = $this->formulateForDiscussions($request);
            $record = Discussion::find($id);
            //get discussion of that id and save it to record we need it as model to get its course relation
            if($record){
                //save course to request to use it
                $request['course'] = $record->course;
                //check if course is not null, will never happen but Worst case scenario precautions
                if(!$record->course){
                    //Discussion has no course
                    return redirect()->route('user.dashboard')->with('error', 'Course Not Found');
                }
            }else{
                //Discussion not found
                return redirect()->route('user.dashboard')->with('error', 'Discussion not found');
            }
        }

        $course = Course::find(request()->course->id);
        if(Auth::User()->isStudent()){
            if(!($course->is_active)){
                return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');            }
        }
        return $next($request);
    }
}
