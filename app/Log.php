<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $casts = [
        'params' => 'array'
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function getParamsAttribute($value)
    {
        return json_decode($value, 1);
    }
}
