@extends("layouts.admin")
@section('content')
    <!--面包屑配置项 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{route('admin/info')}}">首页</a> 》配置项管理
    <!--面包屑配置项 结束-->

    <!--搜索结果页面 列表 开始-->
    <div class="result_wrap">
        <div class="result_title">
            <h3>配置项管理</h3>
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
        <!--快捷配置项 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/config/create')}}"><i class="fa fa-plus"></i>新增配置项</a>
                <a href="{{url('admin/config')}}"><i class="fa fa-recycle"></i>全部配置项</a>
                <a href="javascript:void(0)" id="refresh"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
        <!--快捷配置项 结束-->
    </div>

        <div class="result_wrap">
            <div class="result_content">
                <form action="{{route('admin_config_changecontent')}}" method="post">
                    {{csrf_field()}}
                <table class="list_tab">
                    <tr>
                        {{--<th class="tc" width="5%"><input type="checkbox" name=""></th>--}}
                        <th class="tc">排序</th>
                        <th class="tc">ID</th>
                        <th>配置项标题</th>
                        <th>配置项名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" name="ord[]" onchange="changeOrder(this,{{$v->conf_id}})" value="{{$v->conf_order}}">
                        </td>
                        <td class="tc">{{$v->conf_id}}</td>
                        <td>{{$v->conf_title}}</td>
                        <td>
                            <a href="#">
                                {{$v->conf_name}}
                            </a>
                        </td>
                        <td>
                            <input type="hidden" value="{{$v->conf_id}}" name="conf_id[]">
                            {!! $v->_html !!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/'.$v->conf_id.'/edit')}}">修改</a>
                            <a href="javascript:;" onclick="delNav({{$v->conf_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                    <div class="btn_group">
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                    </div>
                </form>
            </div>
        </div>
    <!--搜索结果页面 列表 结束-->
    <script type="text/javascript">
        function changeOrder(obj,conf_id){
            var conf_order = $(obj).val();
            var data = {'_token':'{{csrf_token()}}','conf_order':conf_order,'conf_id':conf_id};
            $.post("{{route('admin_config_changeorder')}}",data,function (res) {
                if(!res.status){
                    layer.msg(res.msg, {icon: 6});
                }else{
                    layer.msg(res.msg, {icon: 5});
                }
            })
        }
        //刷新当前页面
        $(function () {
            $('#refresh').click(function () {
                window.location.reload();
            });
        })
    </script>
    <script>
        //删除分类
        function delNav(conf_id) {
            layer.confirm('您确定要删除这个配置项吗？',{
                btn: ['确定','取消'] //按钮
            }, function(){
                $.post("{{url('admin/config/')}}/"+conf_id,{'_method':'delete','_token':"{{csrf_token()}}"},function (data) {
                    if(data.status==0){
                        location.href = location.href;
                        layer.msg(data.msg, {icon: 6});
                    }else{
                        layer.msg(data.msg, {icon: 5});
                    }
                });
//            layer.msg('的确很重要', {icon: 1});
            }, function(){

            });
        }
    </script>
@endsection