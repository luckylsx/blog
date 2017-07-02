<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Nav extends Model
{
    protected $primaryKey='nav_id';
    protected $guarded=[];
    public $timestamps = false;
}
