<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $primaryKey='link_id';
    protected $guarded=[];
    public $timestamps = false;
}
