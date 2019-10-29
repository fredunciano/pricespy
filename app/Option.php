<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name', 'category', 'price', 'link', 'is_actual', 'fetched_at', 'has_vat_calculated_manually'];

    protected $dates = ['fetched_at'];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function showPrice()
    {
        return formatMoney($this->price);
    }

    public function bindings()
    {
        //return $this->hasManyThrough(OptionBinding::class, Option::class, 'main_option_id', 'bound_option_id', 'id');
        return $this->hasMany(OptionBinding::class, 'main_option_id');
    }

    public function mainBindings()
    {
        return $this->hasMany(OptionBinding::class, 'bound_option_id');
    }

    public function getFullNameAttribute()
    {
        return t($this->category->display_name) . ' ' . $this->name;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
