@extends('Layout.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admins/info')}}">首页</a> &raquo; 添加文章分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @foreach($errors->all() as $error)
                        <p style="color:orangered">{{$error}}</p>
                    @endforeach
                </div>
            @endif

            @if(session('message'))
                <div class="mark">
                    <p style="color:orangered">{{session('message')}}</p>
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="{{url('admins/category')}}"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admins/category')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                    <th width="120"><i class="require">*</i>所属分类：</th>
                    <td>
                        <select name="cate_pid">
                            <option value="0">顶级分类</option>
                            @foreach($data as $_data)
                                <option value="{{$_data->cate_id}}"><?php echo str_repeat('-',8*$_data['level']) ?>{{$_data->cate_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    </tr>
                    <tr>
                        <th>文章发布时间：</th>
                        <td>
                            <input type="text" class="sm" name="edit_time">
                            <span><i class="fa fa-exclamation-circle yellow"></i>发布时间</span>
                        </td>
                    </tr>
                    <tr>
                        <th>文章查看次数：</th>
                        <td>
                            <input type="text" class="sm" name="article_view">
                        </td>
                    </tr>
                    <tr>
                        <th>文章作者：</th>
                        <td>
                            <input type="text" class="sm" name="article_editor">
                            <span><i class="fa fa-exclamation-circle yellow"></i>填写作者</span>
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" class="lg" name="article_title">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章缩略图：</th>
                        <td>
                            <input type="text" class="lg" name="article_title">
                            <link rel="stylesheet" type="text/css" href="{{asset('Upload/Huploadify.css')}}"/>
                            <script type="text/javascript" src="{{asset('Upload/jquery.Huploadify.js')}}"></script>
                            <div id="upload"></div>
                            <script type="text/javascript">
                                $(function(){
                                    $('#upload').Huploadify({
                                        auto:false,
                                        fileTypeExts:'*.jpg;*.png;*.exe',
                                        multi:true,
                                        formData:
                                            {
                                                '_token':"{{csrf_token()}}"
                                            },
                                        fileSizeLimit:9999,
                                        showUploadedPercent:true,//是否实时显示上传的百分比，如20%
                                        showUploadedSize:true,
                                        removeTimeout:9999999,
                                        uploader:'upload.php',
                                        onUploadStart:function(){
                                            //alert('开始上传');
                                        },
                                        onInit:function(){
                                            //alert('初始化');
                                        },
                                        onUploadComplete:function(){
                                            //alert('上传完成');
                                        },
                                        onDelete:function(file){
                                            console.log('删除的文件：'+file);
                                            console.log(file);
                                        }
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th>文章关键词：</th>
                        <td>
                            <textarea name="article_tag"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>文章描述：</th>
                        <td>
                            <textarea name="article_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章内容：</th>
                        <td>
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain" style="width:90%;height:300px"></script>
                            <!-- 配置文件 -->
                            <script type="text/javascript" src="{{asset('UEditor/ueditor.config.js')}}"></script>
                            <!-- 编辑器源码文件 -->
                            <script type="text/javascript" src="{{asset('UEditor/ueditor.all.js')}}"></script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue = UE.getEditor('container');
                            </script>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection
@section('js')


@endsection