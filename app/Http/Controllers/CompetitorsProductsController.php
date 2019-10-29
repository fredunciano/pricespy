<?php

namespace App\Http\Controllers;

use App\Product;
use App\Source;
use App\User;
use Illuminate\Http\Request;

class CompetitorsProductsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $stores = auth()->user()->sources()->where('is_main', 0)->get();
        return view('competitors.products.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stores = auth()->user()->competitors;
        if ($stores->count() == 0) {
            return redirect()->back()->with('error', 'competitors_shop_not_found');
        }
        $categories = auth()->user()->categories;
        if ($categories->isEmpty()) {
            return redirect('/')->with('error', 'please-create-categories');
        }
        return view('competitors.products.create', compact('stores', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Product::$validation);

        if (!Source::where('user_id', auth()->user()->user_id)->where('id', $request->source_id)->count()) {
            abort(422);
        }
        $data = $request->input();
        if ($request->hasFile('image')) {
            $data['image'] = User::saveFile($request->file('image'), 'products/' . auth()->id(), $request->image);
        }
        if (!Source::where('user_id', auth()->user()->user_id)->where('id', $request->source_id)->count()) {
            abort(422);
        }

        Product::add($data);

        return redirect()->route('products.index')->with('success', 'product.create.success');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        if ($product->source->is_main) {
            abort(404);
        }
        $stores = auth()->user()->competitors;
        $categories = auth()->user()->categories;
        return view('products.edit', compact('product', 'stores', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if (!Source::where('user_id', auth()->id())->where('id', $request->source_id)->count()) {
            abort(422);
        }
        $request->validate(Product::$validation);
        $data = $request->input();
        if ($request->hasFile('image')) {
            $data['image'] = User::saveFile($request->file('image'), 'products/' . auth()->id(), $request->image);
        }
        if (($request->has('delete-image') && $request->hasFile('image')) || $request->has('delete-image')) {
            User::deleteFile($product->image);
            $data['image'] = null;
        }
        $product->modify($data);
        return back()->with('success', 'product.update.success');
    }
}
