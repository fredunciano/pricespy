<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'user_id', 'slug', 'description'];

//    protected $appends = ['percentage_difference'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function listings()
    {
        return $this->pages()->where('type', 'listing');
    }

    public function sps()
    {
        return $this->pages()->where('type', 'page');
    }

    public function deletable()
    {
        return !($this->pages()->count() + $this->products()->count());
    }

    public function getPercentageDifferenceAttribute()
    {
        $this->products->bindings;
    }

    public function setNameAttribute($value)
    {
        return $this->attributes['name'] = ucwords($value);
    }
}
