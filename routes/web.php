<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>['web'],
    ],function (){
    Route::get('/', 'Home\IndexController@index');
    Route::get('/cate', 'Home\IndexController@cate');
    Route::get('/art', 'Home\IndexController@article');
    Route::any('admin/login','Admin\LoginController@login');//登录页面
    Route::any('code','Admin\LoginController@code')->name('admin/code');  //验证码
    Route::any('a/{art_id}','Home\IndexController@article'); //文章详情
    Route::any('cate/{cate_id}','Home\IndexController@cate'); //文章列表
});

Route::group([
        'middleware'=>['web','admin.login'],
        'prefix'=>'admin',
        'namespace'=>'Admin'],function (){
    Route::any('index','IndexController@index');  //后台登录首页
    Route::any('info','IndexController@info')->name('admin/info');  //后台登录首页主体部分
    Route::any('quit','LoginController@quit')->name('admin/quit');  //退出登录页面
    Route::any('pass','IndexController@pass')->name('admin/pass');  //修改密码
    Route::any('category/changeorder','CategoryController@changeorder')->name('admin_cate_changeorder');  //修改分类排序

    //文章分类路由
    Route::resource('category', 'CategoryController');

    //文章路由
    Route::resource('article', 'ArticleController');
    //友情路由
    Route::resource('links', 'LinksController');
    Route::any('link/changeorder','LinksController@changeorder')->name('admin_link_changeorder');  //修改链接排序

    //导航路由
    Route::resource('navs', 'NavsController');
    Route::any('navs/changeorder','NavsController@changeorder')->name('admin_nav_changeorder');  //修改分类排序

    Route::get('config/putfile','ConfigController@putFile');  //修改内容
    //系统配置路由
    Route::resource('config', 'ConfigController');
    Route::any('config/changeorder','ConfigController@changeorder')->name('admin_config_changeorder');  //修改分类排序
    Route::any('config/changecontent','ConfigController@changecontent')->name('admin_config_changecontent');  //修改内容

    //文件上传
    Route::any('upload','CommonController@upload')->name('admin/upload'); //文件上传
});