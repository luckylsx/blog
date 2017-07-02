<?php

namespace App\Http\Controllers\Home;

use App\Model\Article;
use App\Model\Nav;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    public function __construct()
    {
        //点击量最高的6篇文章
        $hot = Article::orderby('art_time','desc')->take(6)->get();
        //排行量最高的5篇文章
        $asort = Article::orderby('art_view','desc')->take(5)->get();
        $navs = Nav::all();
        View::share('navs',$navs);
        View::share('hot',$hot);
        View::share('asort',$asort);
    }
}
