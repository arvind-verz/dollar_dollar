<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class systemSettingHomepage extends Model
{
    protected $table = 'system_setting_homepage';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
