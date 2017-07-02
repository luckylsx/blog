<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $primaryKey='art_id';
    protected $guarded=[];
    public $timestamps = false;

    public function cate()
    {
        return $this->belongsTo(Category::class,'cate_id','cate_id');
    }
}
