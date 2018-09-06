<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentEnquiry extends Model
{
    protected $table = 'investment_enquiry';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
