<?php


namespace App\Statistics;

use App\ProductBinding;
use Carbon\Carbon;

class Rating
{
    protected $users;
    protected $user;

    protected $products;
    protected $product;

    protected $bindings;

    protected $top;
    
    protected $productBindings;
    public function get($user = null)
    {
        $this->productBindings = ProductBinding::all()->toArray();
        $this->user = $user ?: auth()->user();
        $this->setProducts();
        $this->setDifference();
        $this->sort();
        $this->setTop();
        return $this->top;
    }

    protected function setProducts()
    {
        $this->products = $this->user->products()
            ->with('source')
            ->where(function ($q) {
                return $q->whereHas('mainBindings')->orWhereHas('bindings');
            })
            ->with('mainBindings')
            ->with('bindings')
            ->with('priceEntries')
            ->with(array('category' => function ($q) {
                $q->select('id', 'name');
            }))
            ->where('price', '>', 0)
            ->where('vat_price', '>', 0)
            ->get();
    }

    protected function setDifference()
    {
        $this->products->each(function ($product) {
            $this->product = $product;
            $this->setProductDifference();
        });
    }

    protected function setProductDifference()
    {
        $this->setBindings();

        $this->product->difference = round($this->bindings->map(function ($binding) {
            return (1 - $binding->price / $this->product->price) * 100;
        })->avg(), 2);

        $productPriceEntries = $this->product->priceEntries;
        $this->product->yesterday_difference = round($this->bindings->map(function ($binding) use ($productPriceEntries) {
            $bindProductYesterdayPrice = collect($binding->priceEntries)->where('product_id', $binding->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::yesterday())->first()['price'];
            $productYesterdayPrice = collect($productPriceEntries)->where('product_id', $this->product->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::yesterday())->first()['price'];
            if ($bindProductYesterdayPrice != null && $productYesterdayPrice != null) {
                return (1 - $bindProductYesterdayPrice / $productYesterdayPrice) * 100;
            }
            return 0;
        })->avg(), 2);

        $this->product->last_week_difference = round($this->bindings->map(function ($binding) use ($productPriceEntries) {
            $bindProductYesterdayPrice = collect($binding->priceEntries)->where('product_id', $binding->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::now()->subDays(7))->first()['price'];
            $productYesterdayPrice = collect($productPriceEntries)->where('product_id', $this->product->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::now()->subDays(7))->first()['price'];
            if ($bindProductYesterdayPrice != null && $productYesterdayPrice != null) {
                return (1 - $bindProductYesterdayPrice / $productYesterdayPrice) * 100;
            }
            return 0;
        })->avg(), 2);

        $this->product->last_month_difference = round($this->bindings->map(function ($binding) use ($productPriceEntries) {
            $bindProductYesterdayPrice = collect($binding->priceEntries)->where('product_id', $binding->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::now()->subDays(30))->first()['price'];
            $productYesterdayPrice = collect($productPriceEntries)->where('product_id', $this->product->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::now()->subDays(30))->first()['price'];
            if ($bindProductYesterdayPrice != null && $productYesterdayPrice != null) {
                return (1 - $bindProductYesterdayPrice / $productYesterdayPrice) * 100;
            }
            return 0;
        })->avg(), 2);

        $this->product->last_year_difference = round($this->bindings->map(function ($binding) use ($productPriceEntries) {
            $bindProductYesterdayPrice = collect($binding->priceEntries)->where('product_id', $binding->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::now()->subDays(365))->first()['price'];
            $productYesterdayPrice = collect($productPriceEntries)->where('product_id', $this->product->id)->sortByDesc('fetched_at')
                ->where('fetched_at', '<=', Carbon::now()->subDays(365))->first()['price'];
            if ($bindProductYesterdayPrice != null && $productYesterdayPrice != null) {
                return (1 - $bindProductYesterdayPrice / $productYesterdayPrice) * 100;
            }
            return 0;
        })->avg(), 2);
    }


    protected function setBindings()
    {
        $this->bindings = $this->getBindings()->map(function ($binding) {
            return $this->products->find($this->getBoundProduct($binding));
        })->filter(function ($product) {
            return !!$product;
        });
    }

    protected function getBindings()
    {
        return $this->product->bindings->isNotEmpty() ? $this->product->bindings : $this->getCascadeBindings();
    }

    protected function getCascadeBindings()
    {
        return collect($this->productBindings)->whereIn('main_product_id', $this->product->mainBindings->pluck('main_product_id')->toArray())
            ->where('bound_product_id', '!=', $this->product->id)
            ->merge($this->product->mainBindings);
    }

    protected function getBoundProduct($binding)
    {
        return ($binding['bound_product_id'] === $this->product->id) ? $binding['main_product_id'] : $binding['bound_product_id'];
    }

    protected function sort()
    {
        $this->products = $this->products->sortBy(function ($product) {
            return $product->difference;
        });
    }

    protected function setTop()
    {
        $this->setTopOwn();
        $this->setTopCompetitors();
    }

    protected function setTopOwn()
    {
        $this->top['own'] = $this->products->filter(function ($product) {
            return $product->source->is_main && $product->difference < 0;
        })->take(5);
    }

    protected function setTopCompetitors()
    {
        $this->top['competitors'] = $this->products->filter(function ($product) {
            return !$product->source->is_main && $product->difference < 0;
        })->take(5);
    }

    /*
     * Own Best Price Data Functions
     */

    public function getOwnBestPrices($user = null, $category_id, $string)
    {
        $this->productBindings = ProductBinding::all()->toArray();
        $this->user = $user ?: auth()->user();
        $this->setFilteredProducts($category_id, $string);
        $this->setDifference();
        return $this->setOwnBestPrices();
    }

    protected function setOwnBestPrices()
    {
        return $this->products->filter(function ($product) {
            $eq_percent = auth()->user()->equality_percent;
            return $product->source->is_main && $product->difference < (-$eq_percent);
        });
    }

    /*
     * Competitors Best Price Data Functions
     */

    public function getCompBestPrices($user = null, $category_id, $string)
    {
        $this->productBindings = ProductBinding::all()->toArray();
        $this->user = $user ?: auth()->user();
        $this->setFilteredProducts($category_id, $string);
        $this->setDifference();
        return $this->setCompBestPrices();
    }

    protected function setCompBestPrices()
    {
        return $this->products->filter(function ($product) {
            $eq_percent = auth()->user()->equality_percent;
            return !$product->source->is_main && $product->difference < (-$eq_percent);
        });
    }

    protected function setFilteredProducts($category_id, $string)
    {
        $query = $this->user->products()
            ->with('source')
            ->where(function ($q) {
                return $q->whereHas('mainBindings', function ($q) {
                    return $q->where('price', '>', 0)->where('vat_price', '>', 0);
                })->orWhereHas('bindings', function ($q) {
                    return $q->where('price', '>', 0)->where('vat_price', '>', 0);
                });
            })
            ->with('mainBindings.mainProduct')
            ->with('bindings.product.source')
            ->with('bindings.product.priceEntries')
            ->with('priceEntries')
            ->with(array('category' => function ($q) {
                $q->select('id', 'name');
            }));

        if ($string != '') {
            $query->where('name', 'like', '%' . $string . '%');
        }

        if ($category_id != '') {
            $query = $query->where('category_id', $category_id);

        }
        $this->products = $query->where('price', '>', 0)->where('vat_price', '>', 0)->get();
    }

}