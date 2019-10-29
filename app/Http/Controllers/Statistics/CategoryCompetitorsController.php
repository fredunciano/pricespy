<?php

namespace App\Http\Controllers\Statistics;

use App\Category;
use App\Http\Controllers\Controller;
use App\Source;

class CategoryCompetitorsController extends Controller
{
    /**
     * Display per category statistics
     *
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index(Category $category)
    {
        $competitors = Source::where('user_id', auth()->user()->user_id)->where('is_main', 0)->with(['products' => function ($q) {
            return $q->where('price', '>', 0)
                ->where('vat_price', '>', 0);
        }])->get()->map(function ($competitor) use ($category) {
            $differenceData = $competitor->getProductsDifference($category->id, $competitor->products);

            $categoriesData = [
                'average' => [
                    'rawValue' => $differenceData['average'],
                    'value' => showVisualDifference($differenceData['average'], true),
                    'colour' => getGradient($differenceData['average'], true)
                ],
            ];

            foreach (['higher' => false, 'cheaper' => true, 'equal' => null, 'bindings' => null] as $type => $moreIsBetter) {
                $categoriesData[$type] = [
                    'value' => $differenceData[$type],
                    'colour' => getGradient($differenceData[$type], $moreIsBetter),
                ];
            }
            return [
                'data' => $categoriesData,
                'competitor' => $competitor,
            ];
        });

        return view('statistics.category-competitors', compact('competitors',  'category'));
    }
}
