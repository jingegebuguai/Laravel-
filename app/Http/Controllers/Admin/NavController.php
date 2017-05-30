<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Nav;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;


class NavController extends CommonController
{
	/**
	 * 友情链接主页
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data=Nav::orderBy('nav_order','desc')->get();
		return view('admin.nav.index',['data'=>$data]);
	}

	/**
	 * 友情链接添加
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.nav.add');
	}

	/**
	 * 友情链接添加数据存储
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$input=$request->except('_token');
		$rules=[
			'nav_name'=>'required',
		];
		$message=[
			'nav_name.required'=>'导航名称未填写',
		];
		$validator=Validator::make($input,$rules,$message);
		if($validator->passes()){
			$is_add=Nav::create($input);
			if($is_add){
				return back()->with('msg','导航添加成功');
			}else{
				return redirect('admin/nav/create');
			}
		}else{
			return back()->withErrors($validator);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * 链接修改
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$field=Nav::find($id);
		return view('admin/nav/edit',['field'=>$field]);
	}

	/**
	 * 链接修改数据更新
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$input=$request->except('_method','_token');
		$is_update=Nav::find($id)->update($input);
		if($is_update){
			back()->with('msg','导航修改成功！');
			return redirect('admins/nav/'.$id.'/edit');
		}else{
			return back()->with('msg','导航修改失败！');
		}
	}

	/**
	 * 链接删除
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$is_delete=Nav::where('nav_id',$id)->delete();
		if($is_delete){
			$data=[
				'status'=>0,
				'msg'=>'导航删除成功！'
			];
		}else{
			$data=[
				'status'=>1,
				'msg'=>'导航删除失败！'
			];
		}
		return $data;
	}
}
