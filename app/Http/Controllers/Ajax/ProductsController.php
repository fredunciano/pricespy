<?php

namespace App\Http\Controllers\Ajax;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Freshbitsweb\Laratables\Laratables;

class ProductsController extends Controller
{
    /**
     * Get the entries of the Product model
     *
     * @return array
     */

    public function index()
    {
        return Laratables::recordsOf(Product::class, function($query) {
            return $query->whereHas('source', function($q) {
                $q->where('is_main', 1)->with('category')->with('source');
            });
        });
    }

}
