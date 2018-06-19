<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\AdminMessage;
class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'revalidate']);
    }

    public function dashboard()
    {
        return view('_auth.dashboard');
    }

    public function profile()
    {
        return view('_auth.user.profile');
    }

    public function contactAdminForm()
    {
        return view('_auth.user.contact_admin');
    }

    public function contactAdmin(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|min:10|max:100',
            'message' => 'required|min:150',
        ]);
        AdminMessage::create([
            'user_id' => Auth::user()->id,
            'subject' => $request->subject,
            'body' => $request->message
        ]);
        return redirect()->back()->with('success', 'Message Sent successfully');

    }
}
