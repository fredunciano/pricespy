<?php

namespace App\Http\Controllers\Statistics;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Source;
use Illuminate\Support\Facades\Cache;

class CompetitorsController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = url()->full();
    }

    /**
     * Get the statistics for all competitors
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $competitors = Cache::remember(auth()->user()->id . '.stat_overview.' . $this->url, 600, function () {
            return auth()->user()->competitors()->with(['products' => function ($q) {
                return $q->has('mainBindings')->with('mainBindings.product', 'mainBindings.mainProduct')
                    ->where('price', '>', 0)
                    ->where('vat_price', '>', 0);
            }])->get()->each(function ($competitor) {
                $differenceData = $competitor->getProductsDifference(null, $competitor->products);
                $difference = [
                    'average' => [
                        'value' => $differenceData['average'],
                        'colour' => getGradient($differenceData['average'], true)
                    ],
                ];

                foreach (['higher' => false, 'cheaper' => true, 'equal' => null, 'bindings' => null] as $type => $moreIsBetter) {
                    $difference[$type] = [
                        'value' => $differenceData[$type],
                        'colour' => getGradient($differenceData[$type], $moreIsBetter),
                    ];
                }

                $competitor->difference = $difference;
            });
        });

        $competitorsPriceDifference = Source::where('is_main', 0)->where('user_id', auth()->user()->user_id)->get();
        $categoriesPriceDifference = auth()->user()->categories;
        $dataSet = $this->categoryPercentageDifference();
        return view('statistics.competitors', compact('competitors', 'competitorsPriceDifference', 'categoriesPriceDifference', 'dataSet'));
    }

    private function categoryPercentageDifference($param = false)
    {
        $dataSet = Cache::remember(auth()->user()->id . '.category_percentage_diff.' . $this->url, 600, function () {
            $clientCategoryAvgPrices = Product::where('source_id', auth()->user()->user_source_id)
                ->groupBy('category_id')
                ->selectRaw('avg(price) as avg, category_id')
                ->lists('avg', 'category_id');
            $competitorCategoryAvgPrices = Product::where('source_id', '!=', auth()->user()->user_source_id)->groupBy('category_id')
                ->where('price', '>', 0)
                ->where('vat_price', '>', 0)
                ->selectRaw('avg(price) as avg, category_id')
                ->lists('avg', 'category_id');
            $dataSet = [];
            $categories = Category::whereHas('products')->get();
            foreach ($categories as $category) {
                if (isset($clientCategoryAvgPrices[$category->id]) && isset($competitorCategoryAvgPrices[$category->id])) {
                    $clientAvg = $clientCategoryAvgPrices[$category->id];
                    $compAvg = $competitorCategoryAvgPrices[$category->id];
                    $cheaper = $clientAvg < $compAvg ? true : false;
                    $diff = (($clientAvg - $compAvg) / $clientAvg) * 100;
                    $data = ['name' => $category->name, 'value' => abs(round($diff, 2)), 'cheaper' => $cheaper];
                    array_push($dataSet, $data);
                }
            }
            return $dataSet;
        });
        if ($param) {
            return $dataSet;
        }

        $dataSet = json_encode($dataSet);
        return $dataSet;
    }
}
