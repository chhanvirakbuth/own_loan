<?php

namespace App\Http\Controllers\Admin\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin\App\Theme;

class ThemeController extends Controller
{

    public function __construct(){
      $this->middleware('auth');
    }
    //created theme name to table
    public function setTheme($name){
      Theme::updateOrCreate(['id' => 1],
                ['name' => $name]);
      return json_encode();
    }

}
