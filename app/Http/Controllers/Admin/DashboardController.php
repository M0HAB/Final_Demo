<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
}
