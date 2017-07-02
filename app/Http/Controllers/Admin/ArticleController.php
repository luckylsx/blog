<?php

namespace App\Http\Controllers\Admin;

use App\Model\Article;
use App\Model\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController
{
    //get:admin/article  全部文章列表
    public function index()
    {
        $data = Article::orderby('art_id','desc')->paginate(5);
        return view('admin.article.index',compact('data'));
    }
    //添加文章
    //get:admin/article/create
    public function create()
    {
        $category = new Category();
        $data = $category->tree();
        return view('admin.article.add',compact('data'));
    }


    //添加文章的提交方法
    //post:admin/article
    public function store()
    {
        $input = Input::all();
        $input['art_time'] = time();
        $validator = Validator::make($input,[
            'art_title'=>'required',
            'art_content'=>'required',
            'cate_id'=>'required',
        ],[
            'art_title.required'=>'文章标题不能为空！',
            'art_content.required'=>'文章内容不能为空！',
            'cate_id.required'=>'文章分类不能为空！',
        ]);
        if($validator->passes()){   //验证通过，插入数据库
            $res = Article::create($input);
            if ($res){
                return redirect('admin/article');   //添加分类成功，跳转到列表页面
            }else{
                return back()->with('msg','分类添加失败，请稍后重试！');  //分类添加失败
            }
        }else{
            return back()->withErrors($validator);  //验证没通过，提示错误信息
        }
    }
    //修改文章
    //admin/article/{art_id}/edit
    public function edit($art_id)
    {
        $category = new Category();
        $data = $category->tree();
        $field = Article::find($art_id);
        return view('admin.article.edit',compact('field','data'));
    }
    //更新文章
    //put:admin/category/{category}
    public function update($art_id)
    {
        $input = Input::except('_token','_method');
        $res = Article::where('art_id',$art_id)->update($input);
        if ($res){
            return redirect('admin/article');
        }else{
            return back()->with('msg','分类修改失败，请稍后重试！');  //分类修改失败
        }
    }
    //删除单个文章
    //DELETE:admin/article/{category}
    public function destroy($art_id)
    {
        $res = Article::where('art_id',$art_id)->delete(); //删除分类
        if ($res){
            $data=[
                'status'=>0,
                'msg' =>'文章删除成功！',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg' =>'文章删除失败，请稍后重试！',
            ];
        }
        return $data;
    }

}
