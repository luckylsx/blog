@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{route('admin/info')}}">首页</a> &raquo; 添加文章分类
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加友情链接</h3>
            @if(count($errors)>0)
                <div class="mark">
                    @if(is_object($errors))
                        @foreach($errors->all() as $error)
                            <p style="color: red">{{$error}}</p>
                        @endforeach
                    @else
                        <p>{{$errors}}</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="result_content">
            <div class="short_wrap">
                {{--<a href="{{url('admin/category/create')}}"><i class="fa fa-plus"></i>新增分类</a>--}}
                {{--<a href="{{url('admin/category')}}"><i class="fa fa-recycle"></i>全部分类</a>--}}
                {{--<a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
                <a href="javascript:;" onclick="javascript:history.go(-1)"><span><<</span>返回列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/links')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>链接名称：</th>
                        <td>
                            <input type="text" name="link_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>友情链接名不能为空</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>链接地址：</th>
                        <td>
                            <input type="text" class="lg" name="link_url" value="http://">
                        </td>
                    </tr>
                    <tr>
                        <th>链接标题：</th>
                        <td>
                            <input type="text" class="lg" name="link_title">
                        </td>
                    </tr>

                   <!-- <tr>
                        <th><i class="require">*</i>价格：</th>
                        <td>
                            <input type="text" class="sm" name="">元
                            <span><i class="fa fa-exclamation-circle yellow"></i>这里是短文本长度</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>缩略图：</th>
                        <td><input type="file" name=""></td>
                    </tr>
                    <tr>
                        <th>单选框：</th>
                        <td>
                            <label for=""><input type="radio" name="">单选按钮一</label>
                            <label for=""><input type="radio" name="">单选按钮二</label>
                        </td>
                    </tr>
                    <tr>
                        <th>复选框：</th>
                        <td>
                            <label for=""><input type="checkbox" name="">复选框一</label>
                            <label for=""><input type="checkbox" name="">复选框二</label>
                        </td>
                    </tr>
                    -->

                    <tr>
                        <th>排序</th>
                        <td>
                            <input type="number" style="width: 50px;height:20px" name="link_order" min="0" value="0"/>
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