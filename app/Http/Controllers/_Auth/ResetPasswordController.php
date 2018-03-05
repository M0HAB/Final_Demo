<?php

namespace App\Http\Controllers\_Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Session;
use Validator;

class ResetPasswordController extends Controller
{
    public function showResetForm()
    {
        return view('_auth.user.password.reset');
    }

    public function resetPassword(Request $request, $id)
    {
        $rules = ['password' => 'required|min:6'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes())
        {
            $user = User::find($id);
            $user->password = bcrypt($request->password);
            $user->save();
            Session::flash('success', 'Password reset successfully');        
            return redirect()->route('user.forgot.password');
        }
        Session::flash('error', 'Password can be at least 6 chars.');        
        return redirect()->route('user.forgot.password');
    }
}
