<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormulaVariable extends Model
{
    protected $table = 'formula_variables';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
