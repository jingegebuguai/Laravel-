<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    public function index(){
    	return view('admin.index');
    }
    public function info(){
    	return view('admin.info');
    }

	/**
	 * 推出登陆
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|void
	 */
	public function quit(){
		session(['user'=>null]);
		redirect('admins/login');
	}


	public function pass()
	{
		if ($input = Input::all()) {
			$rules = [
				'password' => 'required|between:6,20|confirmed',
				'password_o' => 'required',
				'password_confirmation' => 'required'
			];
			$messages = [
				'password.required' => '惠惠提醒您,新密码为空哦！',
				'password.between' => '惠惠提醒您,新密码长度不为6~20位哦！',
				'password.confirmed' => '惠惠提醒您,新密码与确认密码密码不相同哦！',
				'password_o.required' => '惠惠提醒您,原密码为空哦!',
				'password_confirmation.required' => '惠惠提醒您,确认密码为空哦！'
			];
			$validator = Validator::make($input, $rules, $messages);
			if ($validator->passes()) {
				$user = User::first();
				if(Crypt::decrypt($user->user_pass)!=$input['password_o']){
					return back()->with('error','惠惠提醒您，原密码错误哦！');
				}else{
					$user->user_pass=Crypt::encrypt($input['password']);
					$user->update();
					back()->with('error','惠惠提醒您，密码修改成功啦！');
					return redirect('admins/pass');
				}
			} else {
//				dd($validator->errors()->all());
				return back()->withErrors($validator);
			}
		} else {
			return view('admin.pass');
		}
	}
}
