<?php

namespace App\Http\Controllers\Admin;

use App\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class NavsController extends CommonController
{
    //get:admin/navs  全部导航列表
    public function index()
    {
        $data = Nav::orderby('nav_order','asc')->get();
        return view('admin.navs.index',compact('data'));
    }
    //排序字段修改
    public function changeorder()
    {
        $input = Input::all();
        $nav = Nav::find($input['nav_id']);  //查找要排序的id
        $nav->nav_order = $input['nav_order'];   //将排序字段改为输入的字段
        $res = $nav->update();
        if ($res){
            $data = ['status'=>0,'msg'=>'排序更新成功'];
        }else{
            $data = ['status'=>1,'msg'=>'排序更新失败！'];
        }
        return $data;
    }
    //添加导航
    //get:admin/navs/create
    public function create()
    {
        return view('admin.navs.add');
    }
    //添加导航的提交方法
    //post:admin/navs
    public function store()
    {
        //对必要字段的验证
        $input = Input::except('_token');
        $validator = Validator::make($input,[
            'nav_name'=>'required',
            'nav_url'=>'required',
        ],[
            'nav_name.required'=>'导航名不能为空！',
            'nav_url.required'=>'导航地址不能为空！',
        ]);
        if($validator->passes()){   //验证通过，插入数据库
            $res = Nav::create($input);
            if ($res){
                return redirect('admin/navs');   //添加导航成功，跳转到列表页面
            }else{
                return back()->with('msg','导航添加失败，请稍后重试！');  //导航添加失败
            }
        }else{
            return back()->withErrors($validator);  //验证没通过，提示错误信息
        }
    }
    //修改导航
    //admin/navs/{nav_id}/edit
    public function edit($link_id)
    {
        $field = Nav::find($link_id);
        return view('admin.navs.edit',compact('field'));
    }
    //更新链接
    //put:admin/navs/{nav_id}
    public function update($nav_id)
    {
        $input = Input::except('_token','_method');
        $validator = Validator::make($input,[
            'nav_name'=>'required',
            'nav_url'=>'required',
        ],[
            'nav_name.required'=>'导航名不能为空！',
            'nav_url.required'=>'导航地址不能为空！',
        ]);
        if(!$validator->passes()) {   //验证没通过
            return back()->withErrors($validator);  //验证没通过，提示错误信息
        }
        $res = Nav::where('nav_id',$nav_id)->update($input);
        if ($res){
            return redirect('admin/navs');
        }else{
            return back()->with('msg','导航修改失败，请稍后重试！');  //导航修改失败
        }
    }
    //删除单个导航
    //DELETE:admin/navs/{nav_id}
    public function destroy($nav_id)
    {
        $res = Nav::where('nav_id',$nav_id)->delete(); //删除导航
        if ($res){
            $data=[
                'status'=>0,
                'msg' =>'导航删除成功！',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg' =>'导航删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
