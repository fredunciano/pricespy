<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class HistoryController extends Controller
{

    /**
     * Show the product price history
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function show(Product $product)
    {
        if (!$product->source->is_main) {
            abort(404);
        }

        $chartData = json_encode($product->getHistory());

        return view('products.history', compact('chartData'));
    }

}
