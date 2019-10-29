<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\ProductBinding;
use App\Source;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ComparisonController extends Controller
{
    /**
     * Display the comparison of the products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bindings = ProductBinding::whereHas('product', function ($q) {
            $q->where('user_id', auth()->user()->user_id)->where('price', '>', 0)->where('vat_price', '>', 0);
        })->with('mainProduct')->with('product.category', 'product.source')->get()->each(function ($binding
        ) {
            $difference = $binding->product->amount * 100 - $binding->mainProduct->amount * 100;
            $binding->difference = [
                'signed' => formatMoney($difference),
//                'signed' => showVisualDifference($difference) . ' €',
                'colour' => getGradient($difference, true),
            ];
        });
        return view('products.comparison', compact('bindings'));
    }


    /**
     * Function to get the data for trends.
     *
     * @param $startDateTime
     * @param $endDateTime
     * @return array
     */
    public function getTrendingData($startDateTime, $endDateTime)
    {
        $shops = Source::where('user_id', auth()->user()->user_id)->with(["products.priceEntries"])
            ->whereHas('products.priceEntries')
            ->get();
        $shops = $shops->map(function ($shop, $key) use ($startDateTime, $endDateTime) {
            $products = $shop->products->map(function ($product) use ($startDateTime, $endDateTime, $shop) {
                $recentProductPrice = 0;
                $previousProductEntry = 0;
                if ($product->priceEntries->count()) {
                    $recentProductPrice = $product->priceEntries->whereBetween('fetched_at', [$startDateTime, $endDateTime])->first();
                    $recentProductPrice = $recentProductPrice ? $recentProductPrice->amount * 100 : $product->amount * 100;
                    $previousProductEntry = $product->priceEntries->where('fetched_at', '<', $startDateTime)->sortByDesc('fetched_at')->first();
                    $previousProductEntry = $previousProductEntry ? $previousProductEntry->amount * 100 : $recentProductPrice;
                    $priceDifference = $recentProductPrice - $previousProductEntry;
                }

                if ($recentProductPrice != 0 && $previousProductEntry != 0 && $priceDifference != 0) {
                    $pricePercentageDifference = round(($priceDifference / $previousProductEntry) * 100, 2);
                    $temp = [
                        'id' => $product->id,
                        'name' => $shop->name,
                        "product_name" => $product->name,
                        'price_difference' => $pricePercentageDifference,
                    ];
                    if ($recentProductPrice < $previousProductEntry) {
                        $temp['option'] = 'dec';
                    } else {
                        $temp['option'] = 'inc';
                    }
                    return $temp;
                } else {
                    return false;
                }
            });
            return $products->filter();
        });
        $productsArray = $shops->collapse()->sortByDesc('price_difference')->groupBy('option');
        return $productsArray;
    }

    /**
     * For getting data for day.
     *
     * @return array
     */
    public function getProductPerDay(Request $request)
    {
        $data = Cache::remember('getProductPerDay' . auth()->user()->user_id, 60, function () {
            $startOfDay = Carbon::today();
            $presentTime = Carbon::now();
            return $this->getTrendingData($startOfDay, $presentTime);
        });

        if ($request->input('inc') == 1) {
            return isset($data['inc']) ? $data['inc'] : [];
        } elseif ($request->input('inc') == 0) {
            return isset($data['dec']) ? $data['dec'] : [];
        } else {
            return $data;
        }
    }

    /**
     * For getting data for week.
     *
     * @return array
     */
    public function getProductPerWeek(Request $request)
    {
        $data = Cache::remember('getProductPerWeek' . auth()->user()->user_id, 60, function () {
            $starDateOfWeek = Carbon::now()->startOfWeek();
            $endDateOfWeek = Carbon::now()->endOfWeek();
            return $this->getTrendingData($starDateOfWeek, $endDateOfWeek);
        });

        if ($request->input('inc') == 1) {
            return isset($data['inc']) ? $data['inc'] : [];
        } elseif ($request->input('inc') == 0) {
            return isset($data['dec']) ? $data['dec'] : [];
        } else {
            return $data;
        }
    }

    /**
     * For getting data for month.
     *
     * @return array
     */
    public function getProductByMonth(Request $request)
    {
        $data = Cache::remember('getProductByMonth' . auth()->user()->user_id, 60, function () {
//            $startOfMonth = new Carbon('first day of this month');
            $startOfMonth = Carbon::now()->startOfMonth();
            $presentTime = Carbon::now();
            return $this->getTrendingData($startOfMonth, $presentTime);
        });

        if ($request->input('inc') == 1) {
            return isset($data['inc']) ? $data['inc'] : [];
        } elseif ($request->input('inc') == 0) {
            return isset($data['dec']) ? $data['dec'] : [];
        } else {
            return $data;
        }
    }


}
