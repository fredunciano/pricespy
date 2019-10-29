<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductBinding;
use App\Source;
use Illuminate\Http\Request;

class BindingsController extends Controller
{

    /**
     * @toDo Rename and move away
     * Loads the bindings for a specific product
     *
     * @param Product $product
     *
     * @return mixed
     */

    public function load(Product $product)
    {
        return $product->bindings()->with('product')->get()->map(function($binding) {
               return [
                   'id' => $binding->product->id,
                   'name' => $binding->product->name,
                   'source' => $binding->product->source_id,
               ];
        });
    }

    /**
     * Edit products bindings
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $products = auth()->user()->products()->whereHas('source', function($q) {
            $q->where('is_main', 1);
        })->orderBy('name', 'asc')->get();

        $sources = Source::where('user_id', auth()->user()->user_id)->where('is_main', 0)->select('id', 'name')->with('products:id,name,user_id,source_id')->get();
        $allBoundId = Product::where('user_id', auth()->user()->user_id)->whereHas('bindings')->with('bindings')->get()->map(function ($product) {
            $boundId = $product->bindings->map(function ($bind) {
                return $bind->bound_product_id;
            })->toArray();
            return $boundId;
        });
        $boundIds = [];
        foreach ($allBoundId as $item) {
            foreach ($item as $id) {
                array_push($boundIds, $id);
            }
        }

        $totalBind = $allBoundId->count();
        return view('products.binding', compact('products', 'sources', 'totalBind', 'boundIds'));
    }

    /**
     * Store the product bindings
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $mainProduct = auth()->user()->products()->find($request->get('main-product'));
        $mainProduct->bindings()->delete();

        if ($request->has('products')) {
            foreach ($request->products as $ids) {
                auth()->user()->products()->whereIn('id', $ids)->get()->each(function($product) use ($mainProduct) {
                    $mainProduct->bindings()->create([
                        'bound_product_id' => $product->id
                    ]);
                });
            }
        }

        return back()->with('success', 'changes_saved')->with('product', $mainProduct->id);
    }

    /**
     * Delete a binding between products
     *
     * @param ProductBinding $binding
     * @return int
     * @throws \Exception
     */

    public function destroy(ProductBinding $binding)
    {
        $binding->delete();
        return 0;
    }
}
