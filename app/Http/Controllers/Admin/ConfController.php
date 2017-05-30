<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Conf;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;


class ConfController extends CommonController
{
	/**
	 * 配置主页
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data=Conf::orderBy('conf_order','desc')->get();
		foreach($data as $key=>$value){
			switch ($value->field_type){
				case 'input':
					$data[$key]->html='<input type="text" name="conf_content[]" class="lg" value="'.$data[$key]->conf_content.'" >';

					break;
				case 'textarea':
					$data[$key]->html='<textarea class="lg" name="conf_content[]">'.$data[$key]->conf_content.'</textarea>';
					break;
				case 'radio':
					$array=explode(',',$value->field_value);//1:开启，0：关闭
					foreach($array as $_key=>$_value){
						$_array=explode('|',$_value);
						if($_array[0]==$value->conf_content){
							$data[$key]->html.='<input type="radio" name="conf_content[]" value="'.$_array[0].'" checked="checked">'.$_array[1].'　';
						}else{
							$data[$key]->html.='<input type="radio" name="conf_content[]" value="'.$_array[0].'">'.$_array[1].'　';
						}
					}
					break;
			}
		}
		return view('admin.conf.index',['data'=>$data]);
	}

	/**
	 * 配置添加
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.conf.add');
	}

	/**
	 * 添加数据存储
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$input=$request->except('_token');
		$rules=[
			'conf_name'=>'required',
		];
		$message=[
			'conf_name.required'=>'配置名称未填写',
		];
		$validator=Validator::make($input,$rules,$message);
		if($validator->passes()){
			$is_add=conf::create($input);
			if($is_add){
				return back()->with('msg','配置添加成功');
			}else{
				return redirect('admin/conf/create');
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
	 * 配置修改
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$field=conf::find($id);
		return view('admin/conf/edit',['field'=>$field]);
	}

	/**
	 * 配置修改数据更新
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$input=$request->except('_method','_token');
		$is_update=Conf::find($id)->update($input);
		if($is_update){
			back()->with('msg','导航修改成功！');
			return redirect('admins/conf/'.$id.'/edit');
		}else{
			return back()->with('msg','导航修改失败！');
		}
	}

	/**
	 * 配置删除
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$is_delete=Conf::where('conf_id',$id)->delete();
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
	public function modify(Request $request)
	{
		$input=$request->except('_token');
		foreach($input['conf_id'] as $key=>$value){
			$is_update[]=Conf::where('conf_id',$value)->update(['conf_content'=>$input['conf_content'][$key]]);
		}
		return back()->with('msg','修改配置内容成功!');
	}
}
