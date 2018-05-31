<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionFormula extends Model
{
     protected $table = 'promotion_formula';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
}
