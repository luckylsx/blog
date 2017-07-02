@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{route('admin/info')}}">首页</a> &raquo; 添加导航
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>添加导航</h3>
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
                {{--<a href="#"><i class="fa  fa-long-arrow-left"></i>返回列表</a>--}}
                <a href="javascript:;" onclick="javascript:history.go(-1)"><i class="fa  fa-long-arrow-left"></i>返回列表</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/navs')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>导航名称：</th>
                        <td>
                            <input type="text" name="nav_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>导航名不能为空</span>
                        </td>
                    </tr>
                    <tr>
                        <th>英文名：</th>
                        <td>
                            <input type="text" class="lg" name="nav_alias">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>导航地址：</th>
                        <td>
                            <input type="text" class="lg" name="nav_url" value="http://">
                        </td>
                    </tr>
                    <tr>
                        <th>排序</th>
                        <td>
                            <input type="number" style="width: 50px;height:20px" name="nav_order" min="0" value="0"/>
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