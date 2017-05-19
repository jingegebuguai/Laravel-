<?php

namespace App\Http\Controllers\Service;


use App\Http\Controllers\Controller;
use App\Tool\ValidateCode;
use Illuminate\Http\Request;

class ValidateController extends Controller
{
	public function create(Request $request)
	{
		$validateCode = new ValidateCode();
		//将验证码存入session中，以便登陆判断,因为在生成时就存入session中，所以
		$request->session()->put('validate_code', $validateCode->getCode());
		//生成验证码
		return $validateCode->doimg();
	}

}

