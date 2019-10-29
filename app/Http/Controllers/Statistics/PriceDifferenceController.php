<?php

namespace App\Http\Controllers\Statistics;

use App\Category;
use App\Exports\TrendingCategoryReportExport;
use App\Http\Controllers\Controller;
use App\ProductBinding;
use App\Source;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class PriceDifferenceController extends Controller
{
    public function index()
    {
        $competitors = Source::where('is_main', 0)->where('user_id', auth()->user()->user_id)->get();
        $categories = auth()->user()->categories;
        return view('statistics.priceDifferenceByCategory', compact('competitors', 'categories'));
    }

    public function getDataForCategory(Category $category)
    {
        $getProducts = Cache::remember(auth()->user()->id . '.getDataForCategory.' . url()->full(), 600, function () use ($category) {
            return ProductBinding::with([
                'product',
                'mainProduct'
            ])->whereHas('mainProduct', function ($q) use ($category) {
                $q->where('category_id', $category->id)
                    ->where('price', '>', 0)
                    ->where('vat_price', '>', 0);
            })->get()->map(function ($getProduct) {
                return [
                    'label' => [$getProduct->mainProduct->name],
                    'backgroundColor' => getGradientChart($getProduct->price_difference, true),
                    'borderColor' => getGradientChart($getProduct->price_difference, true),
                    'data' =>
                        [
                            [
                                'x' => round($getProduct->percentage_difference, 2),
                                'y' => round($getProduct->price_difference, 2),
                                'r' => 7
                            ]
                        ],
                ];
            });
        });
        return response()->json($getProducts);
    }

    public function getDataForCompetitor(Request $request)
    {

        $source_id = $request->competitor_id;
        $getProducts = Cache::remember(auth()->user()->id . '.getDataForCompetitor.' . url()->full(), 600, function () use ($source_id) {
            return ProductBinding::with([
                'product',
                'mainProduct'
            ])->whereHas('product', function ($query) use ($source_id) {
                $query->where('price', '>', 0)
                    ->where('vat_price', '>', 0);
                if ($source_id !== '0') {
                    $query->where('source_id', $source_id);
                }
            })->get()->map(function ($getProduct) {
                return [
                    'label' => [$getProduct->mainProduct->name],
                    'backgroundColor' => getGradientChart($getProduct->price_difference, true),
                    'borderColor' => getGradientChart($getProduct->price_difference, true),
                    'data' =>
                        [
                            [
                                'x' => $getProduct->percentage_difference,
                                'y' => $getProduct->price_difference,
                                'r' => 7,
                            ]
                        ]
                ];
            });
        });
        return response()->json($getProducts);
    }

    public function getCsv(Request $request)
    {
        $data = json_decode($request->data);
        if ($request->type == 0) {
            $heading = 'Price Difference By Category: ' . $request->category_name;
            $fileName = "Category_Report_" . $request->category_name;
        } else {
            $heading = 'Price Difference By Competitor: ' . $request->competitor_name;
            $fileName = "Comparison_with_competitor_Report_" . $request->competitor_name;
        }

        $rowsData = [];
        $headingRow = ['Product', 'Percentage Difference', 'Price Difference'];
        array_push($rowsData, $headingRow);
        foreach ($data as $item) {
            $row = [$item[0], $item[1]->x . '%', formatMoney($item[1]->y)];
            array_push($rowsData, $row);
        }

        $finalData = [];
        array_push($finalData, [null]);
        array_push($finalData, [date('d.m.Y')]);
        array_push($finalData, [null]);

        foreach ($rowsData as $item) {
            array_push($finalData, $item);
        }

        return Excel::download(new TrendingCategoryReportExport($finalData, [$heading]), $fileName . '_' . date('d.m.Y') . '.xlsx');
    }

    /**
     * Generate Excel Report.
     *
     * @param  Request $request
     * Returns PDF File
     */

    public function getPdf(Request $request)
    {
        $data = json_decode($request->data);
        if ($request->type == 0) {
            $heading = 'Price Difference By Category: ' . $request->category_name;
            $fileName = "Category_Report_" . $request->category_name;
        } else {
            $heading = 'Price Difference By Competitor: ' . $request->competitor_name;
            $fileName = "Comparison_with_competitor_Report_" . $request->competitor_name;
        }

        $rowsData = [];
        $headingRow = ['Product', 'Percentage Difference', 'Price Difference'];
        array_push($rowsData, $headingRow);
        foreach ($data as $item) {
            $row = [$item[0], $item[1]->x . '%', formatMoney($item[1]->y)];
            array_push($rowsData, $row);
        }
        $exportData['datasets'] = $rowsData;
        $exportData['headings'] = $heading;

//        return view('templates.price-difference-by-category-data', compact('exportData'));
        $pdf = PDF::loadView('templates.price-difference-by-category-data', compact('exportData'));
        return $pdf->setPaper('a4', 'portrait')->download($fileName . "_Graph_" . date('d.m.Y') . '.pdf');
    }

}
