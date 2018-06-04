<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductName extends Model
{
    protected $table = 'product_names';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
