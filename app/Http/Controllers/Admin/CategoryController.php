<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
    //get:admin/category  全部分类列表
    public function index()
    {
        $category = new Category();
        $tree = $category->tree();
        return view('admin.category.index')->with('data',$tree);   //将分类信息分配到模板中
    }
    //排序字段修改
    public function changeorder()
    {
        $input = Input::all();
        $cate = Category::find($input['cate_id']);  //查找要排序的id
        $cate->cate_order = $input['cate_order'];   //将排序字段改为输入的字段
        $res = $cate->update();
        if ($res){
            $data = ['status'=>0,'msg'=>'排序更新成功'];
        }else{
            $data = ['status'=>1,'msg'=>'排序更新失败！'];
        }
        return $data;
    }

    //添加分类
    //get:admin/category/create
    public function create()
    {
        $data = Category::where('cate_pid',0)->get();
        return view('admin.category.add',compact('data'));
    }

    //添加分类的提交方法
    //post:admin/category
    public function store()
    {
        //对必要字段的验证
        $input = Input::except('_token');
        $validator = Validator::make($input,[
            'cate_name'=>'required',
        ],[
            'cate_name.required'=>'分类名不能为空！',
        ]);
        if($validator->passes()){   //验证通过，插入数据库
            $res = Category::create($input);
           if ($res){
               return redirect('admin/category');   //添加分类成功，跳转到列表页面
           }else{
               return back()->with('msg','分类添加失败，请稍后重试！');  //分类添加失败
           }
        }else{
            return back()->withErrors($validator);  //验证没通过，提示错误信息
        }
    }
    //显示单个分类信息
    //GET:admin/category/{category}
    public function show()
    {

    }
    //修改分类
    //admin/category/{category}/edit
    public function edit($cate_id)
    {
//        $data = Category::where('cate_pid','<',2)->get();
        $category = new Category();
        $data = $category->tree();
        $field = Category::find($cate_id);
        return view('admin.category.edit',compact('field','data'));
    }
    //更新分类
    //put:admin/category/{category}
    public function update($cate_id)
    {
        $input = Input::except('_token','_method');
        $res = Category::where('cate_id',$cate_id)->update($input);
        if ($res){
           return redirect('admin/category');
        }else{
            return back()->with('msg','分类修改失败，请稍后重试！');  //分类修改失败
        }
    }


}
