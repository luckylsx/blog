<?php

namespace App\Http\Controllers\Home;

use App\Model\Article;
use App\Model\Category;
use App\Model\Link;
use App\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends CommonController
{
    public function index()
    {
        //图文列表的5篇文章
        $data = Article::orderby('art_time','desc')->paginate(5);
        //最新的8篇文章
        $new = Article::orderby('art_time','desc')->take(8)->get();
        //友情链接
        $links = Link::orderby('link_order','asc')->get();
        return view('home.index',compact('hot','data','new','asort','links'));
    }
    public function cate($cate_id)
    {
        $cate = Category::find($cate_id);
        //图文列表文章
        $articles = Article::where('cate_id',$cate_id)->paginate(5);
        //当前分类的子分类
        $submenu = Category::where('cate_pid',$cate_id)->get();
        return view('home.list',compact('articles','cate','submenu'));
    }
    public function article($art_id)
    {
        //浏览量每次自增1
        Article::where('art_id',$art_id)->increment('art_view');
        $field = Article::join('categories','articles.cate_id','=','categories.cate_id')
                ->where('art_id',$art_id)
                ->first();
        $article['pre'] = Article::where('art_id','<',$art_id)->orderby('art_id','desc')->first();
        $article['next'] = Article::where('art_id','>',$art_id)->orderby('art_id','asc')->first();
        $data = Article::where('cate_id',$field->cate_id)->orderby('art_id','desc')->take(6)->get();
        return view('home.new',compact('field','article','data'));
    }
}
