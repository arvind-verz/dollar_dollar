<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdsManagement extends Model
{
    protected $table = 'ads_management';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
