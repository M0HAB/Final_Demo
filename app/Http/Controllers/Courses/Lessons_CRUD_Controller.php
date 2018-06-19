<?php

namespace App\Http\Controllers\Courses;

use App\Course;
use App\Http\Controllers\Controller;
use App\Lesson;
use App\lessonFile;
use App\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Lessons_CRUD_Controller extends Controller
{
    private $controllerName = "Course";

    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }

    public function displayLessonsOfModules(Course $course, Module $module){
        if(canRead($this->controllerName)){
            $assignments = $module->assignments()->get();

            if(Auth::User()->isStudent()){
                $quizzes = DB::table('quizzes')
                    ->leftjoin('modules', 'modules.id', '=', 'quizzes.module_id')
                    ->select('quizzes.*')
                    ->where('quizzes.module_id', '=', $module->id)
                    ->where('quizzes.is_active', '=', 1)
                    ->get();
            }elseif(Auth::User()->isInstructor()){
                $quizzes = DB::table('quizzes')
                    ->leftjoin('modules', 'modules.id', '=', 'quizzes.module_id')
                    ->select('quizzes.*')
                    ->where('quizzes.module_id', '=', $module->id)
                    ->get();
            }

            $lessons = DB::table('lessons')
                ->leftjoin('modules', 'modules.id', '=', 'lessons.module_id')
                ->select('lessons.*')
                ->where('lessons.module_id', '=', $module->id)
                ->get();

            $files = DB::table('lesson_files')
                ->leftjoin('modules', 'modules.id', '=', 'lesson_files.module_id')
                ->select('lesson_files.*')
                ->where('lesson_files.module_id', '=', $module->id)
                ->get();

            return view('Courses.LessonsOfModule', ['course' => $course, 'module' => $module, 'lessons' => $lessons, 'assignments' => $assignments, 'quizzes' => $quizzes, 'files' => $files]);
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }


    }

    public function loadLessons(Course $course,Module $module){
        if(canRead($this->controllerName)){
            $lessons = DB::table('lessons')
                ->leftjoin('modules', 'modules.id', '=', 'lessons.module_id')
                ->select('lessons.*')
                ->where('lessons.module_id', '=', $module->id)
                ->get();
            return response()->json([
                'data' => $lessons,
                'course' => $course,
                'module' => $module
            ]);
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }


    }

    public function getNewVideoForm(Course $course,Module $module){
        if(canCreate($this->controllerName)){
            return view('Courses.newVideoForm', compact('module'));
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }
    }

    public function uploadVideo(Request $request, Course $course, Module $module){
        if(canCreate($this->controllerName)){
            if(!file_exists(public_path().'/videos')){
                mkdir(public_path().'/videos', 0700);
            }

            ini_set('memory_limit','256M');
            $privacyValues = ['unlisted', 'public'];
            ini_set('max_execution_time', 1500);


            $this->validate($request, [
                'title'       => 'required|string|max:255|unique:lessons',
                'description' => 'required|string|max:255',
                'recap'       => 'required|string|max:255',
                'privacy' => ['required', Rule::in($privacyValues)],
            ]);


            if ($request->hasFile('myVideo')) {
                $file= $request->file('myVideo');
                $filename = $file->getClientOriginalName();
                $destination = public_path() . '\videos';
                $temp = storage_path('app\public\video') . '\\' . $filename;
                $file->move($destination, $temp);
            } else {
                Session::flash('error', 'Please select a video to be upload');
                return redirect()->back();
            }


            if(file_exists(public_path() . '\videos\\' . $filename)){
                $fullPathToVideo = public_path() . '\videos\\' . $filename;
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
                        'module_id'   => $module->id
                    ]);

                    if($lesson){
                        unlink($fullPathToVideo);
                        Session::flash('success', "Video uploaded successfully!");
                        return redirect()->back();
                    }
                }
            }
        }else{
            Session::flash('error', "Unauthorized Operation!");
        }

    }




    public function getNewFileForm(Course $course,Module $module){

        if(canCreate($this->controllerName)){
            return view('Courses.newFileForm', compact('course', 'module'));
        }else{
            return redirect()->route('user.dashboard')->with('error', 'Unauthorized Access');
        }

    }

    public function uploadFile(Request $request, Course $course, Module $module){
        if(canCreate($this->controllerName)){
            $validator = Validator::make($request->all(), [
                'title'           => 'required|max:255',
                'description'     => 'required|max:255',
                'lesson_file'     => 'required|max:10000',

            ]);
            if (!($validator->passes())) {
                return response($validator->errors(), 401);
            }

            $file = $request->file('lesson_file');
            $fileName = storage_path('app/public/files/' . $file->getClientOriginalName());
            $destination = storage_path('app/public/files');
            if($file->move($destination, $fileName)){
                $file = lessonFile::create([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'path' => $fileName,
                    'module_id' => $module->id
                ]);
                if($file){
                    Session::flash('success', "File uploaded successfully!");
                    return redirect()->back();
                }
            }
        }else{
            Session::flash('error', "Unauthorized Operation!");
        }


    }



}
