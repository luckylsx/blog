<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $primaryKey='conf_id';
    protected $guarded=[];
    public $timestamps = false;
}
