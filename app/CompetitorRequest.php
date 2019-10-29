<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitorRequest extends Model
{
    protected $fillable = ['name', 'url', 'remarks'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
