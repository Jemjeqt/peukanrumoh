<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the user home page (shop).
     */
    public function index()
    {
        return view('home');
    }
}
