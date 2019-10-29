<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Controller;

class WatchController extends Controller
{

    /**
     * Enabled product watching
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */

    public function store(Product $product)
    {
        $product->update(['is_watched' => 1]);
        return back()->with('success', 'changes_saved');
    }

    /**
     * Disables the product watching
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Product $product)
    {
        $product->update(['is_watched' => 0]);
        return back()->with('success', 'changes_saved');
    }

}
