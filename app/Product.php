<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Product extends Model
{
    use Eloquence;

    protected $searchableColumns = ['name'];

    protected $fillable = [
        'name', 'description', 'brand', 'category_id', 'price', 'vat_price', 'min_price', 'max_price',
        'shipping_cost', 'purchase_price', 'vat_max_price', 'original_price_string',
        'range_min_price', 'range_max_price', 'amount_with_prices',
        'link', 'is_actual', 'user_id', 'fetched_at', 'is_manual', 'source_id', 'is_watched', 'image', 'sp_data',
        'manual_override', 'origin',
    ];

    public static $validation = [
        'name' => 'required|max:1000',
        'source_id' => 'required',
        'category_id' => 'required',
        'price' => 'required|between:0,999999',
        'min_price' => 'nullable|between:0,999999',
        'max_price' => 'nullable|between:0,999999|gt:min_price',
        'shipping_cost' => 'nullable|between:0,999999',
        'purchase_price' => 'nullable|between:0,999999',
        'link' => 'max:1000',
        'image' => 'nullable|image|max:2000'
    ];

    protected $casts = [
        'sp_data' => 'array',
    ];

    protected $dates = ['fetched_at'];

    public static function add($data)
    {
        return auth()->user()->products()->create(array_merge($data, [
            'user_id' => auth()->user()->user_id,
            'origin' => 'manual',
            'is_manual' => 1,
            'fetched_at' => Carbon::now(),
            'manual_override' => request()->has('manual_override'),
        ]));
    }

    public static function validateAndSetErrors($data)
    {
        $errors = [];

        if ($data['source_id'] == null && $data['source_id'] == '') {
            array_push($errors, 'store_not_found');
        }
        if ($data['category_id'] == null && $data['category_id'] == '') {
            array_push($errors, 'category_not_found');
        }
        if ($data['name'] == null && $data['name'] == '') {
            array_push($errors, 'product_required');
        }
        if ($data['product_name_exist'] == true) {
            array_push($errors, 'product_name_exist');
        }
        if ($data['price'] == null && $data['price'] == '') {
            array_push($errors, 'price_required');
        }
        if ($data['vat_price'] != null && $data['vat_price'] != '' && ($data['system_calculated_vat_price'] != $data['vat_price'])) {
            array_push($errors, 'product_gross_price_wrong');
        }
        if ($data['link'] != null && $data['link'] != '') {
            filter_var($data['link'], FILTER_VALIDATE_URL) === FALSE ? array_push($errors, 'invalid_url') : false;
        }
        if ($data['min_price'] != null && $data['min_price'] != '' && $data['max_price'] != null && $data['max_price'] != '') {
            $data['min_price'] >= $data['max_price'] ? array_push($errors, 'max_price_must_be_greater') : false;
        }

        if (count($errors) > 0) {
            $data['errors'] = $errors;
            return $data;
        } else {
            return true;
        }
    }

    public static function addFromCsv($data)
    {
        return Product::create([
            'source_id' => $data['source_id'],
            'user_id' => $data['user_id'],
            'category_id' => $data['category_id'],
            'origin' => $data['origin'],
            'name' => $data['name'],
            'price' => $data['price'],
            'vat_price' => $data['vat_price'],
            'min_price' => $data['min_price'],
            'max_price' => $data['max_price'],
            'purchase_price' => $data['purchase_price'],
            'shipping_cost' => $data['shipping_cost'],
            'link' => $data['link'],
            'is_manual' => $data['is_manual'],
            'manual_override' => $data['manual_override'],
            'fetched_at' => Carbon::now(),
        ]);
    }

    public static function validateProductImportHeaderRow($headings, $shopType, $update = false)
    {
        $hasError = false;
        $priceFeedHeader = ['store', 'category', 'name', 'netto', 'brutto', 'min_price', 'max_price', 'purchase_price', 'shipping_cost', 'link', 'manual_override'];
        $magento2Header = ['categories', 'name', 'price'];
        $bigCommerceHeader = ['Product Name', 'Category', 'Price'];
        $openCart = ['name', 'category', 'price'];
        $prestaShopHeader = ['Name*', 'Categories (x,y,z,...)', 'Price tax excl. Or Price tax excl'];
        $shopifyHeader = ['Handle', 'Type', 'Variant Price'];
        $shopWareHeader = ['name', 'price_EK', 'categories'];

        switch ($shopType) {
            case 1:
                if ($update) {
                    $priceFeedHeader = ['Store', 'Category', 'Product Id', 'Product Name', 'Netto', 'Brutto'];
                    $headings != array_intersect($priceFeedHeader, $headings) ? $hasError = true : $hasError = false;
                } else {
                    $priceFeedHeader != array_intersect($priceFeedHeader, $headings) ? $hasError = true : $hasError = false;
                }
                break;
            case 2:
                $magento2Header != array_intersect($magento2Header, $headings) ? $hasError = true : $hasError = false;
                break;
            case 3:
                $bigCommerceHeader != array_intersect($bigCommerceHeader, $headings) ? $hasError = true : $hasError = false;
                break;
            case 4:
                $openCart != array_intersect($openCart, $headings) ? $hasError = true : $hasError = false;
                break;
            case 5:
                $prestaShopHeader != array_intersect($prestaShopHeader, $headings) ? $hasError = true : $hasError = false;
                break;
            case 6:
                $shopifyHeader != array_intersect($shopifyHeader, $headings) ? $hasError = true : $hasError = false;
                break;
            case 7:
                $shopWareHeader != array_intersect($shopWareHeader, $headings) ? $hasError = true : $hasError = false;
                break;
        }

        return $hasError;
    }

    public static function validatePriceUpdateHeaderRow($headings)
    {
        $hasError = false;
        $solutionType = null;
        $solution1Heading = ['store', 'category', 'product_id', 'product_name', 'netto', 'brutto'];
        $solution2Heading = ['store', 'category', 'name', 'netto', 'brutto', 'min_price', 'max_price', 'purchase_price', 'shipping_cost', 'link', 'manual_override'];
        if ($headings == array_intersect($headings, $solution1Heading)) {
            $solutionType = 1;
        } elseif ($headings == array_intersect($headings, $solution2Heading)) {
            $solutionType = 2;
        } else {
            $hasError = true;
        }
        return ['hasError' => $hasError, 'solutionType' => $solutionType];
    }

    public static function validateUpdatePriceDataRequest($data)
    {
        $validate = false;
        $errors = [];
        if ($data['source_id'] == null && $data['source_id'] == '') {
            array_push($errors, 'store_not_found');
        }
        if ($data['vat_price'] != null && $data['vat_price'] != '' && ((int)$data['system_calculated_vat_price'] != (int)$data['vat_price'])) {
            array_push($errors, 'product_gross_price_wrong');
        }
        if ($data['category_id'] == null) {
            array_push($errors, 'category_not_found');
        }
        if ($data['product_id'] == null) {
            array_push($errors, 'product_does_not_exist');
        }
        if (count($errors) == 0) {
            $data['success'] = true;
            $validate = true;
        } else {
            $data['success'] = false;
            $data['errors'] = $errors;
        }
        if (!session()->exists('bulkPriceUpdate')) {
            $productArray = [];
        } else {
            $productArray = json_decode(session()->get('bulkPriceUpdate'));
            session()->forget('bulkPriceUpdate');
        }
        array_push($productArray, $data);
        return $validate;
    }

    public static function updatePrice($data)
    {
        $endDateTime = Carbon::now();
        $startDateTime = Carbon::now()->subHour(24);
        $exists = ProductPriceEntry::where(['product_id' => $data['product_id']])->whereBetween('fetched_at', [$startDateTime, $endDateTime])->first();
        if (!$exists) {
            $new = new ProductPriceEntry();
            $new->product_id = $data['product_id'];
            $new->price = $data['price'];
            $new->vat_price = $data['vat_price'];
            $new->fetched_at = $endDateTime;
            $new->save();
        }
        $product = self::find($data['product_id']);
        $product->price = $data['price'];
        $product->vat_price = $data['vat_price'];
        $product->fetched_at = $endDateTime;
        $product->save();
        return true;
    }

    public function modify($data)
    {
        return $this->update(array_merge($data, [
            'manual_override' => request()->has('manual_override'),
        ]));
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function bindings()
    {
        return $this->hasMany(ProductBinding::class, 'main_product_id');
    }

    public function mainBindings()
    {
        return $this->hasMany(ProductBinding::class, 'bound_product_id');
    }

    public function competitors()
    {
        return $this->hasManyThrough(Product::class, ProductBinding::class, 'main_product_id', 'id', 'id', 'bound_product_id');
    }

    public function showPrice()
    {
        return $this->amount ? formatMoney($this->amount * 100) : '-';
    }

    public function showMinPrice()
    {
        return $this->range_min_price ? formatMoney(($this->range_min_price)) : '-';
    }

    public function showPriceRange()
    {
        $activePrice = $this->getAmountAttribute() * 100;

        if ($this->range_min_price && ($this->range_min_price != $activePrice)) {
            if (auth()->user()->after_tax_prices && $this->source->netto == 1) {
                $minPrice = $this->range_min_price * 1.19;
            } else if (auth()->user()->after_tax_prices == false && $this->source->netto == 0) {
                $minPrice = $this->range_min_price / 1.19;
            } else {
                $minPrice = $this->range_min_price;
            }
            if ($minPrice != $activePrice) {
                return formatMoney($minPrice) . ' - ' . formatMoney($activePrice);
            } else {
                return formatMoney($activePrice);
            }
        } elseif ($activePrice == 0) {
            return '-';
        } else {
            return formatMoney($activePrice);
        }
    }

    public function showMaxPrice()
    {
        return formatMoney($this->max_amount * 100);
    }

    public function priceOptions()
    {
        return $this->hasMany(ProductPriceOption::class);
    }

    public function hasRangedPrice()
    {
        return !empty($this->max_price);
    }

    public function isBetterOnAverage($competitors)
    {
        return $this->getPricesDifferenceValue($competitors) < auth()->user()->getCheapnessBorder();
    }

    public function isWorseOnAverage($competitors)
    {
        return $this->getPricesDifferenceValue($competitors) > auth()->user()->getExpensivenessBorder();
    }

    public function isEqualOnAverage($competitors)
    {
        $difference = $this->getPricesDifferenceValue($competitors);
        return $difference <= auth()->user()->getExpensivenessBorder() && $difference >= auth()->user()->getCheapnessBorder();
    }

    private function getPricesDifferenceValue($competitors)
    {
        return $this->price ? $competitors->map(function ($competitor) {
            return $competitor->price / $this->price;
        })->avg() : 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function priceEntries()
    {
        return $this->hasMany(ProductPriceEntry::class);
    }

    /**
     * As we use to get multiple entries for price of a particular product,
     * with using this fetching recent data will be easy .
     * We use this relationship for getting recent trends in competitor's products.
     *
     * Price Entry (Has One)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function priceEntry()
    {
        return $this->hasOne(ProductPriceEntry::class);
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (int)($value * 100);
    }

    public function getPriceAttribute($value)
    {
        return (float)$value / 100;
    }

    public function setVatPriceAttribute($value)
    {
        $this->attributes['vat_price'] = (int)($value * 100);
    }

    public function getVatPriceAttribute($value)
    {
        return (float)$value / 100;
    }

    public function setMinPriceAttribute($value)
    {
        $this->attributes['min_price'] = $value ? (int)($value * 100) : null;
    }

    public function getMinPriceAttribute($value)
    {
        return $value ? (float)$value / 100 : null;
    }

    public function setMaxPriceAttribute($value)
    {
        $this->attributes['max_price'] = $value ? (int)($value * 100) : null;
    }

    public function getMaxPriceAttribute($value)
    {
        return $value ? (float)$value / 100 : null;
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

    public function setShippingCostAttribute($value)
    {
        $this->attributes['shipping_cost'] = $value ? (int)($value * 100) : null;
    }

    public function getShippingCostAttribute($value)
    {
        return $value ? (float)$value / 100 : null;
    }

    public function setPurchasePriceAttribute($value)
    {
        $this->attributes['purchase_price'] = $value ? (int)($value * 100) : null;
    }

    public function getPurchasePriceAttribute($value)
    {
        return $value ? (float)$value / 100 : null;
    }


    public function getEditRoute()
    {
        return route($this->source->is_main ? 'products.edit' : 'competitors.products.edit', $this);
    }

    public function getAmountAttribute()
    {
        return auth()->user()->after_tax_prices ? (float)($this->vat_price / 100) : (float)($this->price / 100);
    }

    public function getMaxAmountAttribute()
    {
        return auth()->user()->after_tax_prices ? $this->vat_max_price : $this->max_price;
    }

    public function getDiffWith($product)
    {
        $difference = $product->amount ? (1 - ($this->amount * 100) / ($product->amount * 100)) * 100 : 0;

        return number_format($difference, 2);
    }

    /**
     * Prepare the product price history and return in the format expected by the charts
     *
     * @return array
     */

    public function getHistory()
    {
        $products = Product::whereHas('mainBindings', function ($q) {
            return $q->where('main_product_id', $this->id);
        })->with(['priceEntries' => function ($q) {
            if (request()->has('from')) {
                $from = Carbon::parse(request('from'))->format('Y-m-d');
                $to = Carbon::parse(request('to'))->format('Y-m-d');
                return $q->whereDate('fetched_at', '>=', $from)->whereDate('fetched_at', '<=', $to);
            } else {
                return $q->whereDate('fetched_at', '>', Carbon::today()->subDays(30));
            }
        }])->with('source:id,name,is_main')->orWhere('id', $this->id)->get();

        $labels = $this->getUniqueLabels($products);
        $dates = array_keys($labels);
        $dates = count($dates) ? generateDatesWithInterval($dates) : [];
        $data = $products->map(function ($product, $index) use ($dates, $labels) {
            $data = $labels;
            $product->priceEntries->each(function ($entry) use (&$data) {
                $data[$entry->fetched_at->format('d.m.Y')] = $entry->amount * 100;
            });
            $prices = [];
            foreach ($dates as $date) {
                isset($data[$date]) ? array_push($prices, $data[$date]) : array_push($prices, null);
            }
            $randomColour = str_replace(')', ',', hex2rgba('#3B73B9'));

            $dataset = array_filter(array_values($data), function ($a) {
                return $a !== null;
            });
            $min = count($dataset) > 0 ? min($dataset) - 20 : 0;
            $max = count($dataset) > 0 ? max($dataset) + 20 : 0;
            return [
                'label' => $product->source->name . ': ' . $product->name,
                'fill' => false,
                'showLine' => false,
                'data' => array_values($prices),
                'isMain' => $product->source->is_main ? true : false,
                'backgroundColor' => $product->source->is_main ? 'rgba(0, 200, 150, 1)' : $randomColour . '1)',
                'borderColor' => $product->source->is_main ? 'rgba(0, 200, 150, 1)' : $randomColour . '1)',
                'pointBackgroundColor' => 'rgba(255,105,180,1)',
                'pointBorderColor' => 'rgba(255,105,180,1)',
                'hoverColor' => 'rgba(255,105,180,1)',
                'trendLineData' => calculateTrendLine(array_values($data)),
                'min' => $this->setValue($min, true),
                'max' => $this->setValue($max, false)
            ];
        })->toArray();

        $min = 0;
        $max = 0;
        foreach ($data as $product) {
            if ($product['min'] < $min || $min == 0) {
                $min = $product['min'];
            }
            if ($product['max'] > $max) {
                $max = $product['max'];
            }
        }
        return [
            'labels' => collect($dates)->map(function ($date) {
                return Carbon::parse($date)->format('d.m.y');
            })->values()->toArray(),
            'datasets' => $data,
            'min' => $min > 0 ? ceil($min / 10) * 10 : -5,
            'max' => ceil($max / 10) * 10,
        ];
    }

    public function setValue($val, $isMin = false)
    {
        if ($val < 100) {
            if ($isMin) {
                return $val - 5;
            } else {
                return $val + 5;
            }
        } elseif ($val < 500) {
            if ($isMin) {
                return $val - 15;
            } else {
                return $val + 15;
            }
        } else {
            if ($isMin) {
                return $val - 20;
            } else {
                return $val + 20;
            }
        }
    }


    /**
     * Get the labels for the product price entries required for the charts legend
     *
     * @param $products
     * @return array
     */

    protected function getUniqueLabels($products)
    {
        $labels = [];

        $products->map(function ($product) use (&$labels) {
            return $product->priceEntries->each(function ($entry) use (&$labels) {
                $labels[$entry->fetched_at->format('U')] = $entry->fetched_at->format('d.m.Y');
            });
        });

        ksort($labels);

        return array_fill_keys(array_unique($labels), null);
    }

    public static function laratablesCustomActions($product)
    {
        return self::getDatatablesField($product->id, 'actions');
    }

    public static function laratablesCustomAmount($product)
    {
        return self::getDatatablesField($product->id, 'amount');
    }

    public static function laratablesCustomLink($product)
    {
        return self::getDatatablesField($product->id, 'link');
    }

    public static function laratablesCustomLinkedName($product)
    {
        return self::getDatatablesField($product->id, 'linked-name');
    }

    public static function laratablesCustomName($product)
    {
        return self::getDatatablesField($product->id, 'name');
    }

    public static function laratablesCustomImage($product)
    {
        return self::getDatatablesField($product->id, 'image');
    }

    public static function laratablesCustomCategoryId($product)
    {
        return self::getDatatablesField($product->id, 'category');
    }

    public static function laratablesCustomFetchedAt($product)
    {
        return self::getDatatablesField($product->id, 'fetched-at');
    }

    private static function getDatatablesField($id, $field)
    {
        return view('products.datatables.' . $field, [
            'product' => self::find($id),
        ])->render();
    }

    public static function laratablesQueryConditions($query)
    {
        $userId = auth()->user()->user_id;
        return $query->where('user_id', $userId)->whereHas('source', function ($q) {
            if (request()->has('s')) {
                $q->where('id', request()->get('s'));
            }
        });
    }

    public static function laratablesOrderRawAmount($direction)
    {
        return auth()->user()->after_tax_prices ? 'vat_price ' . $direction : 'price ' . $direction;
    }

    public static function laratablesOrderRawFetchedAt($direction)
    {
        return 'fetched_at ' . $direction;
    }

    public static function laratablesOrderRawName($direction)
    {
        return 'name ' . $direction;
    }

    public static function laratablesOrderRawLinkedName($direction)
    {
        return 'name ' . $direction;
    }

    public function getPercentageDifferenceAttribute()
    {
        $this->bindings->avg('difference');
    }

    public function getPriceRangeAttribute()
    {
        return $this->showPriceRange();
    }

    protected $appends = ['amount', 'price_range'];

    public function formattedQuantityDiscount()
    {
        $activePrice = $this->getAmountAttribute() * 100;
        if ($this->amount_with_prices == null) {
            return [];
        }
        $amounts = array_keys($this->amount_with_prices);
        $prices = array_values($this->amount_with_prices);
        $discount_prices = [];
        foreach ($prices as $i => $price) {
            $amount = isset($amounts[$i]) ? $amounts[$i] : null;
            $discount = round((($price - $activePrice) / $activePrice) * 100, 2);
            $data = [
                'amount' => $amount,
                'price' => formatMoney($price),
                'discount' => $discount
            ];
            if ($amount) {
                array_push($discount_prices, $data);
            }
        }
        return $discount_prices;
    }

}
