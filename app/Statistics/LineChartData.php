<?php

namespace App\Statistics;

use App\Category;
use App\Product;
use App\Source;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class LineChartData extends Model
{
    protected $labelType = 'last_7_days';
    protected $borderWidth = 4;
    protected $fill = false;
    protected $pointRadius = 3;
    protected $categories;
    protected $competitorId = '';
    protected $mainSourceId = '';
    protected $yearOverlap = false;
    protected $products;
    protected $min;
    protected $max;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->categoryId = request()->get('lineCategory', '');
        $this->categories = $this->setCategories($this->categoryId);
        $this->competitorId = request()->get('lineCompetitor', '');
        $this->labelType = request()->get('categoryAveragePriceChartType', 'last_7_days');
        $this->mainSourceId = $sourceId = auth()->user()->user_source_id;
        $products = Product::with('priceEntries')
            ->where('user_id', auth()->user()->user_id)
            ->select('id', 'name', 'price', 'vat_price', 'category_id', 'source_id', 'user_id')
            ->where('price', '>', 0)
            ->where('vat_price', '>', 0);

        if ($this->categoryId != '') {
            $products = $products->where('category_id', $this->categoryId);
        }

        if ($this->competitorId != '' && $this->mainSourceId != null) {
            $products = $products->whereIn('source_id', [$this->mainSourceId, $this->competitorId]);
        } elseif ($this->competitorId != '' && $this->mainSourceId == null) {
            $products = $products->where('source_id', $this->competitorId);
        }
        $this->products = $products->get()->toArray();
    }

    public function get()
    {
        $data = [
            'labels' => $this->setXAxisLabels(),
            'datasets' => $this->mergeDataSet(),
            'min' => $this->min < 0 ? 0 : $this->min,
            'max' => $this->max,
            'yearOverlap' => $this->yearOverlap
        ];

        return $data;
    }

    public function setXAxisLabels()
    {
        $type = $this->labelType;
        $labels = [];
        if ($type == 'last_7_days') {
            for ($i = 7; $i > 0; $i--) {
                $date = date('d.m.Y', strtotime("-$i days"));
                if (date('Y', strtotime($date)) != date('Y')) {
                    $this->yearOverlap = true;
                }
                array_push($labels, $date);
            }
        } else if ($type == 'last_30_days') {
            for ($i = 30; $i > 0; $i -= 2) {
                $date = date('d.m.Y', strtotime("-$i days"));
                if (date('Y', strtotime($date)) != date('Y')) {
                    $this->yearOverlap = true;
                }
                array_push($labels, $date);
            }
        } else {
            for ($i = 365; $i > 0; $i -= 30) {
                $date = date('d.m.Y', strtotime("-$i days"));
                if (date('Y', strtotime($date)) != date('Y')) {
                    $this->yearOverlap = true;
                }
                array_push($labels, $date);
            }
        }

        return $labels;
    }

    public function dateSort($a, $b)
    {
        return strtotime($a) - strtotime($b);
    }

    public function setCategories($categoryId)
    {
        if ($categoryId != '') {
            $categories = Category::whereHas('products')->where('id', $categoryId)->where('user_id', auth()->user()->user_id)->get();
        } else {
            $categories = Category::whereHas('products')->where('user_id', auth()->user()->user_id)->orderBy('id', 'asc')->limit(1)->get();
            $this->categoryId = $categories->first() ? $categories->first()->id : null;
        }
        return $categories;
    }

    public function returnActiveProductPrice($product, $date)
    {
        $activePrice = $product['price_entries'] ? collect($product['price_entries'])->where('fetched_at', '<=', Carbon::parse($date))->first()['amount'] : null;
        if ($activePrice == null) {
            $activePrice = $product['amount'];
        }
        return isset($activePrice) ? $activePrice * 100 : null;
    }

    public function returnAvgPrice($products, $date)
    {
        $prices = [];
        foreach ($products as $product) {
            $price = $this->returnActiveProductPrice($product, $date);
            isset($price) ? array_push($prices, $price) : null;
        }
        if (count($prices) > 0) {
            $avg = array_sum($prices) / count($prices);
        } else {
            $avg = 0;
        }
        return round($avg, 2);
    }

    public function clientsAvgPriceByCategory()
    {
        $data = [];
        $sourceId = $this->mainSourceId;
        $totalProduct = collect($this->products)->filter(function ($p) use ($sourceId) {
            return $p['source_id'] = $sourceId;
        })->count();
        if ($totalProduct == 0) {
            return $data;
        }
        $labels = $this->setXAxisLabels();
        $categories = $this->categories;
        foreach ($categories as $category) {
            $products = collect($this->products)->where('source_id', '=', $sourceId)
                ->where('category_id', $category->id);

            $avgPriceSet = [];
            foreach ($labels as $date) {
                $avg = $this->returnAvgPrice($products, $date);
                array_push($avgPriceSet, $avg);
            }
            $this->min = $this->min > min($avgPriceSet) || $this->min == null ? min($avgPriceSet) : $this->min;
            $this->max = $this->max < max($avgPriceSet) || $this->max == null ? max($avgPriceSet) : $this->max;

            $color = '#' . $this->randomColor(count($data), $reverse = 0);
            $set = [
                "label" => t('my_shop') . ": $category->name",
                'data' => $avgPriceSet,
                'borderWidth' => $this->borderWidth,
                'pointBorderColor' => $color,
                'pointBackgroundColor' => $color,
                'borderColor' => $color,
                'fill' => $this->fill,
                'pointRadius' => $this->pointRadius
            ];
            array_push($data, $set);
        }
        return $data;
    }

    public function competitorsAvgPriceByCategory()
    {
        $data = [];
        if (auth()->user()->competitors->count() == 0) {
            return $data;
        }
        $sourceId = $this->competitorId;

        $labels = $this->setXAxisLabels();
        $categories = $this->categories;

        foreach ($categories as $category) {
            if ($sourceId == '') {
                $products = collect($this->products)->where('source_id', '!=', $this->mainSourceId)
                    ->where('category_id', $category->id);
            } else {
                $products = collect($this->products)->where('source_id', '=', $sourceId)
                    ->where('category_id', $category->id);
            }

            $avgPriceSet = [];
            foreach ($labels as $label) {
                $avg = $this->returnAvgPrice($products, $label);
                array_push($avgPriceSet, $avg);
            }

            $this->min = $this->min > min($avgPriceSet) || $this->min == null ? min($avgPriceSet) : $this->min;
            $this->max = $this->max < max($avgPriceSet) || $this->max == null ? max($avgPriceSet) : $this->max;

            $color = '#' . $this->randomColor(count($data), $revers = 1);
            $set = [
                "label" => t('stores') . ": $category->name",
                'data' => $avgPriceSet,
                'borderWidth' => $this->borderWidth,
                'pointBorderColor' => $color,
                'pointBackgroundColor' => $color,
                'borderColor' => $color,
                'fill' => $this->fill,
                'pointRadius' => $this->pointRadius
            ];
            array_push($data, $set);
        }


        return $data;
    }

    public function mergeDataSet()
    {
        $datasets = array_merge($this->clientsAvgPriceByCategory(), $this->competitorsAvgPriceByCategory());
        $updatedDatasets = [];
        $categories = $this->categories;
        foreach ($categories as $category) {
            foreach ($datasets as $dataset) {
                if (strpos($dataset['label'], $category->name) != false) {
                    array_push($updatedDatasets, $dataset);
                }
            }
        }
        $this->setMinMaxValue();
        return $updatedDatasets;
    }

    public function setMinMaxValue()
    {
        $min = $this->min;
        $max = $this->max;
        $diff = $max - $min;
        $this->min = ceil((($min - $diff - 50) / 10) * 10);
        $this->max = ceil((($max + $diff + 50) / 10) * 10);
    }

    public function randomColorPart()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public function randomColor($index, $reverse)
    {
        $set = ['ff6a4d', 'fe4d67', 'ff4d6a', '385ea2', '2ea8cf', 'd5c8e4', 'a98ec1', 'f6b6aa', 'fd684a', 'fca4b0', 'fe4d67', '83ffdc',
            '0081ff', 'ffab00', '7dbeff', '38cfa2', '9500ff', '008e56', '3876a2'
        ];
        if ($reverse) {
            return isset(array_reverse($set)[$index]) ? array_reverse($set)[$index] : array_rand($set);
        }
        return isset($set[$index]) ? $set[$index] : array_rand($set);
    }

    /*
     * EXPORT DATA TO CSV/EXCEL Functions
     */

    public function getExportData()
    {
        $dates = $this->setXAxisLabels();
        $categoryId = request()->get('lineCategory', '');
        $categories = $this->setCategories($categoryId);
        $sourceId = Source::where(['user_id' => auth()->user()->user_id, 'is_main' => 1])->value('id');
        $headings = ['Date'];
        $rowsData = [];

        $clientProducts = [];
        $compProducts = [];
        foreach ($dates as $date) {
            $rowData = [$date];

            foreach ($categories as $key => $category) {
                if (!isset($clientProducts[$key])) {
                    $cProducts = collect($this->products)->where('source_id', '=', $sourceId)
                        ->where('category_id', $category->id);
                    array_push($clientProducts, $cProducts);
                }

                $clientAvg = $this->returnAvgPrice($clientProducts[$key], $date);
                array_push($rowData, $clientAvg * 100);

                $headingName = 'My Shop: ' . $category->name;
                if (!in_array($headingName, $headings)) {
                    array_push($headings, $headingName);
                }

                if (!isset($compProducts[$key])) {
                    $compId = $this->competitorId;
                    if ($compId == '') {
                        $cmpProducts = collect($this->products)->where('source_id', '!=', $sourceId)
                            ->where('category_id', $category->id);
                    } else {
                        $cmpProducts = collect($this->products)->where('source_id', '=', $sourceId)
                            ->where('category_id', $category->id);
                    }
                    array_push($compProducts, $cmpProducts);
                }

                $compAvg = $this->returnAvgPrice($compProducts[$key], $date);
                array_push($rowData, $compAvg * 100);

                $headingName = 'Competitor: ' . $category->name;
                if (!in_array($headingName, $headings)) {
                    array_push($headings, $headingName);
                }
            }
            array_push($rowsData, $rowData);
        }

        $finalData = [];

        array_push($finalData, [null]);
        array_push($finalData, ['A Table Comparing My Shop\'s Average Price per Category Compared to the Average Price Offered by the Competitors']);
        array_push($finalData, [date('d.m.Y')]);
        array_push($finalData, [null]);

        array_push($finalData, $headings);
        foreach ($rowsData as $item) {
            array_push($finalData, $item);
        }

        return ['headings' => ['Category Price Comparison Report'], 'rowsData' => $finalData];
    }

    /*
     * EXPORT DATA TO CSV/EXCEL Functions
     */

    public function getExportDataForPdf()
    {
        $dates = $this->setXAxisLabels();
        $categoryId = request()->get('lineCategory', '');
        $categories = $this->setCategories($categoryId);
        $sourceId = Source::where(['user_id' => auth()->user()->user_id, 'is_main' => 1])->value('id');
        $headings = ['Date'];
        $rowsData = [];

        $clientProducts = [];
        $compProducts = [];
        foreach ($dates as $date) {
            $rowData = [$date];
            foreach ($categories as $key => $category) {
                if (!isset($clientProducts[$key])) {
                    $cProducts = collect($this->products)->where('source_id', '=', $sourceId)
                        ->where('category_id', $category->id);
                    array_push($clientProducts, $cProducts);
                }
                $clientAvg = $this->returnAvgPrice($clientProducts[$key], $date);
                array_push($rowData, $clientAvg * 100);
                $headingName = 'My Shop: ' . $category->name;
                if (!in_array($headingName, $headings)) {
                    array_push($headings, $headingName);
                }
                if (!isset($compProducts[$key])) {
                    $compId = $this->competitorId;
                    if ($compId == '') {
                        $cmpProducts = collect($this->products)->where('source_id', '!=', $sourceId)
                            ->where('category_id', $category->id);
                    } else {
                        $cmpProducts = collect($this->products)->where('source_id', '=', $sourceId)
                            ->where('category_id', $category->id);
                    }
                    array_push($compProducts, $cmpProducts);
                }
                $compAvg = $this->returnAvgPrice($compProducts[$key], $date);
                array_push($rowData, $compAvg * 100);
                $headingName = 'Competitor: ' . $category->name;
                if (!in_array($headingName, $headings)) {
                    array_push($headings, $headingName);
                }
            }
            array_push($rowsData, $rowData);
        }

        return ['headings' => $headings, 'rowsData' => $rowsData];
    }
}