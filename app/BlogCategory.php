<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';
    //Table name
    public $primaryKey = 'id';
    //Primary key
    public $timestamps = true;
    //Timestamp
}
