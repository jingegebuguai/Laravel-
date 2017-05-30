<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;


class LinksController extends CommonController
{
    /**
     * 友情链接主页
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$data=Links::orderBy('link_order','desc')->get();
        return view('admin.links.index',['data'=>$data]);
    }

    /**
     * 友情链接添加
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.links.add');
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
        	'link_name'=>'required',
	        'link_title'=>'required',
	        'link_url'=>'required'
        ];
        $message=[
			'link_name.required'=>'链接名称未填写',
	        'link_title.required'=>'链接标题未填写',
	        'link_url.required'=>'链接url未填写',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
        	$is_add=Links::create($input);
        	if($is_add){
        		return back()->with('msg','链接添加成功');
	        }else{
        		return redirect('admin/links/create');
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
    	$field=Links::find($id);
        return view('admin/links/edit',['field'=>$field]);
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
        $is_update=Links::find($id)->update($input);
	    if($is_update){
			back()->with('msg','链接修改成功！');
			return redirect('admin/links/');
        }else{
	    	return back()->with('msg','链接修改失败！');
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
        $is_delete=Links::where('link_id',$id)->delete();
        if($is_delete){
			$data=[
				'status'=>0,
				'msg'=>'链接删除成功！'
			];
        }else{
        	$data=[
        	    'status'=>1,
		        'msg'=>'链接删除失败！'
	        ];
        }
        return $data;
    }
}
