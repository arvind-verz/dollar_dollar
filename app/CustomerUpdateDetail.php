<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerUpdateDetail extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User'); // links this->id to events.course_id
    }
}
