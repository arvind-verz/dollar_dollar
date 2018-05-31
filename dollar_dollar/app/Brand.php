<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand_logo',
        'brand_link',
        'title',
        'view_orde',
        'delete_status'
    ];


}
