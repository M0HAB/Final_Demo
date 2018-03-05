<?php

namespace App\Http\Controllers\_Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\User;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }
    /**
     * @return ForgotPasswordForm
     */
    public function showForgotForm()
    {
        return view('_auth.user.password.forgot');
    }

    /**
     * @param request
     * @return ResetFormView
     */
    public function checkEmail(Request $request, User $user)
    {
        $user = $user->where('email', '=', $request->email)->get();
        if ($request->email == null)
        {
            Session::flash('warning', 'Enter email to be reset');
            return redirect()->back();
        }
        else 
        {   
            if (count($user) > 0)
            {
                // or using $user[0]->id, $user->first()
                // return redirect()->route('user.reset.form', ['id' => $user->first()]);
                return view('_auth.user.password.reset')->with('user', $user);
            }
        }
        Session::flash('error', 'Email you entered not exist');
        return redirect()->back();
    }
}
