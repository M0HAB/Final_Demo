<?php

namespace App\Http\Controllers\Admin;


use Auth;
use Session;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $this->middleware(['guest:admin', 'revalidate', 'IsAdmin'], ['except' => ['logout']]);
    }


    public function index()
    {
      return view('_auth.admin.index');
    }

    /**
     * @param request
     * @return admin dashboard
     */
    public function login(Request $request)
    {
        if ($request->email == null || $request->password == null)
        {
            Session::flash('warning', "Email and Password are required");
            return redirect()->back();
        }
        else
        {
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password]))
                return redirect()->route('admin.dashboard');
            else
            {
                Session::flash('error', "The email or password you have entered is invalid");
                return redirect()->back();

            }
        }
    }

    /**
     * Log the user out of the application.
     * Guard admin
     * @return admin.index page
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.index');
    }

}
