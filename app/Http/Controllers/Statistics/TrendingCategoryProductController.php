<?php

namespace App\Http\Controllers\Statistics;

use App\Category;
use App\Http\Controllers\Controller;
use App\ProductBinding;
use Illuminate\Support\Facades\Cache;

class TrendingCategoryProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get()
    {

        $productCategories = Cache::remember(auth()->user()->id . '.fetchCategories.' . url()->full(), 600, function () {
            $productBindings = ProductBinding::whereHas('mainProduct', function ($q) {
                $q->where('source_id', auth()->user()->user_source_id)
                    ->where('price', '>', 0)
                    ->where('vat_price', '>', 0);
            })->with('mainProduct.category', 'product')->get();
            $productCategories = $productBindings->mapToGroups(function ($productBinding) {
                $difference = $productBinding->mainProduc ? $productBinding->product->getDiffWith($productBinding->mainProduct) : 0;
                return [
                    $productBinding->mainProduct->category->name => [
                        'percentage_diff' => $productBinding->percentage_difference,
                        'price_diff' => $productBinding->price_difference,
                        "category_id" => $productBinding->mainProduct->category->id,
                        "color" => gradientForAvgCategories($difference)
                    ]
                ];
            });
            return $productCategories;
        });
        return view("statistics.bestPerformingCategories", compact('productCategories'));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProducts(Category $category)
    {

        $getProducts = Cache::remember(auth()->user()->id . '.getProducts.' . url()->full(), 600, function () use ($category) {
            $equalityPercentage = auth()->user()->equality_percent;
            $getProducts = ProductBinding::whereHas('product',
                function ($q) use ($category) {
                    $q->where('category_id', $category->id)
                        ->where('price', '>', 0)
                        ->where('vat_price', '>', 0);
                })->with(['product', 'mainProduct'])->get()->each(function ($getProduct) use ($equalityPercentage) {
                $difference = $getProduct->product->getDiffWith($getProduct->mainProduct);
                $getProduct->difference = [
                    'signed' => $getProduct->product->price - $getProduct->mainProduct->price,
                    'colour' => getGradientWithEqualityPercentage($difference, $getProduct, $equalityPercentage, false),
                ];
            });
            return $getProducts;
        });
        return view('statistics.category_products_statistics', compact('getProducts'));
    }
}
