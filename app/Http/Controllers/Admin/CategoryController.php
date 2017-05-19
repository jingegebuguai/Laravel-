<?php

namespace App\Http\Controllers\Admin;

use App\Cate;
use App\Http\Model\Category;
use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    /**
     * 分类主页
     * Display a listing of the resource.
     * Get
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $_category=Category::orderBy('cate_order','asc')->get();
        $user=User::first();
        $data=(new Category())->getTree($_category,0,0);
	    return view('category.index')->with('data',$data)->with('user',$user);
    }

	/**
	 * 主页分类排序
	 * @return array
	 */
    public function order(){
    	$input=Input::all();
//    	echo $input['cate_order'];
	    $cate=Category::find($input['cate_id']);
	    $cate->cate_order=$input['cate_order'];
	    $re=$cate->update();
		if($re){
			$data=[
				'status'=>0,
				'message'=>'惠惠提醒您，更改成功啦！'
			];
		}else{
			$data=[
				'status'=>1,
				'message'=>'惠惠提醒您，好像失败了哦！'
			];
		}
	    return  $data;

    }


    /**
     * 文章分类添加
     * Show the form for creating a new resource.
     * Get
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$_category=Category::all();
    	$data=(new Category())->getTree($_category,0,0);
        //$data=Category::where('cate_pid',0)->get();
    	return view('category.add',['data'=>$data]);
    }

    /**
     * 添加分类操作
     * Store a newly created resource in storage.
     * Post
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
	    //进行表单验证
	    if ($input = Input::except('_token')) {
		    $rules = [
			    'cate_name' => 'required'
		    ];
		    $message = [
			    'cate_name.required' => '分类名称未填写'
		    ];
		    $validator = Validator::make($input, $rules, $message);
		    if ($validator->passes()) {
			    $is_create = Category::create($input);
			    if ($is_create)
				    return back()->with('message', '操作成功');
			    else
				    return redirect('admin/category/create');
		    } else {
			    return back()->withErrors($validator);
		    }
	    }
    }
    /**
     * Display the specified resource.
     * Get
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 修改分类
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
	    $category = Category::all();
	    $data = (new Category())->getTree($category, 0, 0);
	    $field=Category::find($id);
	    return view('category.edit', ['data' => $data])->with('field',$field);
    }

    /**
     * 进行修改分类数据更新操作
     * Update the specified resource in storage.
     * Put
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	$input=Input::except('_token','_method');
	    $category = Category::find($id);
	    $is_update=$category->update($input);//批量更新
	    if($is_update){
		    back()->with('message','惠惠提醒您，操作成功啦！');
	        return redirect('admins/category');
	    }
	    else{
	    	return back()-with('message','惠惠提醒您,操作失败了哦！');
	    }
    }

    /**
     * 删除分类
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::where('cate_id',$id)->first();
        $pid=$category->cate_pid;
        Category::where('cate_pid',$id)->update(['cate_pid'=>$pid]);
	    $is_delete=$category->delete();
        if($is_delete){
        	$data=[
        		'status'=>0,
		        'message'=>'数据删除成功啦！'
	        ];
        	//redirect('admins/category')->with('data',$data);
        }else {
	        $data = [
		        'status' => 1,
		        'message' => '数据删除失败了呢！'
	        ];
        }
	return $data;
    }
}
