<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ProductBinding extends Model
{
    public $timestamps = false;
    protected $guarded = ['id'];

//    protected $appends = ['difference','percentagedifference'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'bound_product_id');
    }

    public function mainProduct()
    {
        return $this->belongsTo(Product::class, 'main_product_id');
    }

    public function priceEntriesOfBoundProduct()
    {
        return $this->hasMany(ProductPriceEntry::class, 'product_id', 'bound_product_id');
    }

    public function getPriceDifferenceAttribute()
    {
        return $this->product->price - $this->mainProduct->price;
    }

    public function getPercentageDifferenceAttribute()
    {
        $priceDifference = $this->product->price - $this->mainProduct->price;
        return round(($priceDifference / $this->mainProduct->price) * 100, 2);
    }

    /*
     * STATIC FUNCTIONS
     */

    public static function getBoundProductCurrentPrice($priceEntry)
    {
        $startTime = Carbon::today()->toDateString() . '00:00:00';
        $endTime = Carbon::today()->toDateString() . '23:59:59';
        if (strtotime($priceEntry->fetched_at) >= strtotime($startTime) && strtotime($priceEntry->fetched_at) <= strtotime($endTime)) {
            return $priceEntry->amount * 100;
        } else {
            return false;
        }
    }

    public static function getBoundProductOldPrice($priceEntry, $currentPrice, $boundProductId)
    {
        $startTime = Carbon::today()->toDateString() . '00:00:00';
        if ($currentPrice && (strtotime($priceEntry->fetched_at) < strtotime($startTime))) {
            return $priceEntry;
        } else {
            return false;
        }
    }

    public static function getBoundProductPriceChangePercentage($currentPrice, $oldPrice)
    {
        if ($currentPrice != null && $oldPrice != null) {
            return round((((float)$currentPrice - (float)$oldPrice)
                / (float)$oldPrice) * 100, 2);
        } else {
            return null;
        }
    }
}
