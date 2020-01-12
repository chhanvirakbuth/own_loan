<?php

namespace App\Http\Controllers\Admin\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin\App\Theme;
use Session;
use Auth;
class SettingController extends Controller
{
    //
    public function index(){
      $theme=Theme::findOrFail(1);

      return view('admin.app.setting.index')->with('theme',$theme);
    }

    public function update(Request $request, $id){
      $this->validate($request,[
        'brand'=>'required|max:20',
        'logo'=>'nullable|max:10240'
      ]);
      $user=Auth::user();
      $theme=Theme::findOrFail($id);
      $theme->brand=$request->brand;
      if ($request->hasFile('logo')) {
        $theme->logo=$request->file('logo')->store('app');
      }
      $theme->created_by=$user->id;
      $theme->save();
      Session::flash('success','ការកំណត់បានជោគជ័យ..');
      return redirect()->route('admin.home');
    }
}
