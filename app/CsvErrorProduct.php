<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CsvErrorProduct extends Model
{
    protected $fillable = [
        'user_id', 'temp_id', 'description',
    ];

    protected $appends = ['description_as_array'];

    public function getDescriptionAsArrayAttribute()
    {
        return json_decode($this->description, true);
    }
}
