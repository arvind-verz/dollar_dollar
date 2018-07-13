<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultSearch extends Model
{
    protected $table = 'default_search';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
