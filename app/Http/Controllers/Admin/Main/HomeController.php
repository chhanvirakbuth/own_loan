<?php

namespace App\Http\Controllers\Admin\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\App\Theme;

class HomeController extends Controller
{
    //
    public function index(){
      $theme=Theme::findOrFail(1);
      return view('layouts.admin-menu')->with('theme',$theme);
    }
}
