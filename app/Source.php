<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = [
        'name', 'url', 'is_main', 'is_disabled', 'vat', 'preset_id', 'name_prefix', 'netto', 'price_remove_prefix'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

//    public function getProductsDifferenceData($categoryId = null)
//    {
//        $expensivenessOffset = auth()->user()->getExpensivenessBorder();
//        $cheapnessOffset = auth()->user()->getCheapnessBorder();
//        $products = $this->products()->when($categoryId !== null, function($q) use ($categoryId) {
//            return $q->where('category_id', $categoryId);
//        })->with('mainBindings.product')->whereHas('mainBindings')->get();
//
//        $differences = $products->flatMap(function($product) {
//            return $product->mainBindings->map(function($binding) {
//                return $binding->product->price / $binding->mainProduct->price;
//            })->toArray();
//        });
//
//        $average = $differences->count() ? 1 - $differences->avg() : 0;
//
//        return [
//            'average' => percentise($average, false),
//            'bindings' => $products->count(),
//            'higher' => $differences->filter(function($difference) use ($expensivenessOffset) {
//                return $difference > $expensivenessOffset;
//            })->count(),
//            'cheaper' => $differences->filter(function($difference) use ($cheapnessOffset) {
//                return $difference < $cheapnessOffset;
//            })->count(),
//            'equal' => $differences->filter(function($difference) use ($cheapnessOffset, $expensivenessOffset) {
//                return ($difference >= $cheapnessOffset) && ($difference <= $expensivenessOffset);
//            })->count(),
//        ];
//    }

    public function getProductsDifference($categoryId = null, $products)
    {
        $expensivenessOffset = auth()->user()->getExpensivenessBorder();
        $cheapnessOffset = auth()->user()->getCheapnessBorder();
        if ($categoryId) {
            $products = $products->where('category_id', $categoryId);
        }

        $differences = $products->flatMap(function ($product) {
            return $product->mainBindings->map(function ($binding) {
                return $binding->product->price / $binding->mainProduct->price;
            })->toArray();
        });

        $average = $differences->count() ? 1 - $differences->avg() : 0;

        return [
            'average' => percentise($average, false),
            'bindings' => $products->count(),
            'higher' => $differences->filter(function ($difference) use ($expensivenessOffset) {
                return $difference > $expensivenessOffset;
            })->count(),
            'cheaper' => $differences->filter(function ($difference) use ($cheapnessOffset) {
                return $difference < $cheapnessOffset;
            })->count(),
            'equal' => $differences->filter(function ($difference) use ($cheapnessOffset, $expensivenessOffset) {
                return ($difference >= $cheapnessOffset) && ($difference <= $expensivenessOffset);
            })->count(),
        ];
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class);
    }

    public function currency()
    {
        return $this->belongsTo(CurrencyRate::class);
    }

    public function getDisplayVatAttribute()
    {
        return $this->vatRate ? $this->vatRate->country . ' [' . $this->vatRate->rate . '%]' : 'Custom [' . $this->vat . '%]';
    }

    public function getVat()
    {
        return $this->vat ?: $this->vatRate->rate;
    }

    public function getVatAmplifier()
    {
        return $this->getVat() / 100 + 1;
    }
}
