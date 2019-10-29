<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preset extends Model
{
    /*protected $fillable = ['title', 'element', 'name', 'link', 'price', 'brand', 'pagination', 'fake_pagination',
                           'multiplier'];*/

    protected $casts = [
        'name' => 'array',
        'link' => 'array',
        'price' => 'array',
        'sp' => 'array',
    ];
}
