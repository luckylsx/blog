<?php

namespace App\Http\Controllers\Admin;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

//引入第三方验证码类文件
require_once resource_path() . '/org/code/Code.class.php';
class LoginController extends CommonController
{
    public function login()
    {
        if ($input = Input::all()){     //判断是否有post提交
            $code = new \Code();
            $_code = $code->get();
            if (strtoupper($input['code'])!=$_code){    //验证验证码是否正确
                return back()->with('msg','验证码不正确！');   //如果验证码错误，记录错误信息
            }
            $user = User::first();          //从数据库查询管理员信息
            if ($input['user_name']!=$user->user_name || $input['user_pass']!=Crypt::decrypt($user->user_pass)){
                //将登陆信息保存在session中
                return back()->with('msg','用户名或密码错误！');   //如果验证码错误，记录错误信息
            }
            session(['user'=>$user]);
            return redirect('admin/index'); //显示后台首页
        }
        session(['user'=>null]);
        return view('Admin.login'); //返回登录页面

    }

    //生成验证码
    public function code()
    {
        $code = new \Code();
        $code->make();
    }
    //退出登录页面
    public function quit()
    {
        session(['user'=>null]);    //销毁session
        return redirect('admin/login');
    }

}
