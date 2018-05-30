<?php

namespace App\Http\Controllers\_Auth;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Department;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }

    /**
     * @return Register Page
     */
    public function showRegisterForm()
    {
        $deps = Department::all();
        return view('_auth.register')->withDeps($deps);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $request
     * @return \App\User
     */
    public function register(Request $request)
    {   
        /** 
         * Override laravel default validation messages
         * Not the best way to customize validation rules and messages, not clear and reusable.
         * Refactoring..Later
        */
        $rules =  [
            'fname' => 'required|min:3|max:100',
            'lname' => 'required|min:3|max:100',
            'email' => 'required|email|unique:users|max:100',            
            'password' => 'required|confirmed|min:6|max:255',
            'department' => 'required|max:2',
            'gender' => 'required|max:1',
            'role' => 'required|string|max:255',
            'location' => 'required|max:255',
            'level' => 'required|max:255',
            'gpa' => 'required|max:255' 
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
            'location.required' => 'Location field is required',
            'level.required' => 'level is required',
            'gpa.required' => 'GPA field is required' 
        ];

        $userRoles = ['admin', 'instructor', 'student'];
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
            // Create user instance
            User::create($request->all());
            // After creating new user return json response with success. message
            return response()->json(['success' => 'User Created Successfully']);
        }
        // If incoming request not valid then return a json response with error bags
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
