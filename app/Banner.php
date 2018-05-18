<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Banner extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'page_id',
        'sub_page_id',
        'banner_link',
        'banner_image',
        'title',
        'banner_content',
        'banner_content_color',
        'view_order',
        'delete_status',

    ];


}
