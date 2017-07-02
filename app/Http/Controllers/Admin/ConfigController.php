<?php

namespace App\Http\Controllers\Admin;

use App\Model\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ConfigController extends CommonController
{
    //get:admin/config  全部配置项列表
    public function index()
    {
        $data = Config::orderby('conf_order','asc')->get();
        foreach($data as $k=>$v){
            switch ($v->field_type){
                case 'input':
                    $data[$k]->_html = '<input type="text" class="lg" name="conf_content[]" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html = '<textarea name="conf_content[]" class="lg">'. $v->conf_content .'</textarea>';
                    break;
                case 'radio':
                    $str='';
                   $arr = explode(',',$v->field_value);
                   foreach ($arr as $n=>$m){
                       $r = explode('|',$m);
                       $c=$v->conf_content==$r[0]?' checked ':'';
                       $str.='<input type="radio" name="conf_content[]" value="'.$r[0].'"'.$c.'>'.$r[1] .'　';
                   }
                   $data[$k]->_html = $str;
                    break;
            }
        }
        return view('admin.config.index',compact('data'));
    }
    //修改内容
    public function changecontent()
    {
        $input = Input::all();
        foreach ($input['conf_id'] as $k=>$v){
            Config::where(['conf_id'=>$v])->update(['conf_content'=>$input['conf_content'][$k]]);
        }
        $this->putFile();
        return back()->with('errors','配置项更新成功！');  //配置项修改成功
    }
    //排序字段修改
    public function changeorder()
    {
        $input = Input::all();
        $config = Config::find($input['conf_id']);  //查找要排序的id
        $config->conf_order = $input['conf_order'];   //将排序字段改为输入的字段
        $res = $config->update();
        if ($res){
            $data = ['status'=>0,'msg'=>'排序更新成功'];
        }else{
            $data = ['status'=>1,'msg'=>'排序更新失败！'];
        }
        return $data;
    }
    //添加配置项
    //get:admin/config/create
    public function create()
    {
        return view('admin.config.add');
    }
    //添加配置项的提交方法
    //post:admin/config
    public function store()
    {
        //对必要字段的验证
        $input = Input::except('_token');
        $validator = Validator::make($input,[
            'conf_name'=>'required',
            'conf_title'=>'required',
        ],[
            'conf_name.required'=>'配置项名不能为空！',
            'conf_title.required'=>'配置项标题不能为空！',
        ]);
        if($validator->passes()){   //验证通过，插入数据库
            $res = Config::create($input);
            if ($res){
                return redirect('admin/config');   //添加配置项成功，跳转到列表页面
            }else{
                return back()->with('msg','配置项添加失败，请稍后重试！');  //配置项添加失败
            }
        }else{
            return back()->withErrors($validator);  //验证没通提示错误信息
        }
    }
    //修改配置项
    //admin/config/{conf_id}/edit
    public function edit($conf_id)
    {
        $field = Config::find($conf_id);
        return view('admin.config.edit',compact('field'));
    }

    public function putFile()
    {
//       echo  \Illuminate\Support\Facades\Config::get('web.网站标题');
        $config = Config::pluck('conf_content','conf_name')->all();
        $str = '<?php return ' . var_export($config,true) .';';
        $path = base_path(). '\config\web.php';
        file_put_contents($path,$str);
    }
    //更新链接
    //put:admin/config/{conf_id}
    public function update($conf_id)
    {
        $input = Input::except('_token','_method');
        $validator = Validator::make($input, [
            'conf_title'=>'required',
            'conf_name'=>'required',
        ],[
            'conf_title.required'=>'配置项标题不能为空！',
            'conf_name.required'=>'配置项名不能为空！',
        ]);
        if(!$validator->passes()) {   //验证没通过
            return back()->withErrors($validator);  //验证没通过，提示错误信息
        }
        $res = Config::where('conf_id',$conf_id)->update($input);
        if ($res){
            $this->putFile();
            return redirect('admin/config');
        }else{
            return back()->with('msg','配置项修改失败，请稍后重试！');  //配置项修改失败
        }
    }
    //删除单个配置项
    //DELETE:admin/config/{conf_id}
    public function destroy($conf_id)
    {
        $res = Config::where('conf_id',$conf_id)->delete(); //删除配置项
        if ($res){
            $this->putFile();
            $data=[
                'status'=>0,
                'msg' =>'配置项删除成功！',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg' =>'配置项删除失败，请稍后重试！',
            ];
        }
        return $data;
    }

    public function show()
    {
        
    }
}
