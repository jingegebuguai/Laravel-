@extends('Layout.admin')
@section('content')
	<!--面包屑导航 开始-->
	<div class="crumb_warp">
		<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
		<i class="fa fa-home"></i> <a href="{{url('admins/info')}}">首页</a>> 系统配置信息
	</div>
	<!--面包屑导航 结束-->
	
	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admins/category')}}"><i class="fa fa-plus"></i>文章分类</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="{{url('admins/category/create')}}"><i class="fa fa-refresh"></i>添加分类</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

	
    <div class="result_wrap">
        <div class="result_title">
            <h3>系统基本信息</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>操作系统</label><span>{{PHP_OS}}</span>
                </li>
                <li>
                    <label>运行环境</label><span>{{$_SERVER['SERVER_SOFTWARE']}}</span>
                </li>
                <li>
                    <label>数据库连接方式</label><span>{{$_SERVER['DB_CONNECTION']}}</span>
                </li>
                <li>
                    <label>惠惠设计-版本</label><span>v-0.1</span>
                </li>
                <li>
                    <label>上传附件限制</label><span><?php echo get_cfg_var('upload_max_filesize')?get_cfg_var('upload_max_filesize'):'不允许上传附件' ?></span>
                </li>
                <li>
                    <label>北京时间</label><span><?php echo(date('Y-m-d H:i:s')) ?></span>
                </li>
                <li>
                    <label>服务器域名/IP</label><span>{{$_SERVER['HTTP_HOST']}} [ {{$_SERVER['DB_HOST']}} ]</span>
                </li>
                <li>
                    <label>Host</label><span>{{$_SERVER['REMOTE_ADDR']}}</span>
                </li>
            </ul>
        </div>
    </div>


    <div class="result_wrap">
        <div class="result_title">
            <h3>使用帮助</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>官方交流网站：</label><span><a href="#">http://www.huihui.kim</a></span>
                </li>
            </ul>
        </div>
    </div>
	<!--结果集列表组件 结束-->

@endsection