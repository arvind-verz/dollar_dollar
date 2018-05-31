<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LifeInsuranceEnquiry extends Model
{
    protected $table = 'life_insurance_enquiry';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
