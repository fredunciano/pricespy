<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Source;
use Illuminate\Http\Request;

class SelectorProductsController extends Controller
{

    public function index(Request $request, Source $competitor)
    {
        $term = trim($request->q);

        $bound = empty($request->bound) ? null : explode(',', $request->bound);

        $productsData = $competitor->products()
            ->when($bound, function($query) use ($bound) {
                return $query->whereNotIn('id', $bound);
            })
            ->when(empty($term), function($query) {
                return $query->orderBy('name', 'asc');
            })
            ->where('name', 'like', '%' . $term . '%')->limit(5)->get();

        $products = [];

        foreach ($productsData as $product) {
            $products[] = ['id' => $product->id, 'text' => $product->name];
        }

        return \Response::json($products);
    }
}
