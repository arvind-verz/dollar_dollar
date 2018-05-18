<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $table = 'system_setting';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
