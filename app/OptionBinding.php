<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OptionBinding extends Model
{
    protected $guarded = ['main_option_id'];

    public $timestamps = false;

    public function option()
    {
        return $this->belongsTo(Option::class, 'bound_option_id');
    }

    public function mainOption()
    {
        return $this->belongsTo(Option::class, 'main_option_id');
    }

}
