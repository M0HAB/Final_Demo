<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Department;
use App\Http\Controllers\PermissionRoleController;
use App\Pindex;
use Session;
use Validator;
use App\ActionLog;
use Auth;
use App\Course;
use App\Module;
use App\Lesson;
use App\lessonFile;
use App\Quiz;
use App\assignment;
use App\QuizDeliver;//quiz_answer
use App\assdeliver;//ass_deliver
use App\Post;
use App\Comment;
use App\Reply;
use App\Vote;
use App\Specialization;
use App\gradebook;
use App\grade;
use App\Discussion;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate'], ['except' => ['getUsers', 'destroy']]);
    }
    public function index()
    {
        $users = User::getStudents()->withTrashed()->orderBy('level')->orderBy('dep_id')->orderBy('fname')->get();
        $departments = Department::all();
        $roles = Role::all();
        return view('_auth.admin.users.index')->with('users', $users)->with('departments', $departments)->with('roles', $roles);
    }
    public function getUsers(Request $request)
    {
        if($request->name == ""){
            if($request->type == Role::where('name', 'student')->first()->id){
                $users = User::withTrashed()->where('role_id', $request->type)->where('level', $request->level)->where('dep_id', $request->dep)->orderBy('fname')->get();
            }else{
                $users = User::withTrashed()->where('role_id', $request->type)->where('dep_id', $request->dep)->orderBy('fname')->get();
            }
            $users->transform(function ($item, $key) {
                if($item->trashed()){
                    $item['trashed'] = true;
                }
                $item['dep_id'] = $item->department->name;
                return $item;
            });
            return response()->json([
                'body' => view('_auth.admin.users.search_partial')->with('users', $users)->render()
            ]);
        }
        $fname = "NULL";
        $lname = "";
        $name = explode(" ",$request->name);
        if(isset($name[0])){
            $fname = $name[0];
        }
        if(isset($name[1])){
            $lname = $name[1];
        }
        if($request->type == Role::where('name', 'student')->first()->id){
            $results = User::withTrashed()->where('role_id', $request->type)
            ->whereRaw('(fname LIKE "'.$fname.'%" and lname LIKE "'.$lname.'%")')
            ->where('level', $request->level)->where('dep_id', $request->dep)
            ->orderBy('fname')->get();
        }else{
            $results = User::withTrashed()->where('role_id', $request->type)
            ->whereRaw('(fname LIKE "'.$fname.'%" and lname LIKE "'.$lname.'%")')
            ->where('dep_id', $request->dep)->orderBy('fname')->get();
        }
        $results->transform(function ($item, $key) {
            if($item->trashed()){
                $item['trashed'] = true;
            }
            $item['dep_id'] = $item->department->name;
            return $item;
        });

        if($request->ajax()){
          return response()->json([
              'body' => view('_auth.admin.users.search_partial')->with('users', $results)->render()
          ]);
        }
        //incase of non ajax call
        return 1;
    }
    public function profile(Request $request)
    {
        $id = $request->id;
        $user = User::withTrashed()->find($id);
        $pindexes = Pindex::all();
        $PRC = new PermissionRoleController;
        $envelope = $PRC->getAndCombinePermissions($pindexes,$user);
        // dd($envelope);
        if($user){
            return view('_auth.admin.users.profile')->with([
                'user' => $user,
                'envelope' => $envelope,
                'pindexes' => $pindexes
            ]);
        }else{
            return "404";
        }
    }
    public function destroy(Request $request, $id)
    {
        $user = User::withTrashed()->find($id);
        if($user->trashed()){
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'restore',
                'type' => 'user',
                'type_id' => $id,
            ]);
            return ($user->restore())? 1:0;
        }
        if($request->ajax()){
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'delete',
                'type' => 'user',
                'type_id' => $id,
            ]);
          return ($user->delete())? 1:0;
        }else{
          if($user->delete()){
              ActionLog::create([
                  'subject' => 'admin',
                  'subject_id' => Auth::user()->id,
                  'action' => 'delete',
                  'type' => 'user',
                  'type_id' => $id,
              ]);
              return redirect()->back()->with('success', 'User Deleted Successfully');
          }else{
              return redirect()->back()->with('error', 'Some error has occured please try resubmitting');
          }
        }
    }

    public function create()
    {
        $deps = Department::all();
        $roles = Role::all();
        return view('_auth.admin.users.register')->withDeps($deps)->withRoles($roles);
    }

    public function store(Request $request)
    {
        /**
         * Override laravel default validation messages
         * Not the best way to customize validation rules and messages, not clear and reusable.
         * Refactoring..Later
        */
        $rules =  [
            'fname' => 'required|min:3|max:100',
            'lname' => 'required|min:3|max:100',
            'email' => 'required|string|email|max:100|unique:users|confirmed',
            'password' => 'required|confirmed|min:6|max:255',
            'department' => 'required|max:2',
            'gender' => 'required|max:1',
            'role' => 'required|max:1',
            'location' => 'required|max:255'
        ];
        $messages =  [
            'fname.required' => 'First name is required',
            'fname.min' => 'First name must be at least 3 characters.',
            'lname.required' => 'Last name is required',
            'lname.min' => 'Last name must be at least 3 characters.',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'department.required' => 'Department is required',
            'gender.required' => 'Gender is required',
            'role.required' => 'Role is required',
            'location.required' => 'Location field is required'
        ];
        if(Role::where('name', 'student')->first()->id == $request->role){
          $rules['level'] = 'required|max:255';
          $rules['gpa'] = 'required|max:255';
          $messages['level.required'] = 'level is required';
          $messages ['gpa.required'] = 'GPA field is required';
        }
        // Apply validation rules on incoming request
        $validator = Validator::make($request->all(), $rules, $messages);
        // If incoming request is valid
        if ($validator->passes())
        {
            // Generate a unique username
            $request['username'] = $request->fname . '_' . $request->lname . '_' . time();
            // Hash requested password
            $request['password'] = bcrypt($request->password);
            $request['dep_id'] = $request->department;
            $request['role_id'] = $request->role;
            // Generate unique api token
            $request['api_token'] = str_random(50) . time();
            // Create user instance
            $user = User::create($request->all());
            ActionLog::create([
                'subject' => 'admin',
                'subject_id' => Auth::user()->id,
                'action' => 'create',
                'type' => 'user',
                'type_id' => $user->id
            ]);
            // After creating new user return json response with success. message
            return response()->json(['success' => 'User Created Successfully']);
        }
        // If incoming request not valid then return a json response with error bags
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function edit(Request $request)
    {
        $user = User::withTrashed()->find($request->id);
        $deps = Department::all();
        $roles = Role::all();
        $inputs=[
            'fname' => $user->fname, 'lname' => $user->lname,
            'email' => $user->email, 'email_confirmation'=>$user->email,
            'department' => $user->dep_id, 'gender' => $user->gender,
            'role' => $user->role_id, 'location' => $user->location,
            'level' => $user->level, 'gpa' => $user->gpa
        ];
        Session::flashInput($inputs);
        return view('_auth.admin.users.edit')->with([
            'user' => $user,
            'deps' => $deps,
            'roles' => $roles
        ]);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $user = User::withTrashed()->find($id);
        if($user){
            $rules =  [
                'fname' => 'required|min:3|max:100',
                'lname' => 'required|min:3|max:100',
                'email' => 'required|confirmed|email||unique:users,email,'.$id.'|max:100',
                'department' => 'required|max:2',
                'gender' => 'required|max:1',
                'location' => 'required|max:255'
            ];
            $messages =  [
                'fname.required' => 'First name is required',
                'fname.min' => 'First name must be at least 3 characters.',
                'lname.required' => 'Last name is required',
                'lname.min' => 'Last name must be at least 3 characters.',
                'email.required' => 'Email is required',
                'department.required' => 'Department is required',
                'gender.required' => 'Gender is required',
                'location.required' => 'Location field is required'
            ];
            if($user->isStudent()){
              $rules['level'] = 'required|max:255';
              $rules['gpa'] = 'required|max:255';
              $messages['level.required'] = 'level is required';
              $messages ['gpa.required'] = 'GPA field is required';
            }
            // Apply validation rules on incoming request
            $validator = Validator::make($request->all(), $rules, $messages);
            // If incoming request is valid
            if ($validator->passes())
            {
                $request['dep_id'] = $request->department;
                $input = array_except($request->all(), ['_token', 'email_confirmation']);
                $user->update($input);
                // After creating new user return json response with success. message
                return response()->json(['success' => 'User Edited Successfully']);
            }
            // If incoming request not valid then return a json response with error bags
            return response()->json(['error' => $validator->errors()->all()]);

        }else{
            return redirect()->route('error.api', 'Not Found');
        }

    }

    public function previewAction(Request $request)
    {
        $record = null;
        $title = null;
        //TODO::Add role,gradebook,grades
        switch ($request->type) {
            case 'department':
                $record = Department::withTrashed()->find($request->id);
                if(!$record)break;
                $record->department_head = User::find($record->Dep_Head_ID);
                $record->department_head = $record->Dep_Head_ID.' ['.$record->department_head->fname.' '.$record->department_head->lname.']';
                unset($record->Dep_Head_ID);
                $title = "Department";
                break;
            case 'specialization':
                $record = Specialization::withTrashed()->find($request->id);
                if(!$record)break;
                $title = "Specialization";
                break;
            case 'course':
                $record = Course::find($request->id);
                if(!$record)break;
                $record->instructor_data = $record->instructor_id.' ['.$record->instructor->fname.' '.$record->instructor->lname.']';
                unset($record->instructor_id);
                $title = "Course";
                break;
            case 'module':
                $record = Module::find($request->id);
                if(!$record)break;
                $title = "Module";
                break;
            case 'lesson':
                $record = Lesson::find($request->id);
                if(!$record)break;
                $title = "Lesson Video";
                break;
            case 'lessonFile':
                $record = lessonFile::find($request->id);
                if(!$record)break;
                $record->file = '/files/'.$record->path;
                unset($record->path);
                $title = "Lesson File";
                break;
            case 'quiz':
                $record = Quiz::find($request->id);
                if(!$record)break;
                $record->is_active = ($record->is_active)? 'True':'False';
                $title = "Quiz";
                break;
            case 'assignment':
                $record = assignment::find($request->id);
                if(!$record)break;
                $record->file = '/uploads/assignments/'.$record->file;
                $title = "Assignment";
                break;
            case 'quiz_answer':
                $record = QuizDeliver::find($request->id);
                if(!$record)break;
                $title = "Answer of Quiz ".$record->quiz->title." with ID: ".$record->quiz->id;
                break;
            case 'ass_deliver':
                $record = assdeliver::find($request->id);
                if(!$record)break;
                $record->user = $record->user_id.' ['.$record->student->fname.' '.$record->student->lname.']';
                $record->file = '/uploads/assignments/delivered/'.$record->file;
                unset($record->user_id);
                $title = "Assignment ".$record->assignment->title." Deliver";
                break;
            case 'post':
                $record = Post::withTrashed()->find($request->id);
                if(!$record)break;
                $record->user_data = $record->user_id.' ['.$record->user->fname.' '.$record->user->lname.']';
                unset($record->user_id);
                $record->uploads = $record->files()->withTrashed()->get();
                $title = "Post";
                break;
            case 'reply':
                $record = Reply::withTrashed()->find($request->id);
                if(!$record)break;
                $record->user_data = $record->user_id.' ['.$record->user->fname.' '.$record->user->lname.']';
                unset($record->user_id);
                $record->uploads = $record->files()->withTrashed()->get();
                $title = "Reply";
                break;
            case 'comment':
                $record = Comment::find($request->id);
                if(!$record)break;
                $record->user_data = $record->user_id.' ['.$record->user->fname.' '.$record->user->lname.']';
                unset($record->user_id);
                $title = "Comment";
                break;
            case 'gradebook':
                $record = gradeBook::find($request->id);
                if(!$record)break;
                $title = "Grade Book";
                break;
            case 'grades':
                $record = grade::find($request->id);
                if(!$record)break;
                $user = User::find($record->user_id);
                $record->user_data = $record->user_id.' ['.$user->fname.' '.$user->lname.']';
                unset($record->user_id);
                $title = "Grades";
                break;
            case 'role':
                $record = Role::withTrashed()->find($request->id);
                if(!$record)break;
                $title = "Role";
                break;
            case 'discussion':
                $record = Discussion::find($request->id);
                if(!$record)break;
                $title = "Discussion";
                break;
            default:
                return "Unkown Type BRO";
                break;

        }
        if(!$record) return redirect()->route('error.web');
        return view('_auth.admin.users.preview')->with('record', $record)->with('title', $title);
    }

}
