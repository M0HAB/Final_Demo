<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
