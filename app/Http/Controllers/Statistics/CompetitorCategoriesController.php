<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Source;
use Illuminate\Support\Facades\Cache;

class CompetitorCategoriesController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = url()->full();
    }

    /**
     * Display statistics per category, per competitor
     *
     * @param Source $source
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index($sourceId)
    {
        $data = Cache::remember(auth()->user()->id . '.comp_cat.' . $this->url, 600, function () use ($sourceId) {
            $source = Source::where('id', (int)$sourceId)->with(['products' => function ($q) {
                return $q->has('mainBindings')->with('mainBindings.product', 'mainBindings.mainProduct')
                    ->where('price', '>', 0)
                    ->where('vat_price', '>', 0);
            }])->first();

            $categories = auth()->user()->categories->map(function ($category) use ($source) {
                $differenceData = $source->getProductsDifference($category->id, $source->products);
                $categoriesData = [
                    'average' => [
                        'value' => $differenceData['average'],
                        'colour' => getGradient($differenceData['average'], true)
                    ],
                ];

                foreach (['higher' => false, 'cheaper' => true, 'equal' => null, 'bindings' => null] as $type => $moreIsBetter) {
                    $categoriesData[$type] = [
                        'value' => $differenceData[$type],
                        'colour' => getGradient($differenceData[$type], $moreIsBetter),
                    ];
                }

                $category->data = $categoriesData;

                return $category;
            });
            return ['source' => $source, 'categories' => $categories];
        });

        return view('statistics.competitor-categories', [
            'competitor' => $data['source'],
            'categories' => $data['categories'],
        ]);
    }
}
