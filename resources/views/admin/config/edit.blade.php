@extends('layouts.admin')
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; 编辑配置项
    </div>
    <!--面包屑配置项 结束-->

	<!--结果集标题与配置项组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>编辑友情配置项</h3>
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
                {{--<a href="#"><i class="fa fa-plus"></i>新增友情配置项</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>--}}
                <a href="javascript:;" onclick="javascript:history.go(-1)"><span><<</span>放弃修改</a>
            </div>
        </div>
    </div>
    <!--结果集标题与配置项组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config/'.$field->conf_id)}}" method="post">
            <input type="hidden" name="_method" value="put"/>
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>标题：</th>
                        <td>
                            <input type="text" name="conf_title" value={{$field->conf_name}}>
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题不能为空</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>名称：</th>
                        <td>
                            <input type="text" name="conf_name" value={{$field->conf_title}}>
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项名不能为空</span>
                        </td>
                    </tr>
                    <tr>
                        <th>类型：</th>
                        <td>
                            <input type="radio"  name="field_type" value="input" @if($field->field_type=='input') checked @endif onclick="showTr()">input　
                            <input type="radio"  name="field_type" value="textarea" @if($field->field_type=='textarea') checked @endif onclick="showTr()">textarea　
                            <input type="radio"  name="field_type" value="radio" @if($field->field_type=='radio') checked @endif onclick="showTr()">radio
                        </td>
                    </tr>
                    <tr  class="field_value">
                        <th>类型值：</th>
                        <td>
                            <input type="text" class="lg" name="field_value" {{$field->field_value}}>
                            <p><i class="require">*</i>只有在类型为radio时，才需要填写类型值，格式：1|开启,2|关闭</p>
                        </td>
                    </tr>
                    <tr>
                        <th>排序</th>
                        <td>
                            <input type="number" style="width: 50px;height:20px" name="conf_order" min="0" value="{{$field->conf_order}}"/>
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea cols="30" rows="10" name="conf_tips">{{$field->conf_tips}}</textarea>
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
    <script>
    showTr();
    function showTr(){
        var type = $("input[name='field_type']:checked").val();
        if(type=='radio'){
            $('.field_value').show();
        }else {
            $('.field_value').hide();
        }
    }
    </script>
@endsection