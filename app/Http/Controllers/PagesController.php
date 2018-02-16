<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }

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
