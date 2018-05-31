<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacementRange extends Model
{
    protected $table = 'placement_range';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
