<?php

namespace App\Http\Controllers;

use App\Category;
use App\Exports\CategoryPriceComparisonExport;
use App\Exports\MarketDistributionExport;
use App\Http\Controllers\Products\ComparisonController;
use App\Product;
use App\Source;
use App\Statistics\Actual;
use App\Statistics\LineChartData;
use App\Statistics\Rating;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class IndexController extends Controller
{
    protected $url;

    public function __construct()
    {
        $this->url = url()->full();
    }

    public function index(Request $request)
    {
        $chartData = Cache::remember(auth()->user()->id . '.$chartData.' . $this->url, 600, function () {
            return (new Actual)->get();
        });

        if ($request->has('get-market-distribution-data')) {
            return $chartData;
        }

        $lineChartData = Cache::remember(auth()->user()->id . '.$lineChartData.' . $this->url, 600, function () {
            return json_encode((new LineChartData())->get());
        });

        $topStats = Cache::remember(auth()->user()->id . '.$topStats.' . $this->url, 600, function () {
            $totalProducts = auth()->user()->products()->count();
            $totalConnectedCompetitors = auth()->user()->competitors()->count();
            $totalLastDayPriceChanges = Cache::remember('getProductPerDay' . auth()->user()->user_id, 60, function () {
                $startOfDay = Carbon::today();
                $presentTime = Carbon::now();
                return (new ComparisonController())->getTrendingData($startOfDay, $presentTime);
            });
            $totalLastDayPriceChanges = (isset($totalLastDayPriceChanges['inc']) ? count($totalLastDayPriceChanges['inc']) : 0)
            + (isset($totalLastDayPriceChanges['dec']) ? count($totalLastDayPriceChanges['dec']) : 0);

            $sourceId = Source::where(['user_id' => auth()->user()->id, 'is_main' => 1])->value('id');
            $totalCheaperProduct = Product::where('source_id', $sourceId)->with('bindings.product')->get()
                ->map(function ($product) {
                    $cheaper = 0;
                    foreach ($product->bindings as $bound) {
                        $product->amount < $bound->product->amount ? $cheaper += 1 : $cheaper += 0;
                    }
                    return $cheaper;
                })->sum();
            return array(
                'totalProducts' => $totalProducts,
                'totalConnectedCompetitors' => $totalConnectedCompetitors,
                'totalLastDayPriceChanges' => $totalLastDayPriceChanges,
                'totalCheaperProduct' => $totalCheaperProduct,
            );

        });

        $topData = Cache::remember(auth()->user()->id . '.$topData.' . $this->url, 600, function () {
            return (new Rating)->get();
        });

        $categories = Cache::remember(auth()->user()->id . 'categories', 600, function () {
            return Category::where('user_id', auth()->user()->user_id)->whereHas('products')->get();
        });
        $competitors = Cache::remember(auth()->user()->id . 'competitors', 600, function () {
            return auth()->user()->competitors;
        });
        return view('home', compact('topStats', 'lineChartData', 'chartData', 'topData', 'categories', 'competitors'));
    }

    public function getLineChartData()
    {
        $lineChartData = Cache::remember(auth()->user()->id . '.$lineChartData.' . $this->url, 600, function () {
            return json_encode((new LineChartData())->get());
        });
        return $lineChartData;
    }

    public function lineChartExportData()
    {
        $exportData = Cache::remember(auth()->user()->id . '.$exportData.' . $this->url, 600, function () {
            return (new LineChartData)->getExportData();
        });

        return Excel::download(new CategoryPriceComparisonExport($exportData['headings'], $exportData['rowsData']), 'Category_Price_Comparison_Graph_' . date('d.m.Y') . '.xlsx');
    }

    public function lineChartExportInPdf()
    {
        $exportData = Cache::remember(auth()->user()->id . '.lineChartExportInPdf.' . $this->url, 600, function () {
            return (new LineChartData)->getExportDataForPdf();
        });
//        return view('templates.line-chart-data', compact('exportData'));
        $pdf = PDF::loadView('templates.line-chart-data', compact('exportData'));
        return $pdf->download('Category_Price_Comparison_Graph_' . date('d.m.Y') . '.pdf');
    }

    public function pieChartExportData()
    {
        $exportData = Cache::remember(auth()->user()->id . '.$pieExportData.' . $this->url, 600, function () {
            return (new Actual)->getExportData();
        });

        return Excel::download(new MarketDistributionExport($exportData['headings'], $exportData['rowsData']), 'Market_Distribution_Graph_' . date('d.m.Y') . '.xlsx');
    }

    public function pieChartExportInPdf()
    {
        $exportData = Cache::remember(auth()->user()->id . '.pieChartExportInPdf.' . $this->url, 600, function () {
            return (new Actual)->getExportDataForPdf();
        });
//        return view('templates.pie-chart-data', compact('exportData'));
        $pdf = PDF::loadView('templates.pie-chart-data', compact('exportData'));
        return $pdf->download('Market_Distribution_Graph_' . date('d.m.Y') . '.pdf');
    }

    public function statistics()
    {
        return view('statistics');
    }
}
