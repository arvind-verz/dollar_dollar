<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ToolTip extends Model
{
    protected $table = 'tool_tips';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
