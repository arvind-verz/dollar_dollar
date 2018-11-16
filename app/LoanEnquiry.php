<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanEnquiry extends Model
{
    protected $table = 'loan_enquiry';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
