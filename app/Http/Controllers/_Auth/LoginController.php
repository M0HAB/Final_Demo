<?php

namespace App\Http\Controllers\_Auth;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    public function __construct()
    {
        $this->middleware(['guest'], ['except' => ['logout']]);
    }

    // public function showLoginForm()
    // {
    //     return view('index');
    // }

    /**
     * @param request
     * @return user dashboard 
     */
    public function login(Request $request)
    {
        if ($request->email == null || $request->password == null)
        {
            return redirect()->back()->with(Session::flash('warning', "Email and Password are required"));
        }
        else
        {
            $this->validate($request, [
                'email' => 'required|email|max:100',            
                'password' => 'required|max:255',         
            ]);
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            {
                return redirect()->route('user.dashboard');
            }
            else
            {
                return redirect()->back()->with(Session::flash('error', "The email or password you have entered is invalid"));
            }
        }
    }

    /**
     * Log the user out of the application.
     * Guard Default
     */
    public function logout()
    {
        if (Auth::check())
        {
            Auth::logout();
            return redirect()->route('index');
        }
    }
}
