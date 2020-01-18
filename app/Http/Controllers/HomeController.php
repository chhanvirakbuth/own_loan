<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin\App\Theme;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $theme=Theme::findOrFail(1);
        return view('layouts.admin-menu')->with('theme',$theme);
    }
}
