<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class IndexController extends CommonController
{
    //后台首页
    public function index()
    {
        return view('admin.index');
    }
    //获取后台首页主体部分
    public function info()
    {
        return view('admin.info');
    }
    //修改密码
    public function pass()
    {
        if ($input = Input::all()){     //如果有post提交
            $validator = Validator::make($input,[
                'password'=>'required|between:6,20|confirmed',
            ],[
                'password.required'=>'请输入新密码',
                'password.between'=>'请输入6-20位密码',
                'password.confirmed'=>'两次输入密码不一致',
            ]);
            if($validator->passes()){   //验证通过，修改密码
                $user=User::find(1);
                $_password = Crypt::decrypt($user->user_pass);  //获得解密后的原密码
                if ($input['password_o']==$_password){    //判断原密码是否输入正确
                    $user->user_pass=Crypt::encrypt($input['password']);  //将输入的新密码保存起来
                    $user->update();            //实行更新
                    return back()->with('errors','密码修改成功！');
                }else{
                    return back()->with('errors','原密码错误！');
                }

            }else{
                return back()->withErrors($validator);  //验证没通过，返回错误信息
            }
        }
        return view('admin.pass');
    }

}
