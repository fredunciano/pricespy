<?php

namespace App\Http\Controllers\Statistics;

use App\Category;
use App\Http\Controllers\Controller;
use App\ProductBinding;
use App\Source;
use Illuminate\Support\Facades\Cache;

class CategoryProductsController extends Controller
{
    /**
     * index function to display products w.r.t to categories and competitor
     *
     * @param Source $competitor
     * @param Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Source $competitor, Category $category)
    {
        $getProducts = Cache::remember(auth()->user()->id . '.category_products.' . url()->full(), 600, function () use ($competitor, $category) {
            $equalityPercentage = auth()->user()->equality_percent;
            $getProducts = ProductBinding::whereHas('product',
                function ($q) use ($competitor, $category) {
                    $q->where('source_id', $competitor->id);
                    $q->where('category_id', $category->id);
                })->with([
                'product' => function ($p) {
                    return $p->where('price', '>', 0)
                        ->where('vat_price', '>', 0);
                },
                'mainProduct' => function ($q) {
                    return $q->where('price', '>', 0)
                        ->where('vat_price', '>', 0);
                }])->get()->each(function ($getProduct) use ($equalityPercentage) {
                $difference = $getProduct->product->getDiffWith($getProduct->mainProduct);
                $diff = ($getProduct->product->amount * 100) - ($getProduct->mainProduct->amount * 100);
                $getProduct->difference = [
                    'myPrice' => $getProduct->mainProduct->amount * 100,
                    'shopPrice' => $getProduct->product->amount * 100,
                    'signed' => $diff,
                    'colour' => getGradientWithEqualityPercentage($difference, $getProduct, $equalityPercentage, false),
                ];
            });
            return $getProducts;
        });

        return view('statistics.products_categories', compact('getProducts'));
    }
}
