@extends('Layout.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admins/info')}}">首页</a> &raquo; 文章分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果页快捷搜索框 开始-->
	<div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <input  type="hidden" name="_method" value="delete">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admins/category/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                    <a href="{{url('admins/category')}}"><i class="fa fa-refresh"></i>更新排序</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>

                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th class="tc">分类名称</th>
                        <th class="tc">标题</th>
                        <th class="tc">发布人</th>
                        <th class="tc">更新时间</th>
                        <th class="tc">查看次数</th>
                        <th class="tc">操作</th>
                    </tr>
                    @foreach($data as $_data)
                    <tr>

                        <td class="tc">
                            <input  type="text" onchange="orderChange(this,'{{$_data->cate_id}}')" value="{{$_data->cate_order}}">
                        </td>
                        <td class="tc">
                            <p>{{$_data->cate_id}}</p>
                        </td>
                        <td >
                            <a href="#"><?php echo str_repeat('-',8*$_data['level'])?>{{$_data->cate_name}}</a>
                        </td>
                        <td >
                            {{$_data->cate_title}}

                        </td>
                        <td class="tc">{{$user->user_name}}</td>
                        <td class="tc"><?php echo date('Y-m-d H:i:s') ?></td>
                        <td class="tc">{{$_data->cate_view}}</td>
                        <td class="tc">
                            <a  href="{{url('admins/category/'.$_data->cate_id.'/edit')}}">修改</a>
                            <a  href="javascript:;" onclick="deleteCategory({{$_data->cate_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>


<div class="page_nav">
<div>
<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a> 
<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a> 
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>
<span class="current">8</span>
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>
<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a> 
<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a> 
<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a> 
<span class="rows">11 条记录</span>
</div>
</div>



                <div class="page_list">
                    <ul>
                        <li class="disabled"><a href="#">&laquo;</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li><a href="#">&raquo;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->



@endsection
@section('js')
    <script>
        /**
         * ajax异步更改排序值
         * @param obj
         * @param cate_id
         */
        function orderChange(obj,cate_id){
                var cate_order = $(obj).val();
                console.log(cate_order);
                $.ajax({
                    type: 'POST',
                    url: 'order',
                    cache: false,
                    dataType: 'json',
                    data: {cate_id: cate_id, cate_order: cate_order, _token: '{{csrf_token()}}'},
                    success: function (data) {
                        if(data.status==0)
                            layer.alert(data.message, {icon: 6});
                        else
                            layer.alert(data.message, {icon: 5});
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                })
            }
    </script>
    <script>
        function deleteCategory(cate_id){
            layer.confirm('确定要删除此分类吗', {
                btn: ['确认','取消'] //按钮
            }, function(){
                $.ajax({
                    type:'delete',
                    url:'category/'+cate_id,
                    dataType:'json',
                    data:{'_token':'{{csrf_token()}}'},
                    cache:false,
                    success:function(data){
//                        alert(cate_id);
                        if(data.status==0) {
                            layer.alert(data.message, {icon: 6});
                            window,location='{{url('admins/category')}}';
                        }
                        else
                            layer.alert(data.message, {icon: 5});
                    },
                    error:function(xhr,status,error){
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                })
            });
        }
    </script>
@endsection