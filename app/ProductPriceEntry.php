<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPriceEntry extends Model
{
    protected $fillable = ['price', 'vat_price', 'product_id', 'range_min_price', 'range_max_price', 'amount_with_prices', 'fetched_at'];

    protected $dates = ['fetched_at'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (int)($value * 100);
    }

    public function getPriceAttribute($value)
    {
        return (float) $value / 100;
    }

    public function setVatPriceAttribute($value)
    {
        $this->attributes['vat_price'] = (int)($value * 100);
    }

    public function getVatPriceAttribute($value)
    {
        return (float) $value / 100;
    }

    public function getAmountAttribute()
    {
        return auth()->user()->after_tax_prices ? (float)$this->vat_price / 100 : (float)$this->price / 100;
    }

    public function setRangeMinPriceAttribute($value)
    {
        $this->attributes['range_min_price'] = $value ? (int)($value * 100) : null;
    }

    public function getRangeMinPriceAttribute($value)
    {
        return $value ? (float)$value / 100 : null;
    }

    public function setRangeMaxPriceAttribute($value)
    {
        $this->attributes['range_max_price'] = $value ? (int)($value * 100) : null;
    }

    public function getRangeMaxPriceAttribute($value)
    {
        return $value ? (float)$value / 100 : null;
    }

    public function setAmountWithPricesAttribute($value)
    {
        $this->attributes['amount_with_prices'] = $value ? json_encode($value) : null;
    }

    public function getAmountWithPricesAttribute($value)
    {
        return $value ? json_decode($value, true) : null;
    }

    protected $appends = ['amount'];
}
