<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HealthInsuranceEnquiry extends Model
{
    protected $table = 'health_insurance_enquiry';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
