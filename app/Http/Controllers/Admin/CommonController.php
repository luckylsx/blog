<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //文件上传
    public function upload()
    {
        $file = Input::file('Filedata');
        $extension = $file->getClientOriginalExtension();   //获得文件的扩展
        $newName = date('YmdHis').mt_rand(100,999) . '.' .$extension;   //获得上传文件的新名字
        $dir = public_path() . '/uploads/' . date('Y-m-d');
        if (!is_dir($dir)){
            mkdir($dir,0777,true);
        }
        $path = $file->move($dir,$newName);
        $filepath = date('Y-m-d').'/'. $newName;
        return $filepath;
    }
}
