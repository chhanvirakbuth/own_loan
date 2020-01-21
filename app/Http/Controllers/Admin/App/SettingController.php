<?php

namespace App\Http\Controllers\Admin\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Rules\MatchOldPassword;
use App\Admin\App\Theme;
use Session;
use Auth;
use App\User;

class SettingController extends Controller
{
    //
    public function __construct(){
      $this->middleware('auth');
    }
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

    // profile
    public function profile(){
      $theme=Theme::findOrFail(1);
      $user=User::findOrFail(1);
      return view('admin.app.setting.profile')->with('theme',$theme)
      ->with('user',$user);
    }

    public function post(Request $request){
      $this->validate($request,[
        'images'=>'nullable|max:10240',
        'full_name'=>'required|max:50',
        'email'=>'required',
        'old_password'=>['nullable', new MatchOldPassword],
        'new_password'=>'nullable|min:8',
        'confirm_new'=>['same:new_password'],
      ]);
      // dd('yes');
      // exit;
      $user=User::findOrFail(1);
      $user->name=$request->full_name;
      $user->email=$request->email;
      if ($request->hasFile('images')) {
        $user->image=$request->file('images')->store('users');
      }
      if ($request->new_password !=null) {
        $user->password=Hash::make($request->new_password);
      }
      $user->save();
      Session::flash('success','ប្ដូរប្រូហ្វាលបានជោគជ័យ!');
      return redirect()->route('admin.home');
    }
}
