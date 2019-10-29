<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPriceOption extends Model
{
    protected $fillable = ['product_id', 'name', 'price', 'option'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
