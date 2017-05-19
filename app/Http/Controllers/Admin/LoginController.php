<?php

namespace App\Http\Controllers\Admin;



use App\Http\Model\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

class LoginController extends CommonController
{
	/**
	 * 进行登陆操作
	 * @param Request $request
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
    public function login(Request $request){
    	if($input=Input::all()){
		    $user=User::first();
		    if($input['user_name']!=$user->user_name||$input['user_pass']!=Crypt::decrypt($user->user_pass)){
			    return back()->with('msg','用户名或密码错误');
		    }
    		$validate_session=$request->session()->get('validate_code', '');
    		if(strtolower($input['code'])!=strtolower($validate_session)){
    			return back()->with('msg','验证码错误');
		    }
		    session(['user'=>$user]);
			return redirect('admins/index');
//    		dd(session('user'));
//		    echo 'ok';
	    }else {
//	        dd($_SERVER);
//		    session(['user'=>null]);
		    return view('admin.login');
	    }
    }



	/**
	 * laravel加密
	 */
    public function crypt(){
    	$str='huihui';
    	$pass=Crypt::encrypt($str);
    	echo $pass;
    }

}
