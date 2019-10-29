<?php

namespace App\Http\Controllers\Statistics;

use App\Category;
use App\Exports\CategoryPercentageDifferenceReportExport;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductBinding;
use App\Source;
use App\Statistics\Rating;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class PriceComparisonController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = url()->full();
    }

    /**
     * view the own best prices blade
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function ownBestPrices(Request $request)
    {
        $categories = auth()->user()->categories;

        return view('statistics.own-best-prices', compact('categories'));
    }

    /**
     * Get Statistics of Own Best Prices
     *
     * Also Handles all the filter requests
     *
     * @return \Illuminate\Http\Response
     */

    public function ownBestPricesData(Request $request)
    {
        $categoryId = $request->input('category_id', '');
        $perPage = $request->input('per_page', '10');
        $string = $request->input('search', '');

        $data = Cache::remember(auth()->user()->id . '.own_best_price.' . $this->url, 600, function () use ($categoryId, $string) {
            return (new Rating)->getOwnBestPrices(null, $categoryId, $string);
        });

        $data = $this->filterData($data, $request)->values()->toArray();

        if ($perPage != '*') {
            $result = $this->paginate($data, $perPage, $request);
        } else {
            $result = $data;
        }
        return response()->json($result);
    }

    /**
     * view the competitors best prices blade
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function compBestPrices()
    {
        $categories = auth()->user()->categories;

        return view('statistics.competitors-best-prices', compact('categories'));
    }

    /**
     * Get Statistics of Competitors Best Prices
     *
     * Also Handles all the filter requests
     *
     * @return \Illuminate\Http\Response
     */

    public function compBestPricesData(Request $request)
    {
        $categoryId = $request->input('category_id', '');
        $perPage = $request->input('per_page', '10');
        $string = $request->input('search', '');

        $data = Cache::remember(auth()->user()->id . '.comp_best_price.' . $this->url, 600, function () use ($categoryId, $string) {
            return (new Rating)->getCompBestPrices(null, $categoryId, $string);
        });

        $data = $this->filterData($data, $request)->values()->toArray();

        if ($perPage != '*') {
            $result = $this->paginate($data, $perPage, $request);
        } else {
            $result = $data;
        }

        return response()->json($result);
    }

    public function filterData($data, $request)
    {
        if ($request->columnName != '') {
            $column_name = $request->columnName;
            $order = $request->order;
            if ($column_name == 'product_name') {
                if ($order == 'ASC') {
                    $data = $data->sortBy('name');
                } else {
                    $data = $data->sortByDesc('name');
                }
            } elseif ($column_name == 'category') {
                if ($order == 'ASC') {
                    $data = $data->sortBy('category.name');
                } else {
                    $data = $data->sortByDesc('category.name');
                }
            } elseif ($column_name == 'competitor_name') {
                if ($order == 'ASC') {
                    $data = $data->sortBy('source.name');
                } else {
                    $data = $data->sortByDesc('source.name');
                }
            } else {
                if ($order == 'ASC') {
                    $data = $data->sortBy('difference');
                } else {
                    $data = $data->sortByDesc('difference');
                }
            }
        } else {
            $data = $data->sortBy('difference');
        }

        return $data;
    }

    /**
     * view the competitors best prices blade
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function detailedProductPrice()
    {
        $source_id = Source::where('user_id', auth()->user()->user_id)->value('id');
        $categories = auth()->user()->categories()->orderBy('name', 'asc')->get();
        $products = Product::where('source_id', $source_id)->orderBy('name', 'asc')->get();

        return view('statistics.detailed-product-price', compact('categories', 'products'));
    }

    /**
     * Get Statistics of Detailed
     *
     * Also Handles all the filter requests
     *
     * @return \Illuminate\Http\Response
     */

    public function detailedProductPriceReportData(Request $request)
    {
        $sourceId = Source::where(['user_id' => auth()->user()->user_id, 'is_main' => 1])->value('id');

        $categoryId = $request->input('category_id', '');
        $productId = $request->input('product_id', '');
        $perPage = $request->input('per_page', '10');
        $string = $request->input('search', '');

        $products = Cache::remember(auth()->user()->id . 'detailed_product_price.' . $this->url, 600, function () use ($sourceId, $categoryId, $productId, $string, $perPage, $request) {
            $query = Product::where('source_id', $sourceId)
                ->select('id', 'name', 'price', 'vat_price', 'fetched_at')
                ->with(['bindings.priceEntriesOfBoundProduct', 'bindings.product.source'])
                ->where('price', '>', 0)
                ->where('vat_price', '>', 0)
                ->orderBy('updated_at', 'desc');
            if ($categoryId != '') {
                $query = $query->where('category_id', $categoryId);
            }
            if ($productId != '') {
                $query = $query->where('id', $productId);
            }
            if ($string != '') {
                $query = $query->where('name', 'like', '%' . ucwords($string) . '%');
            }

            $products = $query->get()->each(function ($product) {
                $bindings = $product->bindings->each(function ($bind) use ($product) {
                    $currentPriceInfo = $bind->priceEntriesOfBoundProduct->sortByDesc('fetched_at')->filter(function ($priceEntry) {
                        return ProductBinding::getBoundProductCurrentPrice($priceEntry);
                    })->values()->first();
                    $currentPrice = $currentPriceInfo ? $currentPriceInfo->amount : null;
                    $bind->bound_product_current_price = $currentPrice;

                    $boundProductId = $bind->bound_product_id;
                    $oldPriceInfo = $bind->priceEntriesOfBoundProduct->sortByDesc('fetched_at')->filter(function ($priceEntry) use ($currentPrice, $boundProductId) {
                        return ProductBinding::getBoundProductOldPrice($priceEntry, $currentPrice, $boundProductId);
                    })->values()->first();

                    $oldPrice = $oldPriceInfo ? $oldPriceInfo->amount : $bind->product->amount;
                    $bind->bound_product_old_price = $oldPrice;

                    $bind->old_price_date = $oldPriceInfo ? Carbon::parse($oldPriceInfo->fetched_at)->format('d.m.Y') : Carbon::parse($bind->product->fetched_at)->format('d.m.Y');
                    $bind->bound_product_price_change_percentage = ProductBinding::getBoundProductPriceChangePercentage($currentPrice, $oldPrice);
                    return $bind;
                });

                return $bindings;
            })->toArray();
            return $this->paginate($products, $perPage, $request);
        });

        return response()->json($products);
    }

    /**
     * view the category percentage difference prices blade
     *
     * @return View
     */

//    public function categoryPercentageDifference($param = false)
//    {
//        $dataSet = Cache::remember(auth()->user()->id . '.category_percentage_diff.' . $this->url, 600, function () {
//            $clientCategoryAvgPrices = Product::where('source_id', auth()->user()->user_source_id)
//                ->groupBy('category_id')
//                ->selectRaw('avg(price) as avg, category_id')
//                ->lists('avg', 'category_id');
//            $competitorCategoryAvgPrices = Product::where('source_id', '!=', auth()->user()->user_source_id)->groupBy('category_id')
//                ->where('price', '>', 0)
//                ->where('vat_price', '>', 0)
//                ->selectRaw('avg(price) as avg, category_id')
//                ->lists('avg', 'category_id');
//            $dataSet = [];
//            $categories = Category::whereHas('products')->get();
//            foreach ($categories as $category) {
//                if (isset($clientCategoryAvgPrices[$category->id]) && isset($competitorCategoryAvgPrices[$category->id])) {
//                    $clientAvg = $clientCategoryAvgPrices[$category->id];
//                    $compAvg = $competitorCategoryAvgPrices[$category->id];
//                    $cheaper = $clientAvg < $compAvg ? true : false;
//                    $diff = (($clientAvg - $compAvg) / $clientAvg) * 100;
//                    $data = ['name' => $category->name, 'value' => abs(round($diff, 2)), 'cheaper' => $cheaper];
//                    array_push($dataSet, $data);
//                }
//            }
//            return $dataSet;
//        });
//        if ($param) {
//            return $dataSet;
//        }
//
//        $dataSet = json_encode($dataSet);
//
//        return view('statistics.category-percentage-difference', compact('dataSet'));
//    }

    public function getCsv()
    {
        $dataSet = $this->categoryPercentageDifference(true);

        $rowsData = [];
        $headingRow = ['Category', 'Percentage Difference', 'Is Cheaper?'];
        array_push($rowsData, $headingRow);
        foreach ($dataSet as $item) {
            $row = [$item['name'], $item['value'] . '%', $item['cheaper'] ? 'Yes' : 'No'];
            array_push($rowsData, $row);
        }

        $finalData = [];
        array_push($finalData, [null]);
        array_push($finalData, [date('d.m.Y')]);
        array_push($finalData, [null]);

        foreach ($rowsData as $item) {
            array_push($finalData, $item);
        }

        $heading = 'Category Percentage Difference Report';
        $fileName = 'Category_percentage_difference_report';
        return Excel::download(new CategoryPercentageDifferenceReportExport($finalData, [$heading]), $fileName . '_' . date('d.m.Y') . '.xlsx');
    }

    public function getPdf()
    {
        $dataSet = $this->categoryPercentageDifference(true);

        $rowsData = [];
        $headingRow = ['Category', 'Percentage Difference', 'Is Cheaper?'];
        array_push($rowsData, $headingRow);
        foreach ($dataSet as $item) {
            $row = [$item['name'], $item['value'] . '%', $item['cheaper'] ? 'Yes' : 'No'];
            array_push($rowsData, $row);
        }
        $exportData['datasets'] = $rowsData;
        $heading = 'Category Percentage Difference Report';
        $exportData['headings'] = $heading;
        $fileName = 'Category_percentage_difference_report';
//        return view('templates.category-percentage-difference-data', compact('exportData'));
        $pdf = PDF::loadView('templates.category-percentage-difference-data', compact('exportData'));
        return $pdf->setPaper('a4', 'portrait')->download($fileName . "_Graph_" . date('d.m.Y') . '.pdf');
    }

    /*
     * Pagination function for array
     */
    public function paginate($items, $perPage, $request)
    {

        $page = Input::get('page', 1); // Get the current page or default to 1

        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_slice($items, $offset, $perPage, true),
            count($items), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
}
