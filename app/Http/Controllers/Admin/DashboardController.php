<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AdminMessage;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:admin', 'revalidate']);
    }

    public function index()
    {
      return view('_auth.admin.dashboard');
    }

    public function profile()
    {

    }

    public function readMessages()
    {
        $messages = AdminMessage::all();
        return view('_auth.admin.users.messages')->with('messages', $messages);
    }
    public function showMessage($id)
    {
        $message = AdminMessage::find($id);
        return view('_auth.admin.users.message_show')->with('message', $message);
    }
}
