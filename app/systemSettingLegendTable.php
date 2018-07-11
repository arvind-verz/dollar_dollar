<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class systemSettingLegendTable extends Model
{
    protected $table = 'system_setting_legend_table';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
