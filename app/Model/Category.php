<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey='cate_id';
    protected $guarded=[];
    public function tree()
    {
        $categorys = Category::orderby('cate_order','asc')->get();
        $tree = $this->getTree($categorys);
        return $tree;
    }
    public function getTree($data,$category_id=0,$level=0)
    {
        static $arr=[];
        foreach($data as $v){
            if ($v->cate_pid==$category_id){
                $v['level'] = $level;
                $arr[] = $v;
                $this->getTree($data,$v->cate_id,$level+1);
            }
        }
        return $arr;
    }
}
