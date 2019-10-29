<?php

namespace App\Imports;

use App\Category;
use App\CsvErrorProduct;
use App\Product;
use App\Source;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithBatchInserts, WithHeadingRow, WithChunkReading
{
    protected $shopType;
    protected $myShop;
    protected $categories;
    protected $products;
    protected $sources;
    protected $file;
    protected $headings;
    protected $failedProducts = [];
    protected $totalUploaded = 0;
    protected $enable_price_override;
    protected $isUpdate;

    public function __construct($shopType, $enable_price_override, $isUpdate, $file = null, $headings = null)
    {
        if ($file) {
            $this->file = $file;
        }
        if ($headings) {
            $this->headings = $headings;
        }
        $this->shopType = $shopType;
        $this->isUpdate = $isUpdate;
        $this->enable_price_override = $enable_price_override;
        $this->myShop = auth()->user()->mainSource;
        $categories = Category::where('user_id', auth()->user()->user_id)->select('id', 'name')->get()->toArray();
        $this->categories = collect($categories)->map(function ($item) {
            $item['name'] = strtoupper($item['name']);
            return $item;
        });
        $products = Product::where('user_id', auth()->user()->user_id)->select('id', 'name')->get();
        $this->products = collect($products)->map(function ($item) {
            $item['name'] = strtoupper($item['name']);
            return $item;
        });
        $sources = Source::where('user_id', auth()->user()->user_id)->select('id', 'name', 'vat')->get();
        $this->sources = collect($sources)->map(function ($item) {
            $item['name'] = strtoupper($item['name']);
            return $item;
        });
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function collection(Collection $rows)
    {
        if ($this->shopType == 4) {
            $rows = $this->formatOpenCartCsvData();
        } elseif ($this->shopType == 5) {
            $rows = $this->formatPrestaShopCsvData();
        } elseif ($this->shopType == 7) {
            $rows = $this->formatShopWareData();
        }

        if ($rows instanceof Collection == false && $rows == 401) {
            $v = \Validator::make([], []);
            $v->errors()->add('file', 'File data is not formatted');
            return back()->withErrors($v->errors()->messages());
        }

        foreach ($rows as $row) {
            switch ($this->shopType) {
                case 1:
                    $this->priceFeedRow($row);
                    break;
                default:
                    $this->otherTypeRow($row);
            }
        }
        $this->setCsvErrorProducts();

        return null;
    }

    public function priceFeedRow($row)
    {
        $source = collect($this->sources)->where('name', strtoupper($row['store']))->first();

        $vatDivisor = $source && $source->vat ? $source->vat / 100 + 1 : 19 / 100 + 1;
        if ($row['netto'] == null && $row['brutto'] != null) {
            $row['netto'] = round((float)priceToFloat($row['brutto']) / $vatDivisor, 2);
        }
        $vatPrice = (float)priceToFloat($row['netto']) * $vatDivisor;
        $categoryId = collect($this->categories)->where('name', strtoupper($row['category']))->first()['id'];
        $data['source_id'] = $source ? $source->id : null;
        $data['source_name'] = $row['store'];
        $data['user_id'] = auth()->user()->user_id;
        $data['category_id'] = $categoryId;
        $data['category_name'] = $row['category'];
        $data['origin'] = 'csv';
        $data['price'] = round(priceToFloat($row['netto']), 2);
        $data['vat_price'] = ($row['brutto'] != '' && $row['brutto'] != null) ? round(priceToFloat($row['brutto']), 2) : round($vatPrice, 2);
        $data['system_calculated_vat_price'] = round($vatPrice, 2);
        $data['is_manual'] = 1;
        $data['fetched_at'] = Carbon::now();
        if ($this->isUpdate) {
            $data['name'] = $row['product_name'];
            $data['product_id'] = $row['product_id'];
            $data['product_name_exist'] = true;
            $data['temp_id'] = md5(strtoupper($row['product_name'])) . uniqid() . uniqid();
            $data['min_price'] = null;
            $data['max_price'] = null;
            $data['link'] = null;
            $productNameExist = true;
            $data['product_name_exist'] = $productNameExist;
        } else {
            $productNameExist = collect($this->products)->where('name', strtoupper($row['name']))->where('source_id', $data['source_id'])->first() ? true : false;
            if ($productNameExist) {
                $data['product_id'] = collect($this->products)->where('name', strtoupper($row['name']))->where('source_id', $data['source_id'])->first()->id;
            } else {
                $data['product_id'] = null;
            }
            $data['name'] = $row['name'];
            $data['min_price'] = $row['min_price'] ? round(priceToFloat($row['min_price']), 2) : null;
            $data['max_price'] = $row['max_price'] ? round(priceToFloat($row['max_price']), 2) : null;
            $data['purchase_price'] = $row['purchase_price'] ? round(priceToFloat($row['purchase_price']), 2) : null;
            $data['shipping_cost'] = $row['shipping_cost'] ? round(priceToFloat($row['shipping_cost']), 2) : null;
            $data['link'] = $row['link'];
            $data['manual_override'] = $this->setManualOverrideValue($row['link'], $row['manual_override']);
            $data['product_name_exist'] = $productNameExist;
            $data['temp_id'] = md5(strtoupper($row['name'])) . uniqid() . uniqid();
        }
        $validateResult = $this->validateProduct($data);
        if ($validateResult === true ||
            (isset($validateResult['errors']) && count($validateResult['errors']) == 1 && $productNameExist)) {
            $product = $this->productSave($data);
            if (!$this->isUpdate) {
                $this->products->push($product->only('id', 'name', 'amount'));
                $this->totalUploaded += 1;
            }
        } else {
            array_push($this->failedProducts, $validateResult);
        }
    }

    public function otherTypeRow($row)
    {
        switch ($this->shopType) {
            case 2:
                $categories = explode('/', $row['categories']);
                $productNameExist = collect($this->products)->where('name', strtoupper($row['name']))->first() ? true : false;
                $data['name'] = $row['name'];
                $data['product_name_exist'] = $productNameExist;
                $data['category_name'] = $row['categories'];
                break;
            case 3:
                $categories = explode('/', $row['category']);
                $productNameExist = collect($this->products)->where('name', strtoupper($row['product_name']))->first() ? true : false;
                $data['name'] = $row['product_name'];
                $data['product_name_exist'] = $productNameExist;
                $data['category_name'] = $row['category'];
                break;
            case 4:
                $categories = str_replace('"', '', explode('///', $row['categories']));
                $productNameExist = collect($this->products)->where('name', strtoupper($row['name']))->first() ? true : false;
                $data['name'] = $row['name'];
                $data['product_name_exist'] = $productNameExist;
                $data['category_name'] = str_replace('"', '', $row['categories']);
                break;
            case 5:
                $categories = explode(',', $row['category']);
                $productNameExist = collect($this->products)->where('name', strtoupper($row['name']))->first() ? true : false;
                $data['name'] = $row['name'];
                $data['product_name_exist'] = $productNameExist;
                $data['category_name'] = str_replace('"', '', strtoupper($row['category']));
                break;
            case 6:
                $categories = explode(',', $row['type']);
                $productNameExist = collect($this->products)->where('name', strtoupper($row['handle']))->first() ? true : false;
                $data['name'] = $row['handle'];
                $data['product_name_exist'] = $productNameExist;
                $data['category_name'] = str_replace('"', '', strtoupper($row['type']));
                $row['price'] = $row['variant_price'];
                break;
            case 7:
                $categories = explode('|', $row['categories']);
                $productNameExist = collect($this->products)->where('name', strtoupper($row['name']))->first() ? true : false;
                $data['name'] = $row['name'];
                $data['product_name_exist'] = $productNameExist;
                $data['category_name'] = str_replace('"', '', $row['categories']);
                break;
        }

        $categoryId = null;
        $sysCategories = collect($this->categories);
        foreach ($categories as $category) {
            $selected = $sysCategories->where('name', strtoupper($category))->first();
            if ($selected) {
                $categoryId = $selected['id'];
                break;
            } else {
                continue;
            }
        }

        $source = $this->myShop;
        $vatDivisor = $source ? $source->vat / 100 + 1 : 19 / 100 + 1;

        if ($this->shopType == 5) {
            $price = round((float)priceToFloat($row['price']), 2);
            $vatPrice = round((float)priceToFloat($row['price']) * $vatDivisor, 2);
        } else {
            $price = round((float)priceToFloat($row['price']) / $vatDivisor, 2);
            $vatPrice = round((float)priceToFloat($row['price']), 2);
        }
        $data['temp_id'] = md5(strtoupper($row['name'])) . uniqid();
        $data['source_id'] = $this->myShop->id;
        $data['source_name'] = $this->myShop->name;
        $data['user_id'] = auth()->user()->user_id;
        $data['category_id'] = $categoryId;

        $data['origin'] = 'csv';

        $data['price'] = $price;
        $data['vat_price'] = $vatPrice;
        $data['min_price'] = null;
        $data['max_price'] = null;
        $data['purchase_price'] = null;
        $data['shipping_cost'] = null;
        $data['system_calculated_vat_price'] = $vatPrice;
        $data['link'] = null;
        $data['manual_override'] = $this->setManualOverrideValue($data['link']);
        $data['is_manual'] = 1;
        $data['fetched_at'] = Carbon::now();

        $validateResult = $this->validateProduct($data);

        if ($validateResult === true) {
            $product = $this->productSave($data);
            $this->products->push($product->only('id', 'name', 'amount'));
            $this->totalUploaded += 1;
        } else {
            array_push($this->failedProducts, $validateResult);
        }
    }

    public function formatOpenCartCsvData()
    {
        try {
            $csv = fopen($this->file, 'r');
            $data = array_map('str_getcsv', file($this->file));
            fclose($csv);
            $nameKey = array_search('name', $this->headings);
            $catKey = array_search('category', $this->headings);
            $priceKey = array_search('price', $this->headings);
            $rows = array_slice($data, 1);
            $products = [];
            foreach ($rows as $row) {
                $row = explode(';', implode(',', $row));
                $product['name'] = $row[$nameKey];
                $product['categories'] = $row[$catKey];
                $product['price'] = $row[$priceKey];
                array_push($products, $product);
            }
            return $products;
        } catch (\Throwable $throwable) {
            return 401;
        }
    }

    public function formatPrestaShopCsvData()
    {
        try {
            $csv = fopen($this->file, 'r');
            $data = array_map('str_getcsv', file($this->file));
            fclose($csv);

            $nameKey = array_search('Name*', $this->headings);
            $catKey = array_search('Categories (x,y,z,...)', $this->headings);
            $priceKey = array_search('Price tax excl. Or Price tax excl', $this->headings);
            $rows = array_slice($data, 1);

            $products = [];
            foreach ($rows as $row) {
                $row = explode(';', implode(',', $row));
                $product['name'] = $row[$nameKey];
                $product['category'] = $row[$catKey];
                $product['price'] = $row[$priceKey];
                array_push($products, $product);
            }
            return $products;
        } catch (\Throwable $throwable) {
            return 401;
        }
    }

    public function formatShopWareData()
    {
        try {
            $csv = fopen($this->file, 'r');
            $data = array_map('str_getcsv', file($this->file));
            fclose($csv);
            $nameKey = array_search('name', $this->headings);
            $catKey = array_search('categories', $this->headings);
            $priceKey = array_search('price_EK', $this->headings);
            $rows = array_slice($data, 1);
            $products = [];
            foreach ($rows as $row) {
                $row = explode(';', implode(',', $row));
                $product['name'] = $row[$nameKey];
                $product['categories'] = $row[$catKey];
                $product['price'] = $row[$priceKey];
                array_push($products, $product);
            }
            return $products;
        } catch (\Throwable $throwable) {
            return 401;
        }
    }

    public function validateProduct($data)
    {
        return Product::validateAndSetErrors($data);
    }

    public function productSave($data)
    {
        if ($data['product_id'] != null) {
            return Product::updatePrice($data);
        } else {
            return Product::addFromCsv($data);
        }
    }


    public function setManualOverrideValue($link, string $value = null)
    {
        if ($link) {
            return $this->enable_price_override ? true : false;
        }

        $value = strtoupper($value);
        if ($value == 'YES' || $value == 'TRUE' || $value == '1') {
            return true;
        } else if ($value == 'NO' || $value == 'FALSE' || $value == '0') {
            return false;
        } else {
            return false;
        }
    }

    public function setCsvErrorProducts()
    {
        $allFailedProducts = $this->failedProducts;

        $products = [];
        foreach ($allFailedProducts as $product) {
            $data = [
                'temp_id' => $product['temp_id'],
                'user_id' => auth()->user()->user_id,
                'description' => json_encode($product)
            ];
            array_push($products, $data);
        }

        CsvErrorProduct::insert($products);
    }

//    public function setCacheValue()
//    {
//        $totalUploadedExists = Cache::has('totalUploaded' . auth()->user()->user_id);
//        if ($totalUploadedExists) {
//            $this->totalUploaded = (int)Cache::get('totalUploaded' . auth()->user()->user_id) + $this->totalUploaded;
//            Cache::forget('totalUploaded' . auth()->user()->user_id);
//        }
//        $totalUploaded = $this->totalUploaded;
//        Cache::rememberForever('totalUploaded' . auth()->user()->user_id, function () use ($totalUploaded) {
//            return (int)$totalUploaded;
//        });
//
//        $isExists = Cache::has('failedProducts' . auth()->user()->user_id);
//        if ($isExists) {
//            $allFailedProducts = collect(Cache::get('failedProducts' . auth()->user()->user_id))->values()->toArray();
//            $this->failedProducts = array_merge($allFailedProducts, $this->failedProducts);
//            Cache::forget('failedProducts' . auth()->user()->user_id);
//        }
//        $allFailedProducts = $this->failedProducts;
//
//        Cache::rememberForever('failedProducts' . auth()->user()->user_id, function () use ($allFailedProducts) {
//            return $allFailedProducts;
//        });
//    }

}
