<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    // 
    public function create()
    {
	    return view('sessions.create');
    }

    public function store(Request $request)
    {
	    $credentials=$this->validate($request,[
		  'email'    =>'required|email|max:255',
		  'password' =>'required'
	    ]);
            
	    if(Auth::attempt($credentials)){
		    //登录成功后的相关操作
		  session()->flash('success','欢迎回来！');
		  return redirect()->route('users.show',[Auth::user()]);
	    }else{
		    //登录失败后的相关操作
		  session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
		  return redirect()->back()->withInput(); //使用withInput()后,模板里old('email')将能获取到上一次用户提交的内容，这样用户就无需再次输入
	    }

    }
}
