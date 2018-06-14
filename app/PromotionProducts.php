<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionProducts extends Model
{
    protected $table = 'promotion_products';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
}
