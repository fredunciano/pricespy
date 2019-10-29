<?php

namespace App\Statistics;

use App\Category;
use App\Source;
use Illuminate\Database\Eloquent\Model;

class Actual extends Model
{
    protected $products;
    protected $productsCount;
    protected $withCompetitors;
    protected $withoutCompetitors;

    // user filters
    protected $competitor = null;

    protected $data;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $categoryId = request()->get('category', null);
        $this->competitor = request()->get('competitor', null);
        $this->products = auth()->user()->ownProducts()->with('competitors')
            ->when($categoryId, function($q) use ($categoryId) {
                return $q->where('category_id', $categoryId);
            })
            ->get();
        $this->productsCount = $this->products->count();
        $this->setProductsWithCompetitors();

        $without = $this->getProductsWithoutCompetitorsCount();
        $higher = $this->getHigherProductsCount();
        $lower = $this->getLowerProductsCount();
        $equal = $this->getEqualProductsCount();
        $this->data = collect([
            'without' => [
                'label' => t('no_competitor') . ' - ' . $this->getLabel($without, $this->productsCount),
                'values' => $without,
                'background' => '#ff4d6a',
                'border' => '#ff4d6a',
            ],
            'higher' => [
                'label' => t('overpriced') . ' - ' . $this->getLabel($higher, $this->productsCount),
                'values' => $higher,
                'background' => '#ff6a4d',
                'border' => '#ff6a4d',
            ],
            'lower' => [
                'label' => t('underpriced') . ' - ' . $this->getLabel($lower, $this->productsCount),
                'values' => $lower,
                'background' => '#38cfa2',
                'border' => '#38cfa2',
            ],
            'equal' => [
                'label' => t('equal') . ' - ' . $this->getLabel($equal, $this->productsCount),
                'values' => $equal,
                'background' => '#2ea8cf',
                'border' => '#2ea8cf',
            ],
        ]);
    }

    public function get()
    {
        return $this->prepareChartsData();
    }

    protected function prepareChartsData()
    {
        return json_encode([
            'labels' => $this->data->map(function($group) {
                return $group['label'];
            })->values(),
            'values' => $this->data->map(function($group) {
                return $group['values'];
            })->values(),
            'background' => $this->data->map(function($group) {
                return $group['background'];
            })->values(),
            'border' => $this->data->map(function($group) {
                return $group['border'];
            })->values(),
        ]);
    }

    protected function getProductsWithoutCompetitorsCount()
    {
        return (clone($this->products))->filter(function($product) {
            return $this->getCompetitors($product)->isEmpty();
        })->count();
    }

    protected function setProductsWithCompetitors()
    {
        $this->withCompetitors = (clone($this->products))->filter(function($product) {
            return $product->competitors->isNotEmpty();
        });
        return $this;
    }

    protected function getLowerProductsCount()
    {
        return $this->getProductsWithCompetitors()->filter(function($product) {
            return $product->isWorseOnAverage($this->getCompetitors($product));
        })->count();
    }

    protected function getHigherProductsCount()
    {
        return $this->getProductsWithCompetitors()->filter(function($product) {
            return $product->isBetterOnAverage($this->getCompetitors($product));
        })->count();
    }

    protected function getEqualProductsCount()
    {
        return $this->getProductsWithCompetitors()->filter(function($product) {
            return $product->isEqualOnAverage($this->getCompetitors($product));
        })->count();
    }

    protected function getProductsWithCompetitors()
    {
        return (clone($this->withCompetitors));
    }

    protected function getLabel($value, $total)
    {
        return $total ? percentise($value / $this->productsCount) : '0.00%';
    }

    protected function getCompetitors($product)
    {
        if ($this->competitor) {
            return $product->competitors->where('source_id', $this->competitor);
        }

        return $product->competitors;
    }

    /*
     * EXPORT FUNCTIONS
     */

    public function generateData()
    {
        $categoryId = request()->get('category', null);
        $competitorId = request()->get('competitor', null);

        if ($categoryId) {
            $catName = Category::where('id', $categoryId)->value('name');
        } else {
            $catName = 'All';
        }
        if ($categoryId) {
            $compName = Source::where('id', $competitorId)->value('name');
        } else {
            $compName = 'All';
        }

        $rowsData = [['Type', 'Total Products', 'Percentage']];
        $totalProduct = 0;
        foreach ($this->data as $item) {
            $label = explode(' - ', $item['label']);
            $type = $label[0];
            $percentage = $label[1];
            $value = $item['values'];
            $rowData = [$type, (string)$value, $percentage];
            array_push($rowsData, $rowData);
            $totalProduct += $value;
        }

        return [$rowsData, $totalProduct, $catName, $compName];
    }

    public function getExportData()
    {
        $data = $this->generateData();
        $rowsData = $data[0];
        $totalProduct = $data[1];
        $catName = $data[2];
        $compName = $data[3];

        $finalData = [];

        array_push($finalData, [null]);
        array_push($finalData, ['This table has market distribution report for your products']);
        array_push($finalData, ["Result calculated from - Total Products: $totalProduct, Category: $catName, Competitor: $compName "]);
        array_push($finalData, [date('d.m.Y')]);
        array_push($finalData, [null]);
        foreach ($rowsData as $item) {
            array_push($finalData, $item);
        }

        return ['headings' => ['Market Distribution Report'], 'rowsData' => $finalData];
    }

    public function getExportDataForPdf()
    {
        $data = $this->generateData();
        $rowsData = $data[0];
        $totalProduct = $data[1];
        $catName = $data[2];
        $compName = $data[3];
        $filterInfo = "Result calculated from - Total Products: $totalProduct, Category: $catName, Competitor: $compName ";
        return ['rowsData' => $rowsData, 'filterInfo' => $filterInfo];
    }
}
