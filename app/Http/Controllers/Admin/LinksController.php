<?php

namespace App\Http\Controllers\Admin;

use App\Model\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //get:admin/links  全部分类列表
    public function index()
    {
        $data = Link::orderby('link_order','asc')->get();
        return view('admin.links.index',compact('data'));
    }
    //排序字段修改
    public function changeorder()
    {
        $input = Input::all();
        $link = Link::find($input['link_id']);  //查找要排序的id
        $link->link_order = $input['link_order'];   //将排序字段改为输入的字段
        $res = $link->update();
        if ($res){
            $data = ['status'=>0,'msg'=>'排序更新成功'];
        }else{
            $data = ['status'=>1,'msg'=>'排序更新失败！'];
        }
        return $data;
    }
    //添加友情链接
    //get:admin/category/create
    public function create()
    {
        return view('admin.links.add');
    }
    //添加分类的提交方法
    //post:admin/links
    public function store()
    {
        //对必要字段的验证
        $input = Input::except('_token');
        $validator = Validator::make($input,[
            'link_name'=>'required',
            'link_url'=>'required',
        ],[
            'link_name.required'=>'链接名不能为空！',
            'link_url.required'=>'链接地址不能为空！',
        ]);
        if($validator->passes()){   //验证通过，插入数据库
            $res = Link::create($input);
            if ($res){
                return redirect('admin/links');   //添加友情链接成功，跳转到列表页面
            }else{
                return back()->with('msg','友情链接添加失败，请稍后重试！');  //分类添加失败
            }
        }else{
            return back()->withErrors($validator);  //验证没通过，提示错误信息
        }
    }
    //修改分类
    //admin/links/{link_id}/edit
    public function edit($link_id)
    {
        $field = Link::find($link_id);
        return view('admin.links.edit',compact('field'));
    }
    //更新链接
    //put:admin/links/{link_id}
    public function update($link_id)
    {
        $input = Input::except('_token','_method');
        $validator = Validator::make($input,[
            'link_name'=>'required',
            'link_url'=>'required',
        ],[
            'link_name.required'=>'链接名不能为空！',
            'link_url.required'=>'链接地址不能为空！',
        ]);
        if(!$validator->passes()) {   //验证没通过
            return back()->withErrors($validator);  //验证没通过，提示错误信息
        }
        $res = Link::where('link_id',$link_id)->update($input);
        if ($res){
            return redirect('admin/links');
        }else{
            return back()->with('msg','友情链接修改失败，请稍后重试！');  //分类修改失败
        }
    }
    //删除单个分类
    //DELETE:admin/links/{link_id}
    public function destroy($link_id)
    {
        $res = Link::where('link_id',$link_id)->delete(); //删除分类
        if ($res){
            $data=[
                'status'=>0,
                'msg' =>'分类删除成功！',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg' =>'分类删除失败，请稍后重试！',
            ];
        }
        return $data;
    }
}
