<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\User;

class PagesController extends Controller
{
    /**
     * @return Home Page
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @return About Page
     */
    public function about()
    {
        return view('about');
    }

    /**
     * @return Contact_Us Page
     */
    public function contact_us()
    {
        return view('contact_us');
    }

}
