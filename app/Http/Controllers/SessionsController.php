<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
	$this->middleware('guest',[
             'only'=>['create']
	]);
    }
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
            //$request->has('remember')  //记住我
	    if(Auth::attempt($credentials, $request->has('remember'))){
		  //账号密码正确，判断账号是否通过邮箱激活
		    if(Auth::user()->activated){
			    session()->flash('success','欢迎回来！');
			    $fallback=route('users.show',Auth::user());
		            return redirect()->intended($fallback);
		    }else{
			    Auth::logout();
			    session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
			    return redirect('/');
		    }
	    }else{
		    //登录失败后的相关操作
		  session()->flash('danger','很抱歉，您的邮箱和密码不匹配');
		  return redirect()->back()->withInput(); //使用withInput()后,模板里old('email')将能获取到上一次用户提交的内容，这样用户就无需再次输入
	    }

    }

    public function destroy()
    {
	    Auth::logout();
	    session()->flash('success','您已成功退出！');
	    return redirect('login');
    }
}
