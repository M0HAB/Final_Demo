<?php

namespace App\Http\Controllers\_Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


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
        $this->middleware('auth');
    }

    /**
     * @return Register Page
     */
    public function showRegisterForm()
    {
        return view('_auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $request
     * @return array validated $request
     */
    public function validation($request)
    {
        return $this->validate($request, [
            'fname' => 'required|max:100',
            'lname' => 'required|max:100',
            'email' => 'required|email|unique:users|max:100',            
            'password' => 'required|confirmed|max:255',
            'department' => 'required|max:255',
            'gender' => 'required|max:1',
            'role' => 'required|max:255',
            'location' => 'required|max:255',
            'level' => 'required|max:255',
            'gpa' => 'required|max:255',  
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $request
     * @return \App\User
     */
    public function register(Request $request)
    {
        $this->validation($request);
        $request['password'] = bcrypt($request->password);
        User::create($request->all());
        return redirect()->back()->with('status', 'User created successfully');
    }
}
