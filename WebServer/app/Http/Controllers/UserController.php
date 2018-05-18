<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use Hash;
use Auth;
class UserController extends Controller
{
    public function register()
    {
        if(Auth::check()){
            return view('Project.register');
        }else{
            return redirect('/login');
        }
    }
    public function createuser(Request $request)
    {
        $temp = Users::where('username',$request->username)->first();
        if(!(is_null($temp))){
            return redirect()->back()->with('status', '** มีUsername แล้ว กรุณาใช้Username อื่น **')->withInput();
        }
        if($request->input('password')==''){
           return redirect()->back()->with('status', '**กรุณากรอกpassword ให้ตรงกัน **')->withInput();
        }
        if($request->input('password')!= $request->input('password_confirmation')){
            return redirect()->back()->with('status','**กรุณากรอกpassword ให้ตรงกัน **')->withInput();
        }
        $store = new Users;
        $store->name = $request->input('name');
        $store->username = $request->input('username');
        $store->email = $request->input('email');
        $store->password = Hash::make($request->input('password'));
        $store->PhoneNumber = $request->PhoneNumber;
        $store->type = 'admin';
        $store->save();
        // dd($request);
        return redirect('/member');
    }

    public function login()
    {
       return view('Project.login');
    }
    public function checklogin(Request $request)
    {

        $data = [
            'username' => $request->input('username'),
            'password' => $request->input('password')

        ];
        if(Auth::attempt($data)) {
            return redirect('/dashboard'); 
        }else{
            return redirect('/login')->with('status', '**กรุณาตรวจสอบข้อมูลให้ถูกต้อง**');
        }           	
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function member(){
        if(Auth::check()){
            $listuser = Users::get();
            /*dd($listuser);*/
            return view('Project.member')->with('listuser',$listuser);
        }else{
            return redirect('/login');
        }
        
    }
    public function submitEditProfile(Request $request){
        $users = Users::find($request->id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->PhoneNumber = $request->PhoneNumber;
        $users->save();

        return response()->json($request);
    }
    public function settingPassword(Request $request){
        $Datas=$request->input('passwordold');
        $check = Hash::make($request->input('passwordold'));
        $users = Users::find($request->id);
        if(Hash::check($request->input('passwordold'), $users->password)){
            $users->password = Hash::make($request->input('password'));
            $users->save();
             
        }else{
            alert("รหัสผ่านเก่าไม่ถูกต้อง");
            return false;
        }
 
      
     return response()->json($Datas);
    }

    public function editProfile(Request $request){
        $users = Users::find($request->id);
        $users->name = $request->name;
        $users->email = $request->email;
        $users->PhoneNumber = $request->PhoneNumber;
        $users->save();
        return response()->json($request);
    }
    public function editPasswordUser(Request $request){
        $users = Users::find($request->id);
        $users->password = Hash::make($request->input('password'));
        $users->save();

        return response()->json($request);
    }
    public function deleteuser(Request $request)
    {
        //dd($request);
        $data = Users::find($request->id);
        //dd($data);
        $data->delete();
       
        return redirect()->back();
    }
}
