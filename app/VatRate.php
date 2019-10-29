<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VatRate extends Model
{
    protected $fillable = ['country', 'code', 'rate'];
}
