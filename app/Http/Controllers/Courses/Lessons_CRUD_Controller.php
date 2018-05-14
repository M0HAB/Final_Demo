<?php

namespace App\Http\Controllers\Courses;

use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;



class Lessons_CRUD_Controller extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }

    public function displayLessonsOfModules($course_id, $module_id){
        $course = Course::find($course_id);
        $module = Module::find($module_id);
        $lessons = DB::table('lessons')
            ->leftjoin('modules', 'modules.id', '=', 'lessons.module_id')
            ->select('lessons.*')
            ->where('lessons.module_id', '=', $module_id)
            ->get();
        if(Auth::User()->checkIfUserEnrolled($course) or Auth::User()->checkIfUserTeachCourse($course)) {
            return view('Courses.LessonsOfModule', ['course' => $course, 'module' => $module, 'lessons' => $lessons]);
        }else{
            return redirect()->back();
        }

    }

    public function loadLessons($course_id, $module_id){

        $course = Course::find($course_id);
        $module = Module::find($module_id);

        $lessons = DB::table('lessons')
            ->leftjoin('modules', 'modules.id', '=', 'lessons.module_id')
            ->select('lessons.*')
            ->where('lessons.module_id', '=', $module_id)
            ->get();
        return response()->json([
            'data' => $lessons,
            'course' => $course,
            'module' => $module
        ]);
    }

    public function getNewVideoForm($course_id, $module_id){
        $course = Course::find($course_id);
        if(Auth::User()->checkIfUserEnrolled($course) or Auth::User()->checkIfUserTeachCourse($course)) {
            return view('Courses.newVideoForm');
        }else{
            return redirect()->back();
        }
    }

    public function uploadVideo(Request $request, $course_id, $module_id){

        ini_set('memory_limit','256M');
        $privacyValues = ['unlisted', 'public'];
        ini_set('max_execution_time', 1500);


        $this->validate($request, [
            'title'       => 'required|string|max:255|unique:lessons',
            'description' => 'required|string|max:255',
            'recap'       => 'required|string|max:255',
            'privacy' => ['required', Rule::in($privacyValues)],
        ]);


        $file = $request->file('myVideo');
        $fileName = storage_path('app/public/videos/' . $file->getClientOriginalName());
        $destination = storage_path('app/public/videos');
        if($file->move($destination, $fileName)){
            $fullPathToVideo = $fileName;
            $video = \Dawson\Youtube\Facades\Youtube::upload($fullPathToVideo, [
                'title'       => $request->title,
                'description' => $request->description,
                'category_id' => 10
            ], $request->privacy);

            $video_id = $video->getVideoId();

            if($video){
                $lesson = Lesson::create([
                    'title'       => $request->title,
                    'description' => $request->description,
                    'recap'       => $request->recap,
                    'privacy'     => $request->privacy,
                    'url'         => 'https://www.youtube.com/watch?v=' . $video_id,
                    'module_id'   => $module_id
                ]);

                if($lesson){
                    unlink($fileName);
                    return redirect()->back()->with('def-success', 'Video uploaded successfully');
                }

            }
        }


    }
}