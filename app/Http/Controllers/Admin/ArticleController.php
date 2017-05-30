<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Org\Util\Date;

class ArticleController extends CommonController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$data=Article::paginate(1);
        return view('admin.article.index',['data'=>$data]);
    }

    /**
     * 添加文章
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$category=category::all();
    	$data=(new category())->getTree($category,0,0);
    	return view('admin.article.add')->with('data',$data );
    }

    /**
     * //进行文章数据的存储
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$input=$request->except('_token','fileselect');
    	$input['art_time']=date('Y-m-d H:i:s');
    	$rules=[
    		'art_title'=>'required',
		    'art_content'=>'required'
	    ];
    	$message=[
    		'art_title.required'=>'惠惠提醒您，请填入文章标题',
		    'art_content.required'=>'惠惠提醒您，请填入文章内容'
	    ];
    	$validator=Validator::make($input,$rules,$message);
    	if($validator->passes()){
    		$is_create=Article::create($input);
    		if($is_create){
    			return back()->with('msg','操作成功');
		    }else{
    			return redirect('admins/article/create');
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
     * 修改文章方法
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category=(new category())->all();
        $data=(new category())->getTree($category,0,0);
        $field=Article::find($id);
        return view('admin.article.edit',['data'=>$data,'field'=>$field]);
    }

    /**
     * 进行文章数据修改更新
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input=$request->except('_method','_token','fileselect');
//      dd($input);
	    $re=Article::where('art_id',$id)->update($input);
	    if($re){
	    	back()->with('msg','惠惠提醒您，操作成功啦！');
	        return redirect('admins/article');
	    }else{
	    	return back()->with('msg','惠惠提醒您，数据更新失败了呢！');
	    }
    }

    /**
     * 文章删除操作
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article=Article::where('art_id',$id)->first();
//        dd($article);
        $is_delete=$article->delete();
        if($is_delete){
        	$data=[
        		'status'=>0,
		        'msg'=>'文章删除成功!'
	        ];
        }else{
        	$data=[
        	    'status'=>1,
		        'msg'=>'文章删除失败!'
	        ];
        }
        return $data;
    }


}
